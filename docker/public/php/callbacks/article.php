<?
$data = json_decode(file_get_contents('php://input'), true);

$articleId = $data['ida'];

$m = new mysqli(getenv('dbhost'),getenv('dbuser'), getenv('dbpass'), getenv('dbname'));
if ($m->connect_error) {
    die($m->connect_error);
}

$sql = "UPDATE `articles` SET `views` = `views` + 1 WHERE `aid` = $articleId";
$result = $m->query($sql);
$m->close();