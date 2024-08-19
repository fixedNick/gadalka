<?$root = realpath($_SERVER["DOCUMENT_ROOT"]);

require_once($root.'/php/sign.php');

$signs = Sign::GetSignArrayFromDB();

if (!isset($_GET['sign']) || !array_filter($signs, function($sign) {
    return $_GET['sign'] === $sign->name_en;
})) {
    header('Location:' . '/pages/love-compatibility/love.php');
    die();
}

// get selected sign
$selectedSign = null;
foreach ($signs as $key => $value) {
    if ($value->name_en === $_GET['sign']) {
        $selectedSign = $value;
        break;
    }
}
//
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- seo -->
    <? 
        require_once($root.'/php/sign.php');
        include_once($root.'/utils/dc.php'); 
        include_once($root.'/parts/head.php'); 
        include_once('keywords.php');
    
        $desc = 'Откройте для себя секреты любовной совместимости для '.$selectedSign->name_ru.'. Наша страница предлагает глубокий анализ отношений с каждым из знаков Зодиака, помогая вам найти идеального партнера. Начните строить гармоничные отношения уже сегодня!'; 
        $title = 'Любовная совместимость '.$selectedSign->name_ru.': Подробный анализ партнерств | Знаки Зодиака';

        // Filling additional keywords for cards page
        $additionalKeywords = ',' . $love_keywords . ',';
        $signs = Sign::GetSignArrayFromDB();
        foreach ($signs as $key => $sign) {
            $additionalKeywords .= 'совместимость' . $sign->name_ru . ',';
            $additionalKeywords .= $sign->name_ru . ' совместимость,';
            $additionalKeywords .= $sign->name_ru . ' любовный гороскоп,';

            foreach($signs as $kkk => $sign2) {
                $additionalKeywords .= 'совместимость ' . $sign->name_ru . ' и ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'любовная совместимость ' . $sign->name_ru . ' и ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'совместимость мужчины ' . $sign->name_ru . ' и женщины ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'любовная совместимость мужчины ' . $sign->name_ru . ' и женщины ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'совместимость женщины ' . $sign->name_ru . ' и мужчины ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'любовная совместимость женщины ' . $sign->name_ru . ' и мужчины ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'совместимость девушки ' . $sign->name_ru . ' и парня ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'любовная совместимость девушки ' . $sign->name_ru . ' и парня ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'совместимость парня ' . $sign->name_ru . ' и девушки ' . $sign2->name_ru . ',';
                $additionalKeywords .= 'любовная совместимость парня ' . $sign->name_ru . ' и девушки ' . $sign2->name_ru . ',';
            }
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
    <link rel="stylesheet" href="compatibility.css">
</head>
<body class="light">
    <? require_once($root . '/parts/header/header.php'); ?>
    <div class="container" itemscope itemtype="http://schema.org/WebPage">
        <div class="compatibility">
            <h1 class="title-text" itemprop="name"><?=mb_convert_case($selectedSign->name_ru, MB_CASE_TITLE, "UTF-8")?>. Любовная совместимость.</h1>
            <p class="h1-subtitle-text" ><?=$selectedSign->FullDatesString();?></p>

            <?
                $m = new mysqli('localhost', 'root', 'root', 'taro');
                
                for($i = 1; $i <= 12; $i++) {

                    $r = $m->query("select * from love where (s1='$selectedSign->id' and s2='$i') or (s1='$i' and s2='$selectedSign->id') ORDER BY on_page_idx");
                    $rows = [];
                    while($row = $r->fetch_assoc()) {
                        array_push($rows, 
                            (object)[
                                's1' => $row['s1'],
                                's2' => $row['s2'],
                                'tag' => $row['html_tag'],
                                'text' => $row['html_value'],
                                'idx' => $row['on_page_idx']
                            ]
                        );
                    }

                    if (empty($rows)) continue;

                    $targetWithId = $rows[0]->s1 == $selectedSign->id ? $rows[0]->s2 : $rows[0]->s1;
                    $targetWithSign;
                    foreach ($signs as $key => $s) {
                        if ($s->id == $targetWithId) {
                            $targetWithSign = $s;
                            break;
                        }
                    }
                    ?>
            
            <h3 class="title-text" itemprop="description"><a id="<?=$selectedSign->name_ru.'&'.$targetWithSign->name_ru?>"><?=$selectedSign->name_ru.' & '.$targetWithSign->name_ru?></a></h3>

                    <?
                    foreach ($rows as $key => $row) {
                        $startTag ='';
                        if($row->tag == 'p') {
                            $startTag = '<p class="h1-subtitle-text ">';
                        } else if ($row->tag == 'h4') {
                            $startTag = '<h4 class="title-text ">';
                            if (str_starts_with($row->text, '1.') || str_starts_with($row->text, '2.') || str_starts_with($row->text, '3.') || str_starts_with($row->text, '4.') || str_starts_with($row->text, '5.')) {
                                $row->text = trim(substr($row->text, 2));
                            }
                            
                        }
                        echo $startTag . $row->text . "</$row->tag>";
                    }
                }
            ?>

        </div>
        <div class="list-section" itemprop="mainEntity" itemscope itemtype="http://schema.org/ItemList">
            <div class="img-wrapper"><img itemprop="image" src="/img/zodiac-signs/circle/<?=$selectedSign->name_en?>.png" alt="Знак зодиака <?=$selectedSign->name_ru?>"></div>
            <h4 class="title-text" itemprop="name">Совместимость</h4>
            <?foreach ($signs as $k => $s) {?>
            <div class="learn-more-btn">
                <span class="s-icon">
                    <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                </span>
                <?
                $linkAndText = $selectedSign->name_ru . ' & ' . $s->name_ru;
                ?>
                <a itemprop="url" href="#<?=str_replace(' ', '', $linkAndText)?>" class="text">
                    <?=$linkAndText?>
                </a>
            </div>
            <?}?>
        </div>
    </div>
    <? require_once($root.'/parts/footer/footer.php') ?>

</body>
</html>