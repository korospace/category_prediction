<?php

namespace App\Models;

use CodeIgniter\Model;

class SlangWordModel extends Model
{
    protected $table      = 'slang_word';
    protected $primaryKey = 'id';

    public function getAll(): array
    {
        $entries = $this->db
            ->table($this->table)
            ->orderBy("id","desc")
            ->get()
            ->getResultArray();

        return $entries;
    }

    public function checkRowExist(String $kataBaku,String $kataNonBaku)
    {
        $entries = $this->db
            ->table($this->table)
            ->where("kata_baku",$kataBaku)
            ->orWhere("kata_nonbaku",$kataNonBaku)
            ->get()
            ->getFirstRow();

        return $entries;
    }

    public function insertSlangWord(Array $data): array
    {
        try {
            $this->db->transBegin();

            foreach ($data as $d) {
                $this->db->table($this->table)->insert($d);
            }

            $transStatus = $this->db->transStatus();
            $dbrespond   = [
                'code'  => ($transStatus) ? 201   : 500,
                'error' => ($transStatus) ? false : true,
            ];

            if ($transStatus) {
                $this->db->transCommit();
            } 
            else {
                $dbrespond['message'] = "terjadi kesalahan saat input data";
                $this->db->transRollback();
            }

            return $dbrespond;
        } 
        catch (\Throwable $th) {
            $this->db->transRollback();
            return [
                'code'    => 500,
                'error'   => true,
                'message' => $th->getMessage(),
            ];   
        }
    }
}
