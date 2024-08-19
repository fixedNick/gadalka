<footer itemscope itemtype="http://schema.org/WPFooter">
    <div class="links-container">
        <? use App\LinkPlace; ?>
        <?foreach($links as $k => $l) {
            if($l->place != LinkPlace::$Both && $l->place != LinkPlace::$Footer) continue;

            if(count($l->links) == 0) continue;
            ?>
                <div class="footer-links-wrapper">
                    <a href="<?=$l->url?>"><h4 class="title-text "><?=$l->title?></h4></a>
                    <? foreach($l->links as $k => $link) {?>
                        <div class="learn-more-btn" itemscope itemtype="http://schema.org/SiteNavigationElement">
                            <span class="s-icon">
                                <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                            </span>
                            <a itemprop="url" href="<?=$link->url?>" class="text">
                                <span itemprop="name"><?=$link->title?></span>
                            </a>
                        </div>
                    <?}?>
                    
                </div>
            <?
        }?>
       
    </div>
    <div class="social-media-wrapper">
        <p class="h3-subtitle-text">Подписывайтесь на нас в социальных сетях:</p>
        <div class="social-logo">
            <a target='blank' href="https://dzen.ru/gadalka_magic"><i class="fa-brands fa-yandex"></i></a>
            <a target='blank' href="https://ok.ru/group/70000006796391"><i class="fa-brands fa-square-odnoklassniki"></i></a>
            <a target='blank' href="https://vk.com/club227014770"><i class="fa-brands fa-vk"></i></a>
            <a target='blank' href="https://t.me/e21rj3ifreij"><i class="fa-brands fa-telegram"></i></a>
        </div>
    </div>
    <div class="creator-container" itemscope itemtype="http://schema.org/Organization">
        <span style="display: none;" itemprop="name">Таро Гадалка</span>
        <div class="footer-img-wrapper">
            <a href="/" itemprop="url">
                <img src="/img/logo.png" alt="Таро Онлайн Гадалка Логотип" title="Таро Онлайн Гадалка Логотип" itemprop="logo">
            </a>
        </div>
        <p class="h4-subtitle-text ">© kostudio production 2024. Все права защищены.</p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if(document.querySelector('body').classList.contains('light')) {
            document.querySelector('.footer-img-wrapper img').setAttribute('src', '/img/logo-white.png');
        }
    });
</script>