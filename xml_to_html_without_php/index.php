<?php

//Конфигурация
$num = 20; //Постов на странице
//Конфигурация

error_reporting(E_ALL);
ini_set("display_errors", 1);
header('Content-Type: text/html; charset=utf-8');

if (is_dir("result/pages")) {
    array_map('unlink', glob("result/pages/*.*"));
    rmdir("result/pages");
}
mkdir("result/pages");

$xml = simplexml_load_file("feed.xml") or die("Error: Cannot create object");
$posts_all = xml2array($xml);
$posts_all_chunk = array_chunk($posts_all['channel']['item'], $num);

$count = count($posts_all['channel']['item']);

$page2 = 0;

foreach ($posts_all_chunk as $chunk) {
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
        if ($page2 != 1) $pervpage = '<li class="page-item"><a class="page-link" href="./page_1.html"><<</a></li>
            <li class="page-item"><a class="page-link" href="./page_' . ($page2 - 1) . '.html"><</a></li>';
        if ($page2 != $total) $nextpage = '<li class="page-item"><a class="page-link" href="./page_' . ($page2 + 1) . '.html">></a></li>
            <li class="page-item"><a class="page-link" href="./page_' . $total . '.html">>></a></li>';
        if($page2 - 1 > 0) $page1left = '<li class="page-item"><a class="page-link" href="./page_' . ($page2 - 1) . '.html">' . ($page2 - 1) . '</a></li>';
        if($page2 + 1 <= $total) $page1right = '<li class="page-item"><a class="page-link" href="./page_' . ($page2 + 1) . '.html">' . ($page2 + 1) . '</a></li>';
        if($posts) $activepage = '<li class="page-item active"><a class="page-link" href="#">' . $page2 . '</a></li>';
        $pagenav = $pervpage . $page1left . $activepage . $page1right . $nextpage;
    }

    ob_start();
    require "template.php";
    $content = ob_get_clean();
    file_put_contents(dirname(__FILE__) . "/result/pages/page_" . $page2 . ".html", $content);
    $page2++;
}

function xml2array ( $xmlObject, $out = array () )
{
    foreach ( (array) $xmlObject as $index => $node )
        $out[$index] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node;

    return $out;
}
?>

