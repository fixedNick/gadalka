<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

$maxOffset = 15;
$page = 0;

if (isset($_GET['page']) && $_GET['page'] >= 1)
{
    if($_GET['page'] > $maxOffset) {
        $page = 0;
    } else $page = $_GET['page'];
}
?>

<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- seo -->
    <? 
        include_once($root.'/utils/dc.php'); 
        include_once($root.'/parts/head.php'); 
    
        $desc = 'Откройте для себя мир Таро: подробное описание всех карт, глубокие расклады, астрологические соответствия и актуальные гороскопы. Узнайте, как Таро может пролить свет на вашу судьбу и помочь в принятии решений. Погрузитесь в древнюю мудрость и откройте новые горизонты с нашим всеобъемлющим ресурсом.'; 
        $title = 'Все Карты Таро в Одном Месте: Детальные Описания и Их Значения';

        // Filling additional keywords for cards page
        require_once($root.'/php/Card.php');
        $ru_names = Card::GetAllRuNames();

        $additionalKeywords = ',';
        $additionalKeywords .= 'таро все карты,';
        $additionalKeywords .= 'все карты таро,';
        foreach($ru_names as $ru_name) {
            $additionalKeywords .= "$ru_name->ru_name таро,";
            $additionalKeywords .= "таро $ru_name->ru_name,";
            $additionalKeywords .= "карта таро $ru_name->ru_name,";
            $additionalKeywords .= "таро карта $ru_name->ru_name,";
            $additionalKeywords .= "что значит $ru_name->ru_name таро,";
            $additionalKeywords .= "что означает $ru_name->ru_name таро,";
            $additionalKeywords .= "какое значение $ru_name->ru_name таро,";
            $additionalKeywords .= "$ru_name->ru_name значение,";
            $additionalKeywords .= "$ru_name->ru_name таро значение,";
            $additionalKeywords .= "значение $ru_name->ru_name,";
            $additionalKeywords .= "значение таро $ru_name->ru_name,";
            $additionalKeywords .= "значение $ru_name->ru_name таро,";
            $additionalKeywords .= "перевернутая $ru_name->ru_name значение,";
            $additionalKeywords .= "перевернутая $ru_name->ru_name значение таро,";
            $additionalKeywords .= "перевернутая $ru_name->ru_name таро значение,";
            $additionalKeywords .= "значение карты $ru_name->ru_name,";
            $additionalKeywords .= "значение карты таро $ru_name->ru_name,";
            $additionalKeywords .= "таро значение $ru_name->ru_name,";
            $additionalKeywords .= "таро значение карты $ru_name->ru_name,";
            $additionalKeywords .= "таро значение $ru_name->ru_name карты,";
            $additionalKeywords .= "таро $ru_name->ru_name любовь,";
            $additionalKeywords .= "таро $ru_name->ru_name в любови,";
            $additionalKeywords .= "таро любовь $ru_name->ru_name,";
            $additionalKeywords .= "любовь таро $ru_name->ru_name,";
            $additionalKeywords .= "карьера таро $ru_name->ru_name,";
            $additionalKeywords .= "таро карьера $ru_name->ru_name,";
        }
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
 
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- own css -->
    <link rel="stylesheet" href="..\..\parts/header/header.css">
    <link rel="stylesheet" href="..\..\parts/footer/footer.css">
    <link rel="stylesheet" href="..\..\parts/pagination/pagination.css">
	<link rel="stylesheet" href="..\..\parts/css-normalize.css">
	<link rel="stylesheet" href="/main.css">
    <link rel="stylesheet" href="cards.css">

    <title>Gadalka | <?=$title?></title>
</head>
<body class="dark">
    
    <? 
    require_once($root.'/parts/header/header.php');
    include('parts/taro-card.php');

    $m = new mysqli("localhost", "root", "root", "taro");

    if($m->connect_error) {
        die($m->connect_error);
    }

    class Card1 {
        public $id;
        public $en_name;
        public $ru_name;
        public $desc;

        public function __construct($id, $en_name, $ru_name) {
            $this->id = $id;
            $this->en_name = $en_name;
            $this->ru_name = $ru_name;
        }
    }
    $limit = 5;
    $offset = $page*$limit;

    $r = $m->query("SELECT `id`, `en_name`, `ru_name` FROM taro_single_card ORDER BY id LIMIT $limit OFFSET $offset");

    $cards = [];

    while($row = $r->fetch_assoc()) {
        array_push($cards, new Card1($row['id'], $row['en_name'], $row['ru_name']));
    }


    foreach($cards as $idx => $card) {
        $r = $m->query("SELECT * FROM single_card_desc WHERE card_id=$card->id and on_page_index = 0 LIMIT 1");
        while($row = $r->fetch_assoc()) {
            $card->desc = $row['desc_value'];
        }   
    }
    $m->close();
    ?>

    <div class="container">
        <?
        foreach($cards as $idx => $card) {
            echo GetCardHTML($card->ru_name, $card->desc, 'card.php?cid='.$card->id, $card->id);
        }
        ?>
    </div>
    
    <? 
        require_once($root.'/parts/pagination/pagination.php');
        echo getPagination($page, $maxOffset, '/pages/taro/cards.php');
    ?>
    <? require_once($root.'/parts/footer/footer.php') ?>
</body>
</html>