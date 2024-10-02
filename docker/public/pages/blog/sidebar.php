<?
    $popularArticles = Article::GetPopularArticles(2);
    $categories = Article::GetAllCategories();
?>
<div class="sidebar">
    <div class="categories">
        <h4 class="title-text">Категории</h4>
        <ul>
            <?foreach($categories as $cat) {?>
            <li>
                <span class="learn-more-btn">
                    <span class="s-icon">
                        <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                    </span>
                    
                    <a itemprop="url" href="/" class="text">
                        <?=$cat?>
                    </a>
                </span>
            </li>
            <?}?>
        </ul>



    </div>
    <div class="popular-posts">
        <h4 class="title-text">Популярные статьи</h4>
        <?foreach($popularArticles as $article) {?>
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
            <h3 class="title-text"><?=$article->Header?></h3>
            <span class="learn-more-btn">
                <span class="s-icon">
                    <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path></svg>
                </span>
                
                <a itemprop="url" href="/" class="text">
                    Узнать больше
                </a>
            </span>
        </div>
        <?}?>
    </div>
    <?php
        include_once($root.'/parts/banners/banners.php');
    ?>
</div>