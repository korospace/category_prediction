<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class GalertEntry extends ResourceController
{
    protected $modelName = 'App\Models\GalertEntryModel';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show Scraping Page
     */
    public function index()
    {
        $data = [
            'title' => 'scraping gentry'
        ];

        return view("GalertEntry/index",$data);
    }

    /**
     * Get All Data Entries
     */
    public function show($id = null)
    {
        $entries = $this->model->findAll();

        $arrRes  = [
            "code"  => count($entries) == 0 ? 404  : 200,
            "error" => count($entries) == 0 ? true : false,
            "data"  => count($entries) == 0 ? []   : $this->model->findAll()
        ];

        if (count($entries) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "entry belum ditambah";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Create data entries
     */
    public function create()
    {
        $link      = $this->request->getPost("link");
        $dataXml   = simplexml_load_file($link, "SimpleXMLElement", LIBXML_NOCDATA);
        $dataJson  = json_encode($dataXml);
        $dataArray = json_decode($dataJson,TRUE);

        foreach ($dataArray['entry'] as $entry) {
            $this->validation->run($entry,'entryValidate');
        }

        $errors = $this->validation->getErrors();

        if ($errors) {
            $modelRespond = [
                'code'    => 400,
                'error'   => true,
                'message' => $errors,
            ]; 
        } 
        else {
            $modelRespond = $this->model->insertEntries($dataArray);
        }

        return $this->respond($modelRespond,$modelRespond['code']);
    }
}
