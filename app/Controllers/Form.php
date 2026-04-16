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

        $model->save([
            'from_name' => $this->request->getPost('from_name'),    
            'date_received' => $this->request->getPost('date_received'),
            'origin' => $this->request->getPost('origin'),
            'reference_no' => $this->request->getPost('reference_no'),
            'subject' => $this->request->getPost('subject'),
            'instructions' => $this->request->getPost('instructions'),
        ]);

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
                // Use query builder to delete
                $db = db_connect();
                $result = $db->table('forms')->where('id', $id)->delete();
                
                return $this->response->setJSON(['success' => true, 'message' => 'Entry deleted successfully']);
                
            } elseif ($action === 'delete_all') {
                $db = db_connect();
                $db->table('forms')->emptyTable();
                return $this->response->setJSON(['success' => true, 'message' => 'All entries deleted successfully']);
                
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