<?

class Article {

    //@var int
    public $ID;
    //@var string
    public $Header;
    //@var string
    public $Image;
    //@var long int
    public $CreateTimestamp;
    //@var any[]
    public $Categories;
    //@var ArticlePart[]
    public $Body = [];

    public function GetShortBody() {
        return substr($this->Body[0]->Content, 0, length: 512) . '...';
    }

    public static function NewFromID($id) {
        $article = new Article();
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("select * from articles where aid = $id");

        if($r->num_rows == 0) {
            return null;
        }

        $row = $r->fetch_assoc();
        $article->ID = $row['aid'];
        $article->Header = $row['header'];
        $article->CreateTimestamp = intval($row['create_timestamp']);
        $article->Image = $row['image'];

        $m->close();
        // get categories
        $article->Categories = self::GetCategories($article->ID);
        // get body
        $article->Body = self::GetBody($article->ID);

        return $article;
    }

    public static function NewFromRow($row) {
        $article = new Article();
        $article->ID = $row['aid'];
        $article->Header = $row['header'];
        $article->CreateTimestamp = intval($row['create_timestamp']);
        $article->Image = $row['image'];
        $article->Categories = self::GetCategories($article->ID);
        $article->Body = self::GetBody($article->ID);
        return $article;
    }

    private static function GetCategories($article_id) {
        $categories = [];
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT ac.cat_id, bc.name
                                FROM article_categories ac
                                JOIN blog_categories bc ON ac.cat_id = bc.cat_id
                                WHERE ac.aid = $article_id;");
        while($row = $r->fetch_assoc()) {
            $categories[] = [$row['cat_id'], $row['name']];
        }
        $m->close();
        return $categories;
    }

    private static function GetBody($article_id) {
        $body = [];
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT b.on_page_idx, t.tag, b.content, t.class_list
                        FROM article_body b
                        JOIN article_tags t ON t.tag_id = b.tag_id
                        WHERE b.aid = $article_id ORDER BY b.on_page_idx ASC;");

        while($row = $r->fetch_assoc()) {
            $body[]= new ArticlePart($row['on_page_idx'], $row['tag'], $row['content'], $row['class_list']);
        }

        $m->close();
        return $body;
    }

    public static function GetArticleList($limit = 10, $cat = null) {
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }

        $query = "SELECT * FROM articles";
        if($cat != null) {
            // TODO: 
            // add JOIN on article_categories
            $query .= " WHERE cat_id = $cat";
        }
        $query .= " ORDER BY create_timestamp DESC LIMIT $limit;";

        $r = $m->query($query);
        $articles = [];

        while($row = $r->fetch_assoc()) {
            $articles[] = Article::NewFromRow($row);
        }

        return $articles;
    }

    public static function GetArticleByHash($hash) {
        $article_id = Article::DecodeBase62($hash);
        $article = Article::NewFromID($article_id);
        return $article;
    }
    // TODO: Receive really popular items
    public static function GetPopularArticles($limit) {
        $articles = Article::GetArticleList($limit);
        return $articles;
    }

    public static function GetAllCategories() {
        $m = new mysqli('localhost', 'root', 'root', 'taro');
        if($m->connect_error) {
            die($m->connect_error);
        }
        $r = $m->query("SELECT name FROM blog_categories;");
        $categories = [];
        while($row = $r->fetch_assoc()) {
            $categories[] = $row['name'];
        }
        $m->close();
        return $categories;
    }

    private static $base62_salt = 979232;

    private static function DecodeBase62($hash) {
        $b = 62;
        $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $limit = strlen($hash);
        $res=strpos($base,$hash[0]);
        for($i=1;$i<$limit;$i++) {
            $res = $b * $res + strpos($base,$hash[$i]);
        }
        return $res - Article::$base62_salt;
    }

    public static function EncodeBase62($id) {
        $b = 62;
        $id = intval($id) + Article::$base62_salt;
        $base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $r = $id  % $b ;
        $res = $base[$r];
        $q = floor($id/$b);
        while ($q) {
            $r = $q % $b;
            $q =floor($q/$b);
            $res = $base[$r].$res;
        }
        return $res;
    }
}

class ArticlePart {
    public $OnPageIndex;
    public $Tag;
    public $Content;
    public $ClassList;

    public function __construct($onPageIndex, $tag, $content, $classList = '') {
        $this->OnPageIndex = $onPageIndex;
        $this->Tag = $tag;
        $this->Content = $content;
        $this->ClassList = $classList;
    }
}