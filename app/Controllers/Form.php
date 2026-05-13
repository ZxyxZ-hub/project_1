<?php

namespace App\Controllers;
use App\Models\FormModel;

class Form extends BaseController
{
    public function index()
    {
        $model = new FormModel();
        $data['forms'] = $model->findAll();
        return view('form_page', $data);
    }

    public function save()
    {
        $model = new FormModel();
        $session = session();

        $dataToSave = [
            'from_name' => $this->request->getPost('from_name'),    
            'date_received' => $this->request->getPost('date_received'),
            'origin' => $this->request->getPost('origin'),
            'reference_no' => $this->request->getPost('reference_no'),
            'subject' => $this->request->getPost('subject'),
            'date_issued' => $this->request->getPost('date_issued'),
            'instructions' => $this->request->getPost('instructions'),
            'target_date' => $this->request->getPost('target_date'),
            'created_by' => $session->get('username') ? $session->get('username') : null,
        ];

        try {
            $model->save($dataToSave);
        } catch (\Throwable $e) {
            // If the DB is missing the created_by column, add it and retry once
            $msg = $e->getMessage();
            if (stripos($msg, "Unknown column 'created_by'") !== false || stripos($msg, 'created_by') !== false) {
                try {
                    $db = db_connect();
                    $db->query("ALTER TABLE `forms` ADD COLUMN `created_by` VARCHAR(100) NULL");
                    // Retry save once
                    $model->save($dataToSave);
                } catch (\Throwable $ex) {
                    log_message('error', 'Failed to add created_by column or save: ' . $ex->getMessage());
                    $data['forms'] = $model->findAll();
                    $data['error'] = 'Failed to save entry: ' . $ex->getMessage();
                    return view('form_page', $data);
                }
            } else {
                log_message('error', 'Save error: ' . $e->getMessage());
                $data['forms'] = $model->findAll();
                $data['error'] = 'Failed to save entry: ' . $e->getMessage();
                return view('form_page', $data);
            }
        }

        // If saved successfully, record history entry for creation
        try {
            $historyData = [
                'item_table' => 'forms',
                'item_id' => $model->getInsertID(),
                'action' => 'created',
                'actor' => $session->get('username') ?: null,
                'actor_full_name' => $session->get('full_name') ?: null,
                'action_at' => date('Y-m-d H:i:s'),
                'from_name' => $dataToSave['from_name'] ?: null,
                'subject' => $dataToSave['subject'] ?: null,
                'date_received' => $dataToSave['date_received'] ?: null,
                'details' => json_encode($dataToSave),
            ];

            $historyModel = new \App\Models\HistoryModel();
            $historyModel->save($historyData);
        } catch (\Throwable $e) {
            log_message('error', 'Failed to save history after create: ' . $e->getMessage());
        }

        // Instead of redirecting (which in this environment sometimes causes
        // the browser to show "page can't be reached" even though the save
        // succeeded), render the form page immediately with the updated
        // data and a success message. This ensures the client receives a
        // normal 200 response and the shout toast appears without a follow
        // up redirect that may fail.
        $data['forms'] = $model->findAll();
        $data['success'] = 'Saved successfully.';

        return view('form_page', $data);
    }

    public function view($id)
    {
        $model = new FormModel();

        // Validate id: we expect a numeric primary key. If it's not numeric,
        // return to the listing with an error message so the user can choose
        // a valid record. This prevents the 404 route error when a bad link
        // like "form/view/form" is requested.
        if (!is_numeric($id)) {
            $data['forms'] = $model->findAll();
            $data['error'] = 'Invalid record selected.';
            return view('form_page', $data);
        }

        $data['form'] = $model->find($id);
        if (! $data['form']) {
            $data['forms'] = $model->findAll();
            $data['error'] = 'Record not found.';
            return view('form_page', $data);
        }

        return view('view_page', $data);
    }

    public function delete()
    {
        try {
            $action = $this->request->getPost('action');
            
            if ($action === 'delete_single') {
                $id = $this->request->getPost('id');
                if (!$id) {
                    return $this->response->setJSON(['success' => false, 'message' => 'No ID provided']);
                }
                
                $model = new FormModel();
                // Get the existing record to capture details for history
                $db = db_connect();
                $row = $db->table('forms')->where('id', $id)->get()->getRowArray();
                try {
                    $historyModel = new \App\Models\HistoryModel();
                    $historyModel->save([
                        'item_table' => 'forms',
                        'item_id' => $id,
                        'action' => 'deleted',
                        'actor' => session()->get('username') ?: null,
                        'actor_full_name' => session()->get('full_name') ?: null,
                        'action_at' => date('Y-m-d H:i:s'),
                        'from_name' => $row['from_name'] ?? null,
                        'subject' => $row['subject'] ?? null,
                        'date_received' => $row['date_received'] ?? null,
                        'details' => json_encode($row),
                    ]);
                } catch (\Throwable $e) {
                    log_message('error', 'Failed to save history for delete: ' . $e->getMessage());
                }

                // Now delete
                $result = $db->table('forms')->where('id', $id)->delete();

                return $this->response->setJSON(['success' => true, 'message' => 'Entry deleted successfully']);
                
            } elseif ($action === 'delete_all') {
                try {
                    $db = db_connect();
                    $model = new FormModel();
                    $historyModel = new \App\Models\HistoryModel();
                    
                    // Get all records first before deleting
                    $allForms = $db->table('forms')->get()->getResultArray();
                    
                    // Log each deletion to history
                    foreach ($allForms as $form) {
                        try {
                            $historyModel->save([
                                'item_table' => 'forms',
                                'item_id' => $form['id'] ?? null,
                                'action' => 'deleted',
                                'actor' => session()->get('username') ?: null,
                                'actor_full_name' => session()->get('full_name') ?: null,
                                'action_at' => date('Y-m-d H:i:s'),
                                'from_name' => $form['from_name'] ?? null,
                                'subject' => $form['subject'] ?? null,
                                'date_received' => $form['date_received'] ?? null,
                                'details' => json_encode($form),
                            ]);
                        } catch (\Throwable $e) {
                            log_message('error', 'Failed to log delete_all history: ' . $e->getMessage());
                        }
                    }
                    
                    // Now delete all
                    $db->table('forms')->emptyTable();
                    return $this->response->setJSON(['success' => true, 'message' => 'All entries deleted successfully']);
                } catch (\Exception $e) {
                    log_message('error', 'Delete all error: ' . $e->getMessage());
                    return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
                }
                
            } else {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid action']);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Delete error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    public function listAll()
    {
        $model = new FormModel();
        $data['forms'] = $model->orderBy('id', 'DESC')->findAll();
        return view('list_page', $data);
    }

    public function recent()
    {
        try {
            $model = new FormModel();
            $forms = $model->orderBy('id', 'DESC')->findAll();
            return $this->response
                ->setContentType('application/json')
                ->setJSON(['success' => true, 'forms' => $forms]);
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(500)
                ->setContentType('application/json')
                ->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function print($id)
    {
        $model = new FormModel();
        $data['form'] = $model->find($id);
        return view('print_page', $data);
    }
}