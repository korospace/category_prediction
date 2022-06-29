<?php

namespace App\Models;

use CodeIgniter\Model;

class GalertEntryModel extends Model
{
    protected $table      = 'galert_entry';
    protected $primaryKey = 'entry_id';

    public function insertEntries(Array $data): array
    {
        try {
            $id = $data["id"];
            $title = $data["title"];
            $link  = $data["link"]["@attributes"]["href"];
            $updated = $data["updated"];
            $entries = $data["entry"];

            // kategori name
            $stoplist = ["Google","Alert"," ","-"];
            $remStopWord = explode(" ",$title);
            $stringKategori = [];

            foreach ($remStopWord as $r) {
                if (!in_array($r,$stoplist)) {
                    $stringKategori[] = $r;
                }
            }

            $stringKategori = implode(" ",$stringKategori);

            // Find galert_data ID
            $gdata = $this->db->table("galert_data")
                ->where("galert_id",$id)
                ->get()
                ->getFirstRow();

            $this->db->transBegin();

            // Insert new data to galert_data & kategori
            if (is_null($gdata)) {
                $this->db->query("INSERT INTO galert_data (galert_id,galert_title,galert_link,galert_update) VALUES('$id','$title','$link','$updated');");
                $this->db->query("INSERT INTO kategori (galert_id,name) VALUES('$id','$stringKategori');");
            }

            // Insert entries
            foreach ($entries as $entry) {
                $data_entry = [
                    "entry_id"        => $entry["id"],
                    "entry_title"     => $entry["title"],
                    "entry_link"      => $entry["link"]["@attributes"]["href"],
                    "entry_published" => $entry["published"],
                    "entry_updated"   => $entry["updated"],
                    "entry_content"   => $entry["content"],
                    "entry_author"    => $entry["author"]["name"] != [] ? $entry["author"]["name"] : "-",
                    "feed_id"         => $id,
                ];
                $this->db->table($this->table)->insert($data_entry);
            }
            
            $transStatus = $this->db->transStatus();
            $dbrespond   = [
                'code'  => ($transStatus) ? 201   : 500,
                'error' => ($transStatus) ? false : true,
            ];

            if ($transStatus) {
                $dbrespond['data'] = $entries;
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
