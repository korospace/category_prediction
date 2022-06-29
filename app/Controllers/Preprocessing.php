<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Preprocessing extends ResourceController
{
    protected $modelName = 'App\Models\PreprocessingModel';

    public function __construct()
    {
        $this->db = \Config\Database::connect(); 
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
     * Show Preprocessing Page
     */
    public function index()
    {
        $data = [
            'title' => 'preprocessing'
        ];

        return view("Preprocessing/index",$data);
    }

    /**
     * Get Entry With Clean status false
     */
    public function getDirtyEntries()
    {
        $dirtyEntry = $this->db->table("galert_entry")
            ->getWhere(["clean"=>0])
            ->getResultArray();

        $arrRes  = [
            "code"  => count($dirtyEntry) == 0 ? 404  : 200,
            "error" => count($dirtyEntry) == 0 ? true : false,
            "data"  => count($dirtyEntry) == 0 ? []   : $dirtyEntry
        ];

        if (count($dirtyEntry) == 0) {
            unset($arrRes["data"]);
            $arrRes["message"] = "semua entry telah dibersihkan";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * Get Entry In Preprocessing Table
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
            $arrRes["message"] = "belum ada data bersih";
        }

        return $this->respond($arrRes,$arrRes['code']);
    }

    /**
     * PreProcessing
     */
    public function create()
    {        
        try {
            $this->db->transBegin();

            $slangWord = $this->db->table("slang_word")
                ->get()
                ->getResultArray();

            $dirtyEntry = $this->db->table("galert_entry")
                ->getWhere(["clean"=>0])
                ->getResultArray();

            $arrSlang = [];
            foreach ($slangWord as $s) {
                $arrSlang[$s["kata_nonbaku"]] = preg_replace("/ /","",$s["kata_baku"]);
            }
            
            foreach ($dirtyEntry as $d) {
                $feedId  = $d["feed_id"];
                $entryId = $d["entry_id"];
                $content = $d["entry_content"];

                // to lower case
                $contentToLower = strtolower($content);
                $contentToLowerWithStrip = strtolower(htmlspecialchars(stripslashes($content)));

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

                // tokenisasi
                $contentTokenisasi = preg_split("/[\s,.:]+/",$contentAfterStem);
                $contentTokenisasi = implode(", ",$contentTokenisasi);
                
                $newData = [
                    "feed_id"  => $feedId,
                    "entry_id" => $entryId,
                    "p_cf"     => $contentToLowerWithStrip,
                    "p_simbol" => $contentNoCharacter,
                    "p_sword"  => $contentNoSlangWord,
                    "p_stopword" => $contentNoStopWord,
                    "p_stemming" => $contentAfterStem,
                    "p_tokenisasi" => $contentTokenisasi,
                    "data_bersih"  => $contentAfterStem
                ];

                $this->db->table("preprocessing")->insert($newData);
                $this->db->table("galert_entry")
                    ->set("clean",true)
                    ->where("entry_id",$entryId)
                    ->update();
            }

            $transStatus = $this->db->transStatus();
            $respond = [
                'code'  => ($transStatus) ? 201   : 500,
                'error' => ($transStatus) ? false : true,
            ];

            if ($transStatus) {
                $respond['message'] = count($dirtyEntry)." entry sudah dibersihkan!";
                $this->db->transCommit();
            } 
            else {
                $respond['message'] = "Rollback: terjadi kesalahan saat input data";
                $this->db->transRollback();
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
