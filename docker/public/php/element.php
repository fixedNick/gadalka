<?
class Element {
    // @var int32
    public $id;
    // @var string
    public $ru_name;
    // @var string
    public $en_name;
    // @var string
    public $description;

    public function __construct($id, $ru_name, $en_name, $description) {
        $this->id = $id;
        $this->ru_name = $ru_name;
        $this->en_name = $en_name;
        $this->description = $description;
    }

    public static function NewElementFromDbRow($row) {
        return new Element($row['id'], $row['ru_name'], $row['en_name'], $row['description']);
    }

    public static function GetElementsArrayFromDB() {
        $m = new mysqli(getenv('dbhost'),getenv('dbuser'), getenv('dbpass'), getenv('dbname'));

        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT * FROM sign_type");

        $elements = [];

        while($row = $r->fetch_assoc()) {
            array_push($elements, Element::NewElementFromDbRow($row));
        }

        $m->close();

        return $elements;
    }
}