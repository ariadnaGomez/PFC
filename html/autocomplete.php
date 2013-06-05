<?php

include_once('../class/AuthorsProccesor.php');


$memcache = new Memcache;
$conf = parse_ini_file ("../config");
if ($memcache->connect($conf['memcache_host'], (int)$conf['memcache_port']) && 
        $res = $memcache->get('authors' . $_GET['char'])) {   
        $authors = unserialize($res);
        $key = 0;
        foreach ($authors as $authorName => $authorID) {
            $result[$key] = $authorName;
            $key++;
        } 
} else {
    $proccesor = new AuthorsProccesor($_GET['char']);
    $res = $proccesor->getAllAuthors();
    $result = array();
    $cacheArray = array();
    foreach ($res as $key => $author) {
        $result[$key] = $author['?name']->getLabel();
        $cacheArray[$author['?name']->getLabel()] = $author['?person']->getLabel();
    }
    $cache = serialize($cacheArray);
    if ($memcache->connect($conf['memcache_host'], (int)$conf['memcache_port'])) {
        $memcache->set('authors' . $_GET['char'], $cache, false);
    }
}
$a = json_encode($result);

echo $a;
?>
