<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);

if(isset($_GET['cid']) == false || ($_GET['cid'] < 4 || $_GET['cid'] > 81)) {
    header('Location: /taro/cards');
    die();
}

require_once($root.'/php/card.php');
$card = Card::NewFromCid($_GET['cid']);

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
    
        $desc = 'Узнайте все о карте Таро '.$card->ru_name.' в нашем подробном руководстве. Откройте для себя символику, толкование и влияние '.$card->ru_name.' на вашу жизнь. Погрузитесь в мир Таро с нами!'; 
        $title = 'Значение карты Таро '.$card->ru_name.': Толкование и Символика | Тарология';

        // Filling additional keywords for cards page
        $additionalKeywords = ',';
        $additionalKeywords .= 'таро все карты,';
        $additionalKeywords .= 'все карты таро,';
        $additionalKeywords .= "$card->ru_name таро,";
        $additionalKeywords .= "таро $card->ru_name,";
        $additionalKeywords .= "карта таро $card->ru_name,";
        $additionalKeywords .= "таро карта $card->ru_name,";
        $additionalKeywords .= "что значит $card->ru_name таро,";
        $additionalKeywords .= "что означает $card->ru_name таро,";
        $additionalKeywords .= "какое значение $card->ru_name таро,";
        $additionalKeywords .= "$card->ru_name значение,";
        $additionalKeywords .= "$card->ru_name таро значение,";
        $additionalKeywords .= "значение $card->ru_name,";
        $additionalKeywords .= "значение таро $card->ru_name,";
        $additionalKeywords .= "значение $card->ru_name таро,";
        $additionalKeywords .= "перевернутая $card->ru_name значение,";
        $additionalKeywords .= "перевернутая $card->ru_name значение таро,";
        $additionalKeywords .= "перевернутая $card->ru_name таро значение,";
        $additionalKeywords .= "значение карты $card->ru_name,";
        $additionalKeywords .= "значение карты таро $card->ru_name,";
        $additionalKeywords .= "таро значение $card->ru_name,";
        $additionalKeywords .= "таро значение карты $card->ru_name,";
        $additionalKeywords .= "таро значение $card->ru_name карты,";
        $additionalKeywords .= "таро $card->ru_name любовь,";
        $additionalKeywords .= "таро $card->ru_name в любови,";
        $additionalKeywords .= "таро любовь $card->ru_name,";
        $additionalKeywords .= "любовь таро $card->ru_name,";
        $additionalKeywords .= "карьера таро $card->ru_name,";
        $additionalKeywords .= "таро карьера $card->ru_name,";
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

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
 
    <!-- self css -->
    <link rel="stylesheet" href="..\..\parts/header/header.css">
    <link rel="stylesheet" href="..\..\parts/footer/footer.css">
	<link rel="stylesheet" href="..\..\parts/css-normalize.css">
	<link rel="stylesheet" href="/main.css">
    <link rel="stylesheet" href="/pages/taro/card.css">
