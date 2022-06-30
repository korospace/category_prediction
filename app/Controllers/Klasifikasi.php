<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Klasifikasi extends ResourceController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
    }

    /**
     * Show Klasifikasi Page
     */
    public function index()
    {
        $data = [
            'title' => 'klasifikasi'
        ];

        // $this->countDataProb();

        return view("Klasifikasi/index",$data);
    }

    /**
     * Get Probabilitas Each Kategori
     */
    public function getCategoriesProb()
    {   
        try {
            $resData = [];

            $this->db->transBegin();

            // get data from table kategori
            $kategori = $this->db->table("kategori")->get()->getResultArray();
            
            foreach ($kategori as $k) {
                $id = $k["id"];
                $name = $k["name"];

                $jmlKat = $this->db->table("preprocessing")
                    ->where("id_kategori",$id)
                    ->countAllResults();
                $jmlAll = $this->db->table("preprocessing")
                    ->where("id_kategori !=",null)
                    ->countAllResults();

                $nilai = number_format($jmlKat/$jmlAll, 10);

                $pKategori = $this->db->table("p_kategori")->where("id_kategori",$id)
                    ->get()->getFirstRow();

                if (is_null($pKategori)) {
                    $this->db->table("p_kategori")->insert([
                        "id_kategori" => $id,
                        "jml_data" => $jmlKat,
                        "nilai" => $nilai,
                    ]);
                } 
                else {
                    $this->db->table("p_kategori")->where("id_kategori",$id)->update([
                        "jml_data" => $jmlKat,
                        "nilai" => $nilai,
                    ]);
                }
    
                $resData[] = [
                    "kategori" => $name,
                    "jml_kat"  => $jmlKat,
                    "jml_all"  => $jmlAll,
                    "nilai"    => $nilai,
                ];
            }

            if ($this->db->transStatus()) {
                $this->db->transCommit();
            } 

            $arrRes  = [
                "code"  => 200,
                "error" => false,
                "data"  => $resData
            ];
    
            return $this->respond($arrRes,$arrRes['code']);
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

    /**
     * Count Probabilitas Data
     */
    public function countDataProb()
    {
        try {
            $this->db->transBegin();

            // get data from table preprocessing
            $preprocessing = $this->db->table("preprocessing")
                ->where("id_kategori !=",null)
                ->where("classify",0)
                ->get()->getResultArray();

            $kategori = $this->db->table("kategori")->get()->getResultArray();
    
            foreach ($preprocessing as $p) {

                $entry_id   = $p["entry_id"];
                $dataBersih = $p["data_bersih"];
                $dataBersihToArray = explode(" ",$dataBersih);
    
                $strDataBersih = [];
    
                foreach ($dataBersihToArray as $value) {
                    $strDataBersih[] = "".$value;
                    $kata = $value;
    
                    foreach ($kategori as $k) {
                        $id_kat = $k["id"];
                        $nm_kat = $k["name"];
    
                        $jmlKata = $this->db->table("preprocessing")
                            ->where("id_kategori",$id_kat)
                            ->like("data_bersih",$kata)
                            ->countAllResults();
    
                        $pData = $this->db->table("p_data")
                            ->where("kata",$kata)
                            ->where("id_kategori",$id_kat)
                            ->get()->getFirstRow();

    
                        if (is_null($pData)) {
                            $this->db->table("p_data")->insert([
                                "id_kategori" => $id_kat,
                                "kata"        => $kata,
                                "jml_data"    => $jmlKata,
                            ]);
                        } 
                        else {
                            // var_dump($pData);die;

                            $this->db->table("p_data")
                            ->where("id_kategori",$id_kat)
                            ->where("kata",$kata)
                            ->update([
                                "jml_data" => $jmlKata,
                            ]);
                        }
                    }
                }

                $this->db->table("preprocessing")
                    ->where("entry_id",$entry_id)
                    ->update(["classify" => 1]);
            }

            if ($this->db->transStatus()) {
                $this->db->transCommit();
            } 

            $arrRes  = [
                "code"    => 200,
                "error"   => false,
                "message" => "ok"
            ];
    
            return $this->respond($arrRes,$arrRes['code']);
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

    /**
     * Get Probabilitas Data
     */
    public function getDataProb()
    {
        try {
            $resData = [];
            
            $this->db->transBegin();

            // get data from table p_data
            $pData = $this->db->table("p_data")->select("kategori.id as id_kategori,kategori.name as kategori,p_data.kata,p_data.jml_data,p_data.nilai")
            ->join("kategori","p_data.id_kategori = kategori.id","left")
            ->orderBy("p_data.kata","desc")
            ->get()->getResultArray();

            foreach ($pData as $value) {
                $jmlKategori = $this->db->table("preprocessing")
                    ->where("id_kategori",$value["id_kategori"])
                    ->countAllResults();

                $n = $this->db->table("p_data")->select("kata")
                    ->where("id_kategori",$value["id_kategori"])
                    ->distinct()
                    ->countAllResults();

                $kosaKata = $this->db->table("p_data")->select("kata")
                    ->distinct()
                    ->countAllResults();

                $nilai = ($value["jml_data"] + 1) / ($n + $kosaKata);

                $this->db->table("p_data")
                    ->where("kata",$value["kata"])
                    ->where("id_kategori",$value["id_kategori"])
                    ->update(["nilai" => $nilai]);

                $resData[] = [
                    "kategori"     => $value["kategori"],
                    "kata"         => $value["kata"],
                    "jml_data"     => $value["jml_data"],
                    "jml_kategori" => $jmlKategori,
                    "nilai"        => $nilai,
                ];
            }

            if ($this->db->transStatus()) {
                $this->db->transCommit();
            } 

            $arrRes  = [
                "code"  => 200,
                "error" => false,
                "data"  => $resData
            ];
    
            return $this->respond($arrRes,$arrRes['code']);
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
