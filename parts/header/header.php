<header class="header" itemscope itemtype="http://schema.org/WPHeader">
    <div class="header-wrapper">
        <span class="logo" itemscope itemtype="http://schema.org/Organization">
            <span style="display: none;" itemprop="name">Таро Гадалка</span>
            <a href="/" itemprop="url">
                <img src="/img/logo.png" alt="Таро Гадалка Логотип" itemprop="logo">
            </a>
        </span>
        <div class="nav" >
            <div class="burger">
                <span class="burger-line"></span>
                <span class="burger-line"></span>
                <span class="burger-line"></span>
            </div>

            <?
                require('nav-links.php');
                use App\LinkPlace;
            ?>

            <ul class="desktop-links">

                <?
                    foreach ($links as $k => $v) {
                        if($v->place != LinkPlace::$Both && $v->place != LinkPlace::$Header) continue;

                        ?>
                        <li class="menu-link" itemscope itemtype="http://schema.org/SiteNavigationElement">
                            <div class="link-wrapper">
                                <a href="<?=$v->url?>" class="text" itemprop="url">
                                    <span class="s-icon">
                                        <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                                    </span>
                                    <span itemprop="name"><?=$v->title?></span>
                                </a>
                                <? 
                                    if(sizeof($v->links) == 0)
                                        continue;
                                ?>
                                <div class="dropdown-menu">
                                    <div class="menu-wrapper">
                                        <?
                                            foreach ($v->links as $k => $link) {
                                        ?>
                                            <div class="menu-item" itemscope itemtype="http://schema.org/SiteNavigationElement">
                                                <div class="learn-more-btn">
                                                    <span class="s-icon">
                                                        <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                                                    </span>
                                                    <a href="<?=$link->url?>" itemprop="url" class="text">
                                                        <span itemprop="name"><?=$link->title?></span>
                                                    </a>
                                                </div>
                                            </div>
                                        <?
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?
                    }
                ?>
            </ul>
        
        </div>
    </div>
    <div class="mobile-links">
        <ul class="links-wrapper">
        <?
        foreach ($links as $k => $v) {
            if (count($v->links) == 0) continue;
            ?>
                <li>
                    <h4 class="title-text "><?=$v->title?></h4>
                    <? foreach($v->links as $k => $link) {?>
                        <div class="learn-more-btn" itemscope itemtype="http://schema.org/SiteNavigationElement">
                            <span class="s-icon">
                                <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                            </span>
                            <a href="<?=$link->url?>" itemprop="url" class="text">
                                <span itemprop="name"><?=$link->title?></span>
                            </a>
                        </div>
                    <?}?>
                </li>
        <?}?>
        </ul>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // setup logo
            if (document.querySelector('body').classList.contains('light')) {
                document.querySelector('.logo img').setAttribute('src', '/img/logo-white.png');
            }
            // 

            let onMain = false;
            let onSub = false;

            let dd = document.querySelectorAll('.dropdown-menu');
            dd.forEach(x => {
                x.onmouseover = function() {
                    onSub = true;
                }
                x.onmouseleave = function() {
                    onSub = false;
                    if (onMain == false) {
                        x.style.display = 'none';
                    }
                }
            });

            let mitems = document.querySelectorAll('.menu-link');
            mitems.forEach(x => {
                let dropdownMenu = x.querySelector('.dropdown-menu');
                    if (!dropdownMenu)
                        return;
                x.onmouseover = function() {
                    onMain = true;
                    dropdownMenu.style.display = 'flex';
                };
                x.onmouseleave =function() {
                    if (onSub == false) {
                        onMain = false;
                        dropdownMenu.style.display = 'none';
                    }
                };
            });
        });
    </script>
</header>

<script src="/js/toggle-menu.js"></script>