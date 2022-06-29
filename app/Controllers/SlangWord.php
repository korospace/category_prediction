<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Shuchkin\SimpleXLSX;
use SimpleCSV;

class SlangWord extends ResourceController
{
    protected $modelName = 'App\Models\SlangWordModel';

    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    /**
     * Show SlangWord Page
     */
    public function index()
    {
        $data = [
            'title' => 'slang word'
        ];

        return view("SlangWord/index",$data);
    }

    /**
     * Get All Slang Word
     */
    public function show($id = null)
    {
        $entries = $this->model->getAll();

        $arrRes  = [
            "code"  => count($entries) == 0 ? 404  : 200,
            "error" => count($entries) == 0 ? true : false,
            "data"  => count($entries) == 0 ? []   : $entries 
        ];

        if (count($entries) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "slang word belum ditambah";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Insert New Slang Word
     */
    public function create()
    {
        $file = $_FILES["slangcsv"];
        $data['slangcsv'] = $this->request->getFile('slangcsv');
        
        $this->validation->run($data,'csvValidate');
        $errors = $this->validation->getErrors();
        
        if ($errors) {
            $modelRespond = [
                'code'    => 400,
                'error'   => true,
                'message' => $errors,
            ]; 
        } 
        else {
            $exeldata = "";

            if (preg_match("/csv/",$file["type"])) {
                $exeldata = SimpleCSV::import($data['slangcsv']->getRealPath());
            }
            else if (preg_match("/xlsx/",$file["type"])) {
                $exeldata = SimpleXLSX::parse($data['slangcsv']->getRealPath());
                $exeldata = $exeldata->rows();
            }
            
            // $lines   = explode( "\n", file_get_contents($data['slangcsv']->getRealPath()) );
            // $headers = str_getcsv( array_shift( $lines ) );
            $header_values = $rows1 = $rows2 = [];
            $dataAcc = array();
            $accept  = 0;
            $reject  = 0;
            $kata    = [];
            
            foreach ( $exeldata as $k => $r ) {
                if ( $k === 0 ) {
                    $header_values = $r;
                    continue;
                }

                if(count($header_values) == count($r)){
                    $rows1[] = array_combine( $header_values, $r );
                }
            }

            foreach ($rows1 as $d) {
                $kata['kata_nonbaku'] = isset($d['Kata Tidak Baku']) ? $d['Kata Tidak Baku'] : ""; 
                $kata['kata_baku']    = isset($d['Kata Baku']) ? $d['Kata Baku'] : ""; 
                $rows2[] = $kata;
            }

            foreach ($rows2 as $d) {
                $this->validation->run($d,'nonBakuValidate');
                $errors = $this->validation->getErrors();
                
                if ($errors) {
                    ++$reject;
                }
                else {
                    $exist = $this->model->checkRowExist($d["kata_baku"],$d["kata_nonbaku"]); 
                    if (!is_null($exist)) {
                        ++$reject;
                    } 
                    else {
                        ++$accept;
                        $dataAcc[] = $d;
                    }
                }
            }

            $message = "diterima:".$accept.", dtolak:".$reject;

            $modelRespond = $this->model->insertSlangWord($dataAcc);

            $modelRespond = [
                'code'    => $modelRespond['code'],
                'error'   => $modelRespond['error'],
                'message' => $modelRespond['code'] == 201 ? $message : $modelRespond['message'],
            ]; 
        }

        return $this->respond($modelRespond,$modelRespond['code']);
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        //
    }
}
