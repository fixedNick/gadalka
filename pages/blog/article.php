<?
if(isset($_GET['h']) && !empty($_GET['h'])){
    $hash = $_GET['h'];
} else {
    header('Location: /pages/blog/blog.php');
}
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
        
        $article = Article::GetArticleByHash($hash);
    ?>

    <div class="main-wrapper">
        <div class="blog-section">
            <div class="post">
                <div class="post-image">
                    <div class="img-wrapper">
                        <img src="<?=$article->Image?>" alt="">
                    </div>
                    <div class="post-date"><?=date('M d, Y', $article->CreateTimestamp)?></div>
                </div>
                <div class="post-tags">
                    <?foreach($article->Categories as $category) {?>
                        <a href="/"><div class="post-tag"><?=$category[1]?></div></a>
                    <?}?>
                </div>
                <h1 class="title-text"><?=$article->Header?></h1>
                <div class="article-content">

                    <?
                        foreach($article->Body as $paragraph) {
                            if($paragraph->Tag == 'p' || $paragraph->Tag == 'h4' || $paragraph->Tag == 'h2' || $paragraph->Tag == 'h3' || $paragraph->Tag == 'blockquote') {
                                echo '<' . $paragraph->Tag . ' class="'.$paragraph->ClassList.'">' . $paragraph->Content . '</' . $paragraph->Tag . '>';
                            }

                            if($paragraph->Tag == 'div' && str_contains($paragraph->ClassList, 'double-image')) {
                                echo '<div class="double-image">';
                                foreach(explode(',', $paragraph->Content) as $img) {
                                    echo '<div class="img-wrapper"><img src="' . $img . '" alt=""></div>';
                                }
                                echo '</div>';
                            }
                        }
                    ?>
                        
                    <!-- <div class="double-image">
                        <div class="img-wrapper">
                            <img src="" alt="">
                            <div class="img-subtitle"><p class="h4-subtitle-text">"Карта Перевернутый Дурак"</p></div>
                        </div>
                        <div class="img-wrapper">
                            <img src="" alt="">
                            <div class="img-subtitle"><p class="h4-subtitle-text">"Перевернутая Карта Туз Пентаклей"</p></div>
                        </div>
                    </div> -->
                </div>
                <hr>
                <div class="article-info">
                    <div class="post-tags">
                        <?foreach($article->Categories as $category) {?>
                            <a href="/"><div class="post-tag"><?=$category[1]?></div></a>
                        <?}?>
                    </div>
                    <div class="share">
                        ПОДЕЛИТЬСЯ
                        <i class="fa-brands fa-telegram"></i><i class="fa-brands fa-vk"></i><i class="fa-brands fa-odnoklassniki"></i>
                    </div>
                </div>

            </div>
        </div>
        <?php require_once('sidebar.php');?>
    </div>


    <? require_once($root.'/parts/footer/footer.php') ?>
</body>