<?

function getPagination($currentPage, $totalPages, $clearLink) {
    $currentPage += 1;
    $displayCount = 5;
  
    $from = $currentPage*$displayCount - $displayCount;
    if($currentPage == 1) {
      $from = '1';
    }
    $to = $currentPage*$displayCount;
    $inactiveLeft = '';
    $inactiveRight = '';

    $prevPage = 'href=\'' .$clearLink . '?page=' . $currentPage - 2 . '\'';
    $nextPage = 'href=\'' .$clearLink . '?page=' . $currentPage . '\'';

    if($currentPage == 1) {
      $inactiveLeft = 'inactive';
      $prevPage = '';
    }
    else if($currentPage-1 == $totalPages) {
      $inactiveRight = 'inactive';
      $nextPage = '';
      $to = '78';
    }

    return "<div class='pagination-container'>
      <span class='pagination-count'>$from - $to из 78</span>
      <a $prevPage><span class='pagination-btn left $inactiveLeft'><</span></a>
      <a $nextPage><span class='pagination-btn rigth $inactiveRight'>></span></a>
    </div>";
}