</head>
<body class="dark">
    
    <? require_once($root.'/parts/header/header.php') ?>
    
    <div class="card-info-container" itemscope itemtype="http://schema.org/Article">
        <div class="card-img-wrapper">
            <img src="/img/cards/<?=$card->id?>.png" itemprop="image" alt="Карта Таро <?=$card->ru_name?>">
        </div>

        <div class="card-info-wrapper">
            <div class="card-title" itemprop="name"><?=$card->ru_name?></div>

            <?$card->PrintDesc('baseDesc');?>
            <? if(count($card->baseInfo->up_keywords) > 0) { ?>
            <h3 class="h3-title-text">Ключевые слова при прямом положении</h3>
            <?$card->PrintKeywords('base_up'); }?>
            
            <? if(count($card->baseInfo->rev_keywords) > 0) { ?>
            <h3 class="h3-title-text">Ключевые слова при перевернутом положении</h3>
            <?$card->PrintKeywords('base_rev');  }?>

            <? if(count($card->baseInfo->up_desc) > 0) { ?>
            <h3 class="h3-title-text">Прямое положение. Значение карты</h3>
            <?$card->PrintDesc('base_up'); }?>

            <? if(count($card->baseInfo->rev_desc) > 0) { ?>
            <h3 class="h3-title-text">Перевернутое положение. Значение карты</h3>
            <?$card->PrintDesc('base_rev'); }?>

            <? if(count($card->loveInfo->up_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на любовь. Ключевыые слова при прямом положении</h3>
            <?$card->PrintKeywords('love_up');  }?>

            <? if(count($card->loveInfo->rev_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на любовь. Ключевыые слова при перевернутом положении</h3>
            <?$card->PrintKeywords('love_rev');  }?>

            <? if(count($card->loveInfo->up_desc) > 0) { ?>
            <h3 class="h3-title-text">Любовь и Прямое положение. Значение карты</h3>
            <?$card->PrintDesc('love_up'); }?>

            <? if(count($card->loveInfo->rev_desc) > 0) { ?>
            <h3 class="h3-title-text">Любовь и перевернутое положение. Значение карты</h3>
            <?$card->PrintDesc('love_rev'); }?>

            <? if(count($card->careerInfo->up_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на карьеру. Ключевыые слова при прямом положении</h3>
            <?$card->PrintKeywords('career_up');  }?>

            <? if(count($card->careerInfo->rev_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на карьеру. Ключевыые слова при перевернутом положении</h3>
            <?$card->PrintKeywords('career_rev');  }?>

            <? if(count($card->careerInfo->up_desc) > 0) { ?>
            <h3 class="h3-title-text">Карьера и Прямое положение. Значение карты</h3>
            <?$card->PrintDesc('career_up'); }?>

            <? if(count($card->careerInfo->rev_desc) > 0) { ?>
            <h3 class="h3-title-text">Карьера и перевернутое положение. Значение карты</h3>
            <?$card->PrintDesc('career_rev'); }?>

            <? if(count($card->financeInfo->up_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на финансы и благосостояние. Ключевыые слова при прямом положении</h3>
            <?$card->PrintKeywords('finance_up');  }?>

            <? if(count($card->financeInfo->rev_keywords) > 0) { ?>
            <h3 class="h3-title-text">Расклад на финансы и благосостояние. Ключевыые слова при перевернутом положении</h3>
            <?$card->PrintKeywords('finance_rev');  }?>

            <? if(count($card->financeInfo->up_desc) > 0) { ?>
            <h3 class="h3-title-text">Финансы и Благосостояние при Прямом положении. Значение карты</h3>
            <?$card->PrintDesc('finance_up'); }?>

            <? if(count($card->financeInfo->rev_desc) > 0) { ?>
            <h3 class="h3-title-text">Финансы и Благосостояние при перевернутом положении. Значение карты</h3>
            <?$card->PrintDesc('finance_rev'); }?>
           
        </div>

        <div class="share-reading-wrapper" itemscope itemtype="http://schema.org/WebPageElement">
        <meta itemprop="description" content="Поделиться статьей">

            <div class="share-reading-title">
                <h3 class="share-title">Поделиться</h3>
            </div>            

            <ul class="links-list" itemprop="hasPart" itemscope itemtype="http://schema.org/ItemList">
                <li class="sm-link" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span>
                        <i class="fa-brands fa-square-odnoklassniki"></i>
                    </span>
                    <a itemprop="url" href="#">Одноклассники</a>
                    <meta itemprop="position" content="1">
                </li>
                <li class="sm-link" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span>
                        <i class="fa-brands fa-telegram"></i>
                    </span>
                    <a itemprop="url" href="#">Телеграм</a>
                    <meta itemprop="position" content="2">
                </li>
                <li class="sm-link" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span>
                        <i class="fa-brands fa-vk"></i>
                    </span>
                    <a itemprop="url" href="#">Вконтакте</a>
                    <meta itemprop="position" content="3">
                </li>
                <li class="sm-link" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <span>
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </span>
                    <a itemprop="url" href="#">Скопировать ссылку</a>
                    <meta itemprop="position" content="4">
                </li>
            </ul>
        </div>
    </div>

    <? require_once($root.'/parts/footer/footer.php') ?>
</body>
</html>