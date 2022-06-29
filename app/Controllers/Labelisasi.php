<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Labelisasi extends ResourceController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
    }

    /**
     * Show Labelisasi Page
     */
    public function index()
    {
        $data = [
            'title' => 'labelisasi'
        ];

        return view("Labelisasi/index",$data);
    }

    /**
     * Get Entry In Preprocessing Table With id_kategori null
     */
    public function getNullKategori()
    {
        $nullKategori = $this->db->table("preprocessing")
            ->getWhere(["id_kategori"=>null])
            ->getResultArray();

        $arrRes  = [
            "code"  => count($nullKategori) == 0 ? 404  : 200,
            "error" => count($nullKategori) == 0 ? true : false,
            "data"  => count($nullKategori) == 0 ? []   : $nullKategori
        ];

        if (count($nullKategori) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "entry dengan kategori 'null' tidak ditemukan";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Get Entries From Preprocessing Table With Kategori
     */
    public function show($id = null)
    {
        $rows = $this->db->table("preprocessing")
            ->select("preprocessing.entry_id,kategori.name as kategori,preprocessing.data_bersih")
            ->join("kategori","preprocessing.id_kategori = kategori.id","left")
            ->orderBy("preprocessing.no","desc")->get()->getResultArray();

        $arrRes  = [
            "code"  => count($rows) == 0 ? 404  : 200,
            "error" => count($rows) == 0 ? true : false,
            "data"  => count($rows) == 0 ? []   : $rows
        ];

        if (count($rows) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "belum ada data entry";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Labelisasi
     */
    public function create()
    {
        try {
            $this->db->transBegin();

            $nullKategori = $this->db->table("preprocessing")
                ->getWhere(["id_kategori"=>null])
                ->getResultArray();

            if (count($nullKategori) == 0) {
                $respond = [
                    'code'    => 201,
                    'error'   => false,
                    'message' => "semua baris entry sudah dilabelisasi",
                ]; 
            }
            else {
                $arrKategori = $this->db->table("kategori")->select()->get()->getResultArray();
    
                foreach ($arrKategori as $k) {
                    $this->db->table("preprocessing")->where("feed_id",$k["galert_id"])
                    ->update([
                        "id_kategori" => $k["id"]
                    ]);    
                }
    
                $transStatus = $this->db->transStatus();
                $respond = [
                    'code'  => ($transStatus) ? 201   : 500,
                    'error' => ($transStatus) ? false : true,
                ];
    
                if ($transStatus) {
                    $respond['message'] = count($nullKategori)." baris entry sudah dilabelisasi!";
                    $this->db->transCommit();
                } 
                else {
                    $respond['message'] = "Rollback: terjadi kesalahan saat labelisasi";
                    $this->db->transRollback();
                }
            }


            return $this->respond($respond,$respond['code']);
        } 
        catch (\Throwable $th) {
            $this->db->transRollback();

            $respond = [
                'code'    => 500,
                'error'   => true,
                'message' => $th->getMessage(),
            ]; 
            return $this->respond($respond,$respond['code']);
        }
    }
}
