<?$root = realpath($_SERVER["DOCUMENT_ROOT"]);?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? 
        require_once($root.'/php/sign.php');
        include_once($root.'/utils/dc.php'); 
        include_once($root.'/parts/head.php'); 
        include_once('keywords.php');
    
        $desc = 'Исследуйте любовную совместимость всех знаков Зодиака на нашей странице. Найдите идеальное партнерство, изучая подробные таблицы и анализ совместимости. Начните свое путешествие к гармоничным отношениям прямо сейчас!'; 
        $title = 'Любовная совместимость знаков Зодиака: Полная таблица и анализ | Знаки Зодиака';

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
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- self css -->
    <link rel="stylesheet" href="..\..\parts/header/header.css">
    <link rel="stylesheet" href="..\..\parts/footer/footer.css">
	<link rel="stylesheet" href="..\..\parts/css-normalize.css">
    <link rel="stylesheet" href="/pages/love-compatibility/love.css">
    <link rel="stylesheet" href="..\..\main.css">

</head>
<body class="light">
    
    <? require_once($root . '/parts/header/header.php'); ?>
    
    <div class="love-outer" itemscope itemtype="http://schema.org/ItemList">
        <div class="love-container">
            <div class="title-area">
                <h1 class="title-text light-bg" itemprop="name">Любовная совместимость</h1>
                <p class="h1-subtitle-text light-bg" itemprop="description">Выбери свой знак зодиака</p>
            </div>
            <?

                echo '<section>';
                $counter = 0;
                foreach ($signs as $key => $sign) {
                    ?>
                            <div class="sign" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                                <a href="love-compatibility/sign?sign=<?=$sign->name_en;?>" itemprop="url">
                                    <div class="img-wrapper"><img itemprop="image" src="../../img/zodiac-signs/circle/<?=$sign->name_en;?>.png" alt="zodiac-sign-<?=$sign->name_en;?>"></div>
                                    <div class="sign-name" itemprop="name">
                                        <h4 class="title-text light-bg"><?=$sign->name_ru;?></h4>
                                        <p class="date h4-subtitle-text light-bg"><?=$sign->ShortDatesString()?></p>
                                    </div>
                                </a>
                                <meta itemprop="position" content="<?=($counter + 1);?>">
                            </div>

                    <?

                    $counter++;
                    if($counter == 6) echo '</section><section>';
                }

                echo '</section>';
                ?>
        </div>
    </div>
    <? require_once($root.'/parts/footer/footer.php') ?>

</body>
</html>