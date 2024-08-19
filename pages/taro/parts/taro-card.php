<?
function GetCardHTML($name, $desc, $link, $imgName) {
return '
<div class="card-wrapper" itemscope itemtype="http://schema.org/CreativeWork">
    <div class="card-img-wrapper">
        <img src="/img/cards/'.$imgName.'.png" alt="card" itemprop="image">
    </div>     
    <div class="card-info" >
        <div class="card-info-header">
        <h1 class="taro-header-title title-text" itemprop="name">'.$name.'</h1>
        </div>
        <div class="card-info-body" itemprop="description">
            <p class="subtitle-text">
            '.$desc.'
            </p>
        </div>
        <span class="learn-more">
            <a href="'.$link.'" itemprop="url">
                <span class="icon">
                    <svg class="star-icon" xmlns="http://www.w3.org/2000/svg" width="10.74" height="13.387" viewBox="0 0 10.74 13.387" fill="currentColor"><path d="M10.608 6.877a8.066 8.066 0 0 1-3.345-1.454c-1-.939-1.519-3.711-1.786-5.281a.172.172 0 0 0-.339 0c-.236 1.61-.756 4.518-1.9 5.508a7.393 7.393 0 0 1-3.1 1.249.171.171 0 0 0 0 .335 7.437 7.437 0 0 1 3.454 1.628c.856.876 1.3 3.033 1.523 4.378a.172.172 0 0 0 .339 0c.207-1.34.622-3.495 1.465-4.373a7.487 7.487 0 0 1 3.689-1.655.171.171 0 0 0 0-.335Z"></path>
                    </svg>
                </span>
                <span class="text">
                    Узнать больше
                </span>
            </a>
        </span>
    </div>   
</div>';
}