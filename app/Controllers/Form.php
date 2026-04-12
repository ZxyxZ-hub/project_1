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

        return redirect()->to('/form');
    }

    public function view($id)
    {
        $model = new FormModel();
        $data['form'] = $model->find($id);
        return view('view_page', $data);
    }

    public function print($id)
    {
        $model = new FormModel();
        $data['form'] = $model->find($id);
        return view('print_page', $data);
    }
}