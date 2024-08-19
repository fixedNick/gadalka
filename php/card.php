<?

class Card {

    //@var int
    public $id;
    //@var string
    public $ru_name;
    //@var string
    public $en_name;
    //@var string[]
    public $baseDescription = [];
    //@var Info
    public $baseInfo;
    //@var Info
    public $loveInfo;
    //@var Info
    public $careerInfo;
    //@var Info
    public $financeInfo;

    public function __construct() {
        $this->baseInfo = new Info();
        $this->loveInfo = new Info();
        $this->careerInfo = new Info();
        $this->financeInfo = new Info();
    }

    public static function GetAllRuNames() {
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT ru_name FROM taro_single_card");
        $cards = [];
        while($row = $r->fetch_assoc()) {
            $card = new Card();
            $card->ru_name = $row['ru_name'];
            $cards[] = $card;
        }
        return $cards;
    }

    public static function NewFromCid($cid) {
        $card = new Card();
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT * FROM taro_single_card WHERE id = $cid LIMIT 1");

        $row = $r->fetch_assoc();
        $card->id = $cid;
        $card->ru_name = $row['ru_name'];
        $card->en_name = $row['en_name'];

        $card->baseInfo->up_desc = Info::GetInfo($m, $cid, 1);
        $card->baseInfo->rev_desc = Info::GetInfo($m, $cid, 2);
        $card->baseInfo->up_keywords = explode(',', $row['up_keywords']);
        $card->baseInfo->rev_keywords = explode(',', $row['rev_keywords']);

        $card->loveInfo->up_desc = Info::GetInfo($m, $cid, 3);
        $card->loveInfo->rev_desc = Info::GetInfo($m, $cid, 4);
        $card->loveInfo->up_keywords = explode(',', $row['love_up_keywords']);
        $card->loveInfo->rev_keywords = explode(',', $row['love_rev_keywords']);

        $card->careerInfo->up_desc = Info::GetInfo($m, $cid, 5);
        $card->careerInfo->rev_desc = Info::GetInfo($m, $cid, 6);
        $card->careerInfo->up_keywords = explode(',', $row['career_up_keywords']);
        $card->careerInfo->rev_keywords = explode(',', $row['career_rev_keywords']);

        $card->financeInfo->up_desc = Info::GetInfo($m, $cid, 7);
        $card->financeInfo->rev_desc = Info::GetInfo($m, $cid, 8);
        $card->financeInfo->up_keywords = explode(',', $row['finance_up_keywords']);
        $card->financeInfo->rev_keywords = explode(',', $row['finance_rev_keywords']);

        $r = $m->query("SELECT * FROM single_card_desc WHERE desc_type=9 and card_id=$cid order by on_page_index ASC");
        while($row = $r->fetch_assoc()) {
            array_push($card->baseDescription, $row['desc_value']);
        
        }

        return $card;
    }

    public function PrintDesc($type) {

        $basedOn = [];
        switch ($type) {
            case 'baseDesc':
                $basedOn = $this->baseDescription;
                break;
            case 'base_up':
                $basedOn = $this->baseInfo->up_desc;
                break;
            case 'base_rev':
                $basedOn = $this->baseInfo->rev_desc;
                break;
            case 'love_up':
                $basedOn = $this->loveInfo->up_desc;
                break;
            case 'love_rev':
                $basedOn = $this->loveInfo->rev_desc;
                break;
            case 'career_up':
                $basedOn = $this->careerInfo->up_desc;
                break;
            case 'career_rev':
                $basedOn = $this->careerInfo->rev_desc;
                break;
            case 'finance_up':
                $basedOn = $this->financeInfo->up_desc;
                break;
            case 'finance_rev':
                $basedOn = $this->financeInfo->rev_desc;
                break;
        }

        $count = 0;
        foreach($basedOn as $k => $desc) {
            $s = 'style="color: rgb(202,156,117); font-weight: 200;"';
            if($count == 1) {
                echo '<p itemprop="description"'.$s.'>'.$desc.'</p>';
                continue;
            }
            echo "<p>$desc</p>";
            $count++;
        }
    }

    public function PrintKeywords($type) {
        
        $basedOn = [];
        switch ($type) {
        
            case 'base_up':
                $basedOn = $this->baseInfo->up_keywords;
                break;
            case 'base_rev':
                $basedOn = $this->baseInfo->rev_keywords;
                break;
            case 'love_up':
                $basedOn = $this->loveInfo->up_keywords;
                break;
            case 'love_rev':
                $basedOn = $this->loveInfo->rev_keywords;
                break;
            case 'career_up':
                $basedOn = $this->careerInfo->up_keywords;
                break;
            case 'career_rev':
                $basedOn = $this->careerInfo->rev_keywords;
                break;
            case 'finance_up':
                $basedOn = $this->financeInfo->up_keywords;
                break;
            case 'finance_rev':
                $basedOn = $this->financeInfo->rev_keywords;
                break;
        }

        echo '<div itemprop="keywords" class="keys">';
            foreach ($basedOn as $key => $value) {
                ?>
                <div class="keywords"><span class="icon"><svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path>
                </svg></span><span class="text"><?=mb_strtoupper(mb_substr($value,0,1)).mb_substr($value, 1)?></span></div>
                <?
            }
        echo '</div>';
    }
}

class Info {
    //@var string[]
    public $up_keywords = [];
    //@var string[]
    public $rev_keywords = [];
    //sorted by sql query ORDER BY on_page_index ASC
    //@var string[]
    public $up_desc = [];
    public $rev_desc = [];

    public function __construct() {
    }

    //@param $m     mysqli
    //@param $cid   int
    //@param $type  int
    public static function GetInfo($m, $cid, $type) {
        $desc = [];

        $r = $m->query("SELECT desc_value FROM single_card_desc WHERE card_id=$cid and desc_type=$type ORDER BY on_page_index ASC");
        
        while($row = $r->fetch_assoc()) {
            array_push($desc, $row['desc_value']);
        }
        return $desc;
    }
}