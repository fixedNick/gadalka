<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once($root . '/php/sign.php');


if ( isset($_GET['sign']) == false 
|| array_filter(Sign::GetSignArrayFromDB(), 
        function($sign) {
            return $sign->name_en === $_GET['sign'];}) == false ) 
{
    header('Location:' . '/pages/horoscope/horoscope.php');
    die();
}

$months = [
    'Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'
];

$monthsStable = [
    'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
];

// support functions
function textForDay() {
    global $months;
    $currentDay = date("d", time());
    $currentMonth = $months[date("m", time()) - 1];
    $currentYear = date("Y", time());
    

    return 'Ежедневный гороскоп на '.$currentDay.' '.$currentMonth.' '.$currentYear.' года';
}

function textForMonth() {
    global $monthsStable;
    $currentMonth = $monthsStable[date("m", time()) - 1];
    return 'Гороскоп на '.$currentMonth.' месяц.';
}
function textForYear() {
    return 'Гороскоп на '.date('Y', time()).' год';
}


// Received Sign
$sign = Sign::GetSignByName($_GET['sign']);
// Received Horoscope [dafult = day]
$title_end = '';
// is `on` received from get query
$_GET['on'] = isset($_GET['on']) ? $_GET['on'] : 'day';
// setting horoscope by `on`
if($_GET['on'] == 'month') {
    $title_end = textForMonth();
}
else if($_GET['on'] == 'year') {
    $title_end = textForYear();
} else {
    $title_end = textForDay();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- seo -->
   <? 
        include_once($root.'/utils/dc.php'); 
        include_once($root.'/parts/head.php'); 
    
        $year = date_format(new DateTime(), "Y");
        $desc = 'Откройте для себя точные гороскопы для '.$sign->name_ru.' на каждый день, месяц и весь '.$year.' год. Наша страница предлагает подробные астрологические прогнозы, которые помогут вам спланировать свою жизнь, карьеру и личные отношения.'; 
        $title = 'Гороскоп для '.mb_convert_case($sign->name_ru, MB_CASE_TITLE, "UTF-8").'. ' . $title_end;

        // Filling additional keywords for cards page
        $additionalKeywords = ',';
    ?>
    <meta name="DC.title" content="Gadalka | <?=$title?>">
    <meta name="DC.creator" content="kostudio">
    <meta name="DC.subject" content="<?=($keywords . $additionalKeywords)?>">
    <meta name="DC.description" content="<?=$desc?>">
    <meta name="DC.publisher" content="<?=$author?>">
    <meta name="DC.publisher.url" content="<?=$publisher_website?>" >
    <meta name="DC.type" content="Service">
    <meta name="DC.contributor" content="<?=$author?>">
    <meta name="DC.date" content="2024-06-10">
    <meta name="DC.language" content="ru-RU">
    <meta name="DC.format" content="text/html">
    <meta name="DC.identifier" content="<?=$baseIdentifier?>">
    <meta name="DC.source" content="<?=$baseIdentifier?>">
    <meta name="DC.relation" content="<?=$baseIdentifier?>">
    <meta name="DC.coverage" content="World">
    <meta name="DC.rights" content="<?=$baseIdentifier?>">

    <!-- Open Graph -->
    <meta property="og:title" content="Gadalka | <?=$title?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?=$baseIdentifier?>">
    <meta property="og:site_name" content="Gadalka | <?=$title?>">
    <meta property="og:description" content="<?=$desc?>">
    <meta property="og:image" content="<?=$baseIdentifier?>/img/blog-bg.jpg">
    <meta property="og:locale" content="ru_RU">
    
    <!-- base meta  -->
    <meta name="author" content="Gadalka">
    <link rel="canonical" href="<?=$baseIdentifier?>">
    <meta name="keywords" content="<?=($keywords . $additionalKeywords)?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$desc?>">
	
    <title>Gadalka | <?=$title?></title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- self css -->
    <link rel="stylesheet" href="..\..\parts/header/header.css">
    <link rel="stylesheet" href="..\..\parts/footer/footer.css">
    <link rel="stylesheet" href="..\..\parts/css-normalize.css">
    <link rel="stylesheet" href="..\..\main.css">
    <link rel="stylesheet" href="sign.css">
</head>
<body class="light">
    
    <? require_once($root . '/parts/header/header.php'); ?>

    <div class="horoscope-container">
        <div class="img-wrapper">
            <img src="../../img/zodiac-signs/animal/<?=$sign->name_en?>.png" alt="">
        </div>
        <h1 class="title-text"><?=mb_convert_case($sign->name_ru, MB_CASE_TITLE,'UTF-8')?>. <?=$title_end?></h1>

        <?
            $m = new mysqli('localhost', 'root', 'root', 'taro');

            $r = $m->query("select * from horoscope_period where period = '".$_GET['on']."'");
            $periodId = $r->fetch_assoc()['id'];

            $r = $m->query("select * from horoscope where period = $periodId and sign_id = $sign->id");

            $rows = [];
            class Row {
                public $tag;
                public $text;
                public $index;

                public function __construct($tag = 'p', $text = '', $idx = 0) {
                    $this->tag = $tag;
                    $this->text = $text;
                    $this->index = $idx;
                }
            }

            while($row = $r->fetch_assoc()) {
                array_push($rows, new Row(
                    $row['html_tag'],
                    $row['html_value'],
                    $row['on_page_idx']
                ));
            }
            $m->close();
            
            usort($rows, function($a, $b) {
                return $a->index - $b->index;
            });

            foreach ($rows as $key => $row) {
                $openTag = '';
                if($row->tag == 'p') {
                    $openTag = '<p class="h4-subtitle-text ">';
                } else {
                    $openTag = '<h4 class="title-text ">';
                }

                echo $openTag . $row->text . "</$row->tag>";
            }
        ?>
    </div>

    <div class="more-signs">
<?
    // get signs list
    $signs = [
        'Овен' => 'aries',
        'Телец' => 'taurus',
        'Близнецы' => 'gemini',
        'Рак' => 'cancer',
        'Лев' => 'leo',
        'Дева' => 'virgo',
        'Весы' => 'libra',
        'Скорпион' => 'scorpio',
        'Стрелец' => 'sagittarius',
        'Козерог' => 'capricorn',
        'Водолей' => 'aquarius',
        'Рыбы' => 'pisces'
    ];
    foreach ($signs as $ruName => $enName) {
        if(mb_strtolower($ruName) == mb_strtolower($sign->name_ru)) continue;
?>
        <div class="sign-wrapper">
            <a href="sign.php?sign=<?=$enName?>&on=day">
                <div class="sign">
                    <div class="sign-img-wrapper"><img src="/img/zodiac-signs/z/<?=$enName?>.png" alt=""></div>
                    <p class="h4-subtitle-text "><?=$ruName?></p>
                </div>
            </a>
        </div>

<?
    }
?>
    </div>

    <? require_once($root.'/parts/footer/footer.php') ?>
 
</body>
</html>