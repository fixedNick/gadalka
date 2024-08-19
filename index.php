<!DOCTYPE html>
<html lang="ru" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
	<title>Gadalka | Онлайн расклад карт Таро - Гадалка</title>
    <!-- Dublin Core Meta -->
    <? require_once('utils/dc.php'); ?>
    <meta name="DC.title" content="Gadalka | Онлайн расклад карт Таро - Гадалка">
    <meta name="DC.creator" content="kostudio">
    <meta name="DC.subject" content="<?=$keywords?>">
    <meta name="DC.description" content="Откройте для себя мир Таро и знаки зодиака с нашим бесплатным онлайн сервисом. Получите персональный расклад таро и узнайте больше о своем натальном гороскопе.">
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
    <meta property="og:title" content="Gadalka | Онлайн расклад карт Таро">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?=$baseIdentifier?>">
    <meta property="og:site_name" content="Gadalka | Онлайн расклад карт Таро">
    <meta property="og:description" content="Откройте для себя мир Таро и знаки зодиака с нашим бесплатным онлайн сервисом. Получите персональный расклад таро и узнайте больше о своем натальном гороскопе.">
    <meta property="og:image" content="<?=$baseIdentifier?>/img/blog-bg.jpg">
    <meta property="og:locale" content="ru_RU">
    

    <!-- meta -->
    <meta name="author" content="Gadalka">
    <link rel="canonical" href="<?=$baseIdentifier?>">
    <meta name="keywords" content="<?=$keywords?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Откройте для себя мир Таро и знаки зодиака с нашим бесплатным онлайн сервисом. Получите персональный расклад таро и узнайте больше о своем натальном гороскопе.">
    <!-- add icon -->
    <? require_once('parts/favicon.php');?>

	<!-- js -->

	<script src="js/sky.js"></script>
	<script src="js/card-choose.js"></script>

	<!-- end js -->

	<!-- fonts -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.css" integrity="sha512-U9Y1sGB3sLIpZm3ePcrKbXVhXlnQNcuwGQJ2WjPjnp6XHqVTdgIlbaDzJXJIAuCTp3y22t+nhI4B88F/5ldjFA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Forum&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cactus+Classical+Serif&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

	<!-- end fonts -->

	<!-- self written -->
	<link rel="stylesheet" href="parts/css-normalize.css">
	<link rel="stylesheet" href="parts/header/header.css">
	<link rel="stylesheet" href="parts/footer/footer.css">
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="index.css">
	<!-- end -->
</head>
<body class="dark">
	<? require_once('parts/header/header.php'); ?>

    <div class="cards-wrapper">
        <?
            for ($i=1; $i <= 8; $i++) { 
                ?>
                <span class="taro-card card<?=$i?>">
                    <img src="img/card-back.png" alt="Карты таро" title="Карты таро">
                </span>
                <?
            }
        ?> 
    </div>

    <div class="bg-stars taro-cards-section">
        <div class="taro-cards">
            <div class="text-wrapper">
                <h1 class="title-text dark-bg">ЧТО ЖДЕТ ТЕБЯ СЕГОДНЯ? УЗНАЙ С ПОМОЩЬЮ КАРТ ТАРО!</h1>
                <p class="h1-subtitle-text dark-bg">Открой для себя новые возможности дня: выбери карту Таро и узнай предсказание!</p>
            </div>
        </div>
    </div>

<?
            require_once('php/sign.php');
            require_once('php/element.php');

            $signs = Sign::GetSignArrayFromDB();
            $elements = Element::GetElementsArrayFromDB();
        ?>

    <div class="horoscope-section ">
        <div class="horoscope">
            <div class="text-wrapper">
                <h1 class="title-text dark-bg">Гороскоп на сегодня</h1>
                <p class="h1-subtitle-tex dark-bg">Выбери знак зодиака!</p>
            </div>
            <div class="signs-wrapper">
    <?
            for($i=0; $i<12; $i++)
            {
                ?>
                <div class="zodiac-sign">
                    <div class="img-wrapper"><img src="img/zodiac-signs/constellation/<?=$signs[$i]->name_en?>.png" alt="<?=$signs[$i]->name_ru?>" title="<?=$signs[$i]->name_ru?>"></div>
                    <h4 class="title-text dark-bg"><?=$signs[$i]->name_ru?></h4>
                    <p class="h4-subtitle-text dark-bg"><?=$signs[$i]->ShortDatesString()?></p>
                </div>
                <?
            }
    ?>
            </div>
        </div>
    </div>

    <div class="sign-types-section">
        <?
            foreach ($elements as $key => $element) {
                ?>
             <div class="sign-type">
                <div class="img-wrapper"><img src="/img/elements/<?=$element->en_name;?>.png" alt="<?=$element->ru_name?> знак" title="<?=$element->ru_name?> знак"></div>
                <h3 class="title-text dark-bg"><?=$element->ru_name;?></h3>
                <p class="h4-subtitle-text dark-bg"><?=$element->description;?></p>
                <span class="learn-more-btn dark-bg">
                    <span class="s-icon">
                        <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                    </span>
                    <a href="#" class="text">
                        Узнать больше
                    </a>
                </span>
            </div>    
                <?
            }
        ?>
    </div>
    
    <div class="blog-section">
        <div class="blog-wrapper">
            <h1 class="title-text dark-bg">МАРС: Планета удовольствия</h1>
            <p class="h1-subtitle-text dark-bg">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sint fuga voluptas alias molestias odio voluptate, velit assumenda enim ex vel possimus nesciunt libero. Officia explicabo, voluptates architecto et doloribus quas!</p>
            <span class="learn-more-btn dark-bg">
                <span class="s-icon">
                    <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                </span>
                <a href="#" class="text">
                    Узнать больше
                </a>
            </span>
        </div>
    </div>

    <section class="bg-stars birth-guide">
		<h1 class="title-text dark-bg">ПОЛУЧИТЕ СВОЮ НАТАЛЬНУЮ КАРТУ БЕСПЛАТНО! ЗАПОЛНИТЕ ФОРМУ И ОТКРОЙТЕ СЕКРЕТЫ СВОЕЙ СУДЬБЫ!</h1>
		
		<div class="i-wrapper">
			<div class="input">
				<input type="text" placeholder="Ваше имя">
				<i class="fa-solid fa-user"></i>
			</div>
			<div class="input input-margin">
				<select name="gender" title="Пол" >
					<option value>Пол</option>
					<option value="female">Женский</option>
					<option value="male">Мужской</option>
				</select>
				<i class="fa-solid fa-chevron-down"></i>
			</div>
			<div class="input">
				<input onfocus='(this.type="date")' onblur="(this.type='text')" type="text" placeholder="Дата рождения: дд.мм.гггг">
				<i class="fa-solid fa-calendar-days"></i>
			</div>
			<div class="input input-margin">
				<input onfocus='(this.type="time")' onblur="(this.type='text')" type="text" placeholder="Примерное время рождения">
				<i class="fa-regular fa-clock"></i>
			</div>
			<div class="input">
				<input type="text" placeholder="Где родились">
				<i class="fa-solid fa-location-dot"></i>
			</div>
			<div class="input input-margin">
				<input type="email" placeholder="Ваша почта">
				<i class="fa-solid fa-envelope"></i>
			</div>
		</div>

		<div class="btn btn-accept guide-btn">
			<div class="icon">
				<svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
			</div>
			<div class="text">ПОЛУЧИТЬ</div>
		</div>

	</section>

    <? require_once('parts/footer/footer.php'); ?>

</body>