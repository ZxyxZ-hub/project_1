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

    public function print($id)
    {
        $model = new FormModel();
        $data['form'] = $model->find($id);
        return view('print_page', $data);
    }
}