<?
class Sign {
    private static $month_list = [
        'январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
    ];
    private static $short_month_list = [
        'янв', 'фев', 'март', 'апр', 'май', 'июнь', 'июль', 'авг', 'сент', 'окт', 'нояб', 'дек'
    ];
    public $id;
    public $name_ru;
    public $name_en;
    public $date_from;
    public $date_to;
    public $description;

    public function __construct($id = 0, $name_ru='', $name_en='', $date_from='', $date_to='', $description='') {
        $this->id = $id;
        $this->name_ru = $name_ru;
        $this->name_en = $name_en;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->description = $description;
    }

    public static function NewSignFromSQLRow($row) {
        return new Sign($row['id'], $row['sign_ru'], $row['sign_en'], $row['date_from'], $row['date_to'], $row['description']);
    }

    public function FullDatesString() {
        $timestamp_from = strtotime($this->date_from);
    
        $month_from = Sign::$month_list[date('m', $timestamp_from)-1];
        $day_from = date("d", $timestamp_from);

        $timestamp_to = strtotime($this->date_to);

        $month_to = Sign::$month_list[date('m', $timestamp_to)-1];
        $day_to = date("d", $timestamp_to);

        
        return mb_convert_case($day_from.' '.  $month_from.' - '.$month_to.' '.$day_to, MB_CASE_TITLE, "UTF-8");
    }

    public function ShortDatesString() {
        $timestamp_from = strtotime($this->date_from);
    
        $month_from = Sign::$short_month_list[date('m', $timestamp_from)-1];
        $day_from = date("d", $timestamp_from);

        $timestamp_to = strtotime($this->date_to);

        $month_to = Sign::$short_month_list[date('m', $timestamp_to)-1];
        $day_to = date("d", $timestamp_to);

        return mb_convert_case($day_from.' '.  $month_from.' - '.$month_to.' '.$day_to, MB_CASE_TITLE, "UTF-8");
    }

    public static function GetSignArrayFromDB() {
        $signs = [];

        $m = new mysqli("localhost", "root", "root", "taro");

        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT * FROM signs");

        $signs = [];

        while($row = $r->fetch_assoc()) {
            array_push($signs, Sign::NewSignFromSQLRow($row));
        }
        
        $m->close();

        return $signs;
    }

    public static function GetSignByName($name) {
        $m = new mysqli("localhost", "root", "root", "taro");

        if($m->connect_error) {
            die($m->connect_error);
        }

        $r = $m->query("SELECT * FROM signs WHERE sign_en = '$name'");
        $row = $r->fetch_assoc();
        $m->close();
        return Sign::NewSignFromSQLRow($row);
    }
}
