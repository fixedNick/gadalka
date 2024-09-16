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

    <!-- js -->
    <script src="/js/blog-media.js"></script>

    <title>Gadalka | <?=$title?></title>
</head>
<body class="light">
    <? 
        require_once($root.'/parts/header/header.php');
    ?>


    <?
        require_once($root.'/php/article.php');

        $cat = null;
        if(isset($_GET['cat']) && !empty($_GET['cat'])) {
            $cat = $_GET['cat'];
        }

        $articles = Article::GetArticleList(10, $cat);
    ?>
    <div class="main-wrapper">
        <div class="blog-section">

            <?foreach($articles as $article) {?>
                <div class="post">
                    <div class="post-image">
                        <div class="img-wrapper">
                            <!-- TODO: Local storage, provide path on object creation -->
                            <img src="<?=$article->Image?>" alt="">
                        </div>
                        <div class="post-date"><?=date('M d, Y', $article->CreateTimestamp)?></div>
                    </div>
                    <div class="post-tags">
                        <?foreach($article->Categories as $category) {?>
                        <a href="/"><div class="post-tag"><?=$category[1]?></div></a>
                        <?}?>
                    </div>
                    <h3 class="title-text"><?=$article->Header?></h3>
                    <p class="h4-subtitle-text"><?=$article->GetShortBody()?></p>
                    <span class="learn-more-btn">
                        <span class="s-icon">
                            <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                        </span>
                        
                        <a itemprop="url" href="article.php?h=<?=Article::EncodeBase62($article->ID)?>" class="text">
                            Узнать больше
                        </a>
                    </span>
                </div>
                <hr>
            <?}?>
        </div>
        <?php require_once('sidebar.php');?>
    </div>


    <? require_once($root.'/parts/footer/footer.php') ?>
</body>