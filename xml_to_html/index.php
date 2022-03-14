<?php

//Конфигурация
$login = "user"; //Логин
$pass = "pass"; //Пароль
$num = 20; //Постов на странице
//Конфигурация


error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

if (!isset($_SERVER['PHP_AUTH_USER']) || !($_SERVER['PHP_AUTH_USER'] == $login && $_SERVER['PHP_AUTH_PW'] == $pass)) {
    header('WWW-Authenticate: Basic realm=""');
    header('HTTP/1.0 401 Unauthorized');
    exit;
}

$xml = simplexml_load_file("feed.xml") or die("Error: Cannot create object");
$posts_all = xml2array($xml);

//print_r($posts_all['channel']['item'][0]);
//exit;

$count = count($posts_all['channel']['item']);

if (isset($_GET['page'])) {
    $page2 = $_GET['page'];
} else {
    $page2 = 0;
}

$pervpage = '';
$page2left = '';
$page1left = '';
$activepage = '';
$page1right = '';
$page2right = '';
$nextpage = '';
$posts = $count;
$total = intval(($posts - 1) / $num) + 1;
$page2 = intval($page2);
if(empty($page2) or $page2 < 0) $page2 = 1;
if ($total == 1) {
    $pagenav = '';
    $start = 0;
    $end = $num;
} else {
    if($page2 > $total) $page2 = $total;
    $start = $page2 * $num - $num;
    $end = ($start + $num > $posts) ? $posts : $start + $num;
    if ($page2 != 1) $pervpage = '<li class="page-item"><a class="page-link" href="./index.php?page=1"><<</a></li>
            <li class="page-item"><a class="page-link" href="./index.php?page=' . ($page2 - 1) . '"><</a></li>';
    if ($page2 != $total) $nextpage = '<li class="page-item"><a class="page-link" href="./index.php?page=' . ($page2 + 1) . '">></a></li>
            <li class="page-item"><a class="page-link" href="./index.php?page=' . $total . '">>></a></li>';
    if($page2 - 1 > 0) $page1left = '<li class="page-item"><a class="page-link" href="./index.php?page=' . ($page2 - 1) . '">' . ($page2 - 1) . '</a></li>';
    if($page2 + 1 <= $total) $page1right = '<li class="page-item"><a class="page-link" href="./index.php?page=' . ($page2 + 1) . '">' . ($page2 + 1) . '</a></li>';
    if($posts) $activepage = '<li class="page-item active"><a class="page-link" href="#">' . $page2 . '</a></li>';
    $pagenav = $pervpage . $page1left . $activepage . $page1right . $nextpage;
}

$posts = array_slice($posts_all['channel']['item'], $start, $num);

function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Посты</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/navbar-fixed/">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href=".">Посты</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
        </div>
    </div>
</nav>

<main class="container">
    <div class="rounded mt-5">
        <h1 class="">Посты</h1>
        <?php $i = 1; ?>
        <?php foreach ($posts as $key => $post) { ?>
            <div class="card mb-5">
                <div class="card-header">
                    <?=$post->pubDate?>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$post->title?></h5>
                    <p class="card-text">Автор: <?=$post->author?></p>
                    <p class="card-text"><a href="<?=$post->link?>"><?=$post->link?></a></p>
                    <button class="btn btn-primary mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample<?=$i?>" aria-expanded="false" aria-controls="collapseExample<?=$i?>">
                        Читать
                    </button>
                    <div class="card-text collapse" id="collapseExample<?=$i?>"><?=$post->description?></div>
                </div>
            </div>
            <?php $i++; ?>
        <?php } ?>

        <ul class="pagination"><?=$pagenav?></ul>
    </div>
</main>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
