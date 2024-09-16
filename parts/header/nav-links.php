<?

namespace App;

class LinkPlace {
    public static $Header = 1;
    public static $Footer = 2;
    public static $Both = 3;
}

class Link {
    // @var string
    public $title = '';
    // @var string
    public $url = '';
    // @var Link[]
    public $links = [];
    // @var LinkPlace
    public $place;

    public function __construct($title, $links = [], $url = '#', $place = 3) {
        $this->title = $title;
        $this->url = $url;
        $this->links= $links;
        $this->place = $place;
    }
}
// @var Link[]
$links = [
    new Link("Главная", [], '/'), 
    new Link('Гороскоп', [
        new Link('На День', [], '/pages/horoscope/horoscope.php?on=day'),
        new Link('На Месяц', [], '/pages/horoscope/horoscope.php?on=month'),
        new Link('На Год', [], '/pages/horoscope/horoscope.php?on=year'),
        new Link('Любовная Совместимость', [], '/pages/love-compatibility/love.php'),
    ], '/pages/horoscope/horoscope.php', LinkPlace::$Both),
    new Link('Таро', [
        new Link('Значение карт', [], '/pages/taro/cards.php'),
        new Link('Ваша карта дня', [], '/'),
        new Link('Попробуйте гадание', [], '/'),
    ], '/pages/taro/cards.php', LinkPlace::$Both),
    new Link('Блог', [
        new Link('Астрология'),
        new Link('Любовная Астрология'),
        new Link('Таро'),
        new Link('Знаки зодиака'),
    ], '/pages/blog/blog.php', LinkPlace::$Both),
    new Link('Гадание', [
        new Link('Гадание на любовь'),
        new Link('Гадание на финансы'),
        new Link('Гадание на отношения'),
        new Link('Гадание на семью'),
    ], '#', LinkPlace::$Footer),
    new Link('Расклады', [
        new Link('Расклад на 1 карту'),
        new Link('Расклад на 3 карты'),
        new Link('Расклад на 5 карт'),
        new Link('Расклад на 7 карт'),
    ], '#', LinkPlace::$Footer)
];
