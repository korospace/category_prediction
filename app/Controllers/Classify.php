<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Classify extends ResourceController
{
    protected $db;
    protected $validation;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    protected $htmlEntities = array("&nbsp;","&lt;","&amp;","&gt;");
    protected $stopwords    = array("ajak", "akan", "beliau", "khan", "lah", "dong", "ahh", "sob", "elo", "so", "kena", "kenapa", "yang", "dan", "tidak", "agak", "kata", "bilang", 
    "sejak", "kagak", "cukup", "jua", "cuma", "hanya", "karena", "oleh", "lain", "setiap", "untuk", "dari", "dapat", "dapet", "sudah", "udah", "selesai", "punya", 
    "belum", "boleh", "gue", "gua", "aku", "kamu", "dia", "mereka", "kami", "kita", "jika", "bila", "kalo", "kalau", "dalam", "nya", "atau", "seperti", "mungkin", 
    "sering", "kerap", "acap", "harus", "banyak", "doang", "kemudian", "nyala", "mati", "milik", "juga", "mau", "dimana", "apa", "kapan", "kemana", "selama", "siapa", 
    "mengapa", "dengan", "kalian", "bakal", "bakalan", "tentang", "setelah", "hadap", "semua", "hampir", "antara", "sebuah", "apapun", "sebagai", "di", "tapi", 
    "lainnya", "bagaimana", "namun", "tetapi", "biar", "pun", "itu", "ini", "suka", "paling", "mari", "ayo", "barangkali", "mudah", "kali", "sangat", "banget", 
    "disana", "disini", "terlalu", "lalu", "terus", "trus", "sungguh", "telah", "mana", "apanya", "ada", "adanya", "adalah", "adapun", "agaknya", "agar", "akankah", 
    "akhirnya", "akulah", "amat", "amatlah", "anda", "andalah", "antar", "diantaranya", "antaranya", "diantara", "apaan", "apabila", "apakah", "apalagi", "apatah", 
    "ataukah", "ataupun", "bagai", "bagaikan", "sebagainya", "bagaimanapun", "sebagaimana", "bagaimanakah", "bagi", "bahkan", "bahwa", "bahwasanya", "sebaliknya", 
    "sebanyak", "beberapa", "seberapa", "begini", "beginian", "beginikah", "beginilah", "sebegini", "begitu", "begitukah", "begitulah", "begitupun", "sebegitu", 
    "belumlah", "sebelum", "sebelumnya", "sebenarnya", "berapa", "berapakah", "berapalah", "berapapun", "betulkah", "sebetulnya", "biasa", "biasanya", "bilakah", 
    "bisa", "bisakah", "sebisanya", "bolehkah", "bolehlah", "buat", "bukan", "bukankah", "bukanlah", "bukannya", "percuma", "dahulu", "daripada", "dekat", "demi", 
    "demikian", "demikianlah", "sedemikian", "depan", "dialah", "dini", "diri", "dirinya", "terdiri", "dulu", "enggak", "enggaknya", "entah", "entahlah", "terhadap", 
    "terhadapnya", "hal", "hanyalah", "haruslah", "harusnya", "seharusnya", "hendak", "hendaklah", "hendaknya", "hingga", "sehingga", "ia", "ialah", "ibarat", "ingin", 
    "inginkah", "inginkan", "inikah", "inilah", "itukah", "itulah", "jangan", "jangankan", "janganlah", "jikalau", "justru", "kala", "kalaulah", "kalaupun", "kamilah",
    "kamulah", "kan", "kau", "kapankah", "kapanpun", "dikarenakan", "karenanya", "ke", "kecil", "kepada", "kepadanya", "ketika", "seketika", "khususnya", "kini", 
    "kinilah", "kiranya", "sekiranya", "kitalah", "kok", "lagi", "lagian", "selagi", "melainkan", "selaku", "melalui", "lama", "lamanya", "selamanya", "lebih", 
    "terlebih", "bermacam", "macam", "semacam", "maka", "makanya", "makin", "malah", "malahan", "mampu", "mampukah", "manakala", "manalagi", "masih", "masihkah", 
    "semasih", "masing", "maupun", "semaunya", "memang", "merekalah", "meski", "meskipun", "semula", "mungkinkah", "nah", "nanti", "nantinya", "nyaris", "olehnya", 
    "seorang", "seseorang", "pada", "padanya", "padahal", "sepanjang", "pantas", "sepantasnya", "sepantasnyalah", "para", "pasti", "pastilah", "per", "pernah", "pula", 
    "merupakan", "rupanya", "serupa", "saat", "saatnya", "sesaat", "aja", "saja", "sajalah", "saling", "bersama", "sama", "sesama", "sambil", "sampai", "sana", 
    "sangatlah", "saya", "sayalah", "se", "sebab", "sebabnya", "tersebut", "tersebutlah", "sedang", "sedangkan", "sedikit", "sedikitnya", "segala", "segalanya", 
    "segera", "sesegera", "sejenak", "sekali", "sekalian", "sekalipun", "sesekali", "sekaligus", "sekarang", "sekitar", "sekitarnya", "sela", "selain", "selalu", 
    "seluruh", "seluruhnya", "semakin", "sementara", "sempat", "semuanya", "sendiri", "sendirinya", "seolah", "sepertinya", "seringnya", "serta", "siapakah", 
    "siapapun", "disinilah", "sini", "sinilah", "sesuatu", "sesuatunya", "suatu", "sesudah", "sesudahnya", "sudahkah", "sudahlah", "supaya", "tadi", "tadinya", "tak", 
    "tanpa", "tentu", "tentulah", "tertentu", "seterusnya", "tiap", "setidaknya", "tidakkah", "tidaklah", "toh", "waduh", "wah", "wahai", "sewaktu", "walau", 
    "walaupun", "wong", "yaitu", "yakni");

    /**
     * Show Classify Page
     */
    public function index()
    {
        $data = [
            'title' => 'classify'
        ];

        return view("Classify/index",$data);
    }

    /**
     * Get Kategori
     */
    public function getKategori()
    {
        $kategori = $this->db->table("kategori")
            ->get()
            ->getResultArray();

        $arrRes  = [
            "code"  => count($kategori) == 0 ? 404  : 200,
            "error" => count($kategori) == 0 ? true : false,
            "data"  => count($kategori) == 0 ? []   : $kategori
        ];

        if (count($kategori) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "kategori belum ditambah";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Get Akurasi
     */
    public function getAkurasi()
    {
        $rows = $this->db->table("classify")
            ->get()
            ->getResultArray();

        $total = 0;
        $same  = 0;

        foreach ($rows as $value) {
            ++$total;
            if ($value["id_predicted"] == $value["id_actual"]) {
                ++$same;
            }
        }

        $akurasi = ($same/$total)*100;

        $respond = [
            'code'    => 200,
            'error'   => false,
            'message' => "Akurasi: $same/$total ($akurasi%)",
        ]; 

        return $this->respond($respond,$respond['code']);
    }

    /**
     * Predict The Text
     */
    public function create()
    {
        try {
            $data = $this->request->getPost();

            $this->validation->run($data,'predictValidate');
            $errors = $this->validation->getErrors();
            
            if ($errors) {
                $respond = [
                    'code'    => 400,
                    'error'   => true,
                    'message' => $errors,
                ]; 
    
                return $this->respond($respond,$respond['code']);
            }
            else {
                $this->db->transBegin();

                $text = $data["text"];

                // to lower case
                $contentToLower = strtolower($text);

                // remove character and html tag
                $contentNoCharacter = str_replace($this->htmlEntities,"",$contentToLower);
                $contentNoCharacter = preg_replace("/<[^>]*>/","",$contentNoCharacter);
                $contentNoCharacter = preg_replace("/[^a-zA-Z\\s]/","",$contentNoCharacter);

                // slangWord convertion
                $contentNoSlangWord = "";
                $contentToArray     = explode(" ",$contentNoCharacter);
                foreach ($contentToArray as $x) {
                    $contentNoSlangWord .= isset($arrSlang[$x]) ? $arrSlang[$x]." " : $x." ";
                }
                $contentNoSlangWord = trim($contentNoSlangWord);

                // stop word removal
                $contentNoStopWord     = "";
                $contentNoSlangExplode = explode(" ",$contentNoSlangWord);
                foreach ($contentNoSlangExplode as $x) {
                    $contentNoStopWord .= !in_array($x,$this->stopwords) ? $x." " : "";
                }
                $contentNoStopWord = trim($contentNoStopWord);

                // stemming
                $stemmerFactory   = new \Sastrawi\Stemmer\StemmerFactory();
                $stemmer          = $stemmerFactory->createStemmer();
                $contentAfterStem = $stemmer->stem($contentNoStopWord);

                $text_array = explode(" ",$contentAfterStem);

                foreach ($text_array as $value) {
                    $kata  = $value;  
                    $pData = $this->db->table("p_data")
                        ->where("kata",$kata)
                        ->get()->getResultArray();
                    
                    foreach ($pData as $value) {
                        $idKat = $value["id_kategori"];
                        $nilai = $value["nilai"];
                        $jml   = $value["jml_data"];

                        $tmpNilai = $this->db->table("p_kategori")
                            ->where("id_kategori",$idKat)
                            ->get()->getFirstRow();

                        $tmpNilai = (float)$tmpNilai->tmp_nilai;

                        if ($tmpNilai <= 0) {
                            $tmpNilai = 1;
                        }

                        (float)$totNilai= (float)($tmpNilai*$nilai);

                        $this->db->table("p_kategori")
                            ->where("id_kategori",$idKat)
                            ->update(["tmp_nilai" => $totNilai]);
                    }
                }

                // get nilai tertinggi
                $nilaiTertinggi = $this->db->query("select max(nilai * tmp_nilai) as nilai from p_kategori")->getFirstRow();
                $nilaiTertinggi = $nilaiTertinggi->nilai;

                // get kategori name
                $katTerpilih = $this->db->query("select kategori.id,kategori.name from p_kategori join kategori on(kategori.id=p_kategori.id_kategori) where (p_kategori.nilai*p_kategori.tmp_nilai) = $nilaiTertinggi")->getFirstRow();

                // get table p+kategori
                $pKategori = $this->db->table("p_kategori")
                ->select("kategori.name,p_kategori.jml_data,p_kategori.nilai,p_kategori.tmp_nilai")
                ->join("kategori","kategori.id=p_kategori.id_kategori")
                ->get()->getResultArray();

                $this->db->table("p_kategori")
                    ->update(["tmp_nilai" => 0]);

                $this->db->table("classify")->insert([
                    "data_bersih" => $contentAfterStem,
                    "id_predicted"=> $katTerpilih->id,
                    "id_actual"   => $data["id_actual"],
                ]);

                if ($this->db->transStatus()) {
                    $this->db->transCommit();
                }

                $respond = [
                    'code'    => 200,
                    'error'   => false,
                    'message' => "Tertinggi :<br><br> <b>".$katTerpilih->name." (".$nilaiTertinggi." )</b>",
                    'data'    => $pKategori
                ]; 
    
                return $this->respond($respond,$respond['code']);
            } 

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
