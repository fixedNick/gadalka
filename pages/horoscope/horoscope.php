<?$root = realpath($_SERVER["DOCUMENT_ROOT"]);?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- seo -->
    <? 
        include_once($root.'/utils/dc.php'); 
        include_once($root.'/parts/head.php'); 
        $year = date_format(new DateTime(), "Y");
        $desc = 'Получите точные и актуальные гороскопы на каждый день, месяц и весь '.$year.' год для всех знаков Зодиака. Наша страница предлагает подробные астрологические прогнозы, которые помогут вам спланировать свою жизнь и принять важные решения.'; 
        $title = 'Гороскоп на '.$year.' год: На день, На месяц, На год Прогноз для всех Знаков Зодиака';

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
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

    <!-- self css -->
    <link rel="stylesheet" href="..\..\parts/header/header.css">
    <link rel="stylesheet" href="..\..\parts/footer/footer.css">
    <link rel="stylesheet" href="..\..\parts/css-normalize.css">
    <link rel="stylesheet" href="..\..\main.css">
    <link rel="stylesheet" href="horoscope.css">

</head>
<body class="light">
    <? require_once($root . '/parts/header/header.php'); ?>
    
    <div class="horoscope-container">
        <div class="horoscope-title">
            <h1 class="title-text">Твой гороскоп</h1>
        </div>

        <div class="sections-wrapper">
            <section class="signs">
                <div class="filters">
                    <div class="filter"><p class=" "><a href="?on=day">Дневной</a></p></div>
                    <div class="filter"><p class=" "><a href="?on=month">Месячный</a></p></div>
                    <div class="filter"><p class=" "><a href="?on=year">Годовой</a></p></div>
                </div>

                <? 
                    require_once("../../php/sign.php");
                    $signs = Sign::GetSignArrayFromDB();

                    if (isset($_GET['on']) == false || strlen($_GET['on']) == 0) {
                        $_GET['on'] = 'day';
                    }

                    $imgPathArr = [
                        'day' => 'animal', 
                        'month' => 'circle',
                        'year' => 'constellation'
                    ];

                    foreach ($signs as $k => $sign) {
                ?>
                <div class="sign">
                    <div class="img-wrapper"><img src="/img/zodiac-signs/<?=$imgPathArr[$_GET['on']]?>/<?=$sign->name_en?>.png" alt=""></div>
                    <div class="sign-desc">
                        <h4 class="title-text "><?=$sign->name_ru?></h4>
                        <p class="h4-subtitle-text "><?=$sign->description?></p>
                        <div class="learn-more-btn ">
                            <span class="s-icon">
                                <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                            </span>
                            <a href="sign.php?sign=<?=$sign->name_en?>&on=<?=$_GET['on']?>" class="text">
                                Изучить гороскоп
                            </a>
                        </div>
                    </div>
                </div>

                <?}?>
                
            </section>
            <section class="banners">
                <div class="btn white-btn">
                    <div class="learn-more-btn ">
                        <span class="s-icon">
                            <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                        </span>
                        <a href="../love-compatibility/love.php" class="text">
                            Изучить гороскоп
                        </a>
                    </div>
                </div>
            </section>
        </div>
        
    </div>

    <? require_once($root . '/parts/footer/footer.php'); ?>

</body>
</html>