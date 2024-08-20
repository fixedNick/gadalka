<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
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
    
        $desc = 'Откройте для себя глубокие истины Таро, Астрологии и Гороскопов на нашем блоге. Узнайте о мистических аспектах жизни, исследуйте любовную совместимость и получите уникальные предсказания. Погрузитесь в мир тайн и знаний, которые изменят ваш взгляд на реальность.'; 
        $title = 'Таро, Астрология и Гороскопы: Погружение в Мистику и Любовную Совместимость | Блог о Мистических Истинах';
    ?>
    <meta name="DC.title" content="Gadalka | <?=$title?>">
    <meta name="DC.creator" content="kostudio">
    <meta name="DC.subject" content="<?=$keywords?>">
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
	<link rel="stylesheet" href="..\..\parts/banners/banners.css">
	<link rel="stylesheet" href="/main.css">
    <link rel="stylesheet" href="blog.css">
    <link rel="stylesheet" href="article.css">

    <title>Gadalka | <?=$title?></title>
</head>
<body class="light">
    <? 
        require_once($root.'/parts/header/header.php');
    ?>

    <div class="main-wrapper">
        <div class="blog-section">
            <div class="post">
                <div class="post-image">
                    <div class="img-wrapper">
                        <img src="https://synastry.qodeinteractive.com/wp-content/uploads/2023/03/blog-sidebar-img.jpg" alt="">
                    </div>
                    <div class="post-date">АВГУСТ 08, 2024</div>
                </div>
                <div class="post-tags">
                    <a href="/"><div class="post-tag">Таро</div></a>
                    <a href="/"><div class="post-tag">Астрология</div></a>
                    <a href="/"><div class="post-tag">Гороскопы</div></a>
                </div>
                <h1 class="title-text">ЗНАЧЕНИЕ САТУРНА В ПЯТОМ ДОМЕ ДЛЯ СКОРПИОНОВ И СТРЕЛЬЦОВ</h1>
                <div class="article-content">
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                    <p class="h1-subtitle-text">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus illum necessitatibus fugit, consectetur dignissimos perferendis eligendi asperiores quasi veritatis debitis rem incidunt deleniti culpa obcaecati quae voluptatum, aliquid odit aperiam.</p>
                </div>
            </div>
        </div>
        <?php require_once('sidebar.php');?>
    </div>


    <? require_once($root.'/parts/footer/footer.php') ?>
</body>