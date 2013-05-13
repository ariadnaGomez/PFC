<?php

include_once '../class/Searcher.php';
include_once '../class/DBPediaSearcher.php';
include_once '../class/BNESearcher.php';
include_once '../class/BNBSearcher.php';
include_once('../class/AuthorsProccesor.php');
$memcache = new Memcache;
$initial = strtolower($_GET['authorName'][0]);
if ($memcache->connect('localhost', 11211) &&
        $res = $memcache->get('authors' . $initial)) {
    $authors = unserialize($res);
    $authorID = $authors[$_GET['authorName']];
    if (!$authorID){
        $proccesor = new AuthorsProccesor($_GET['authorName'][0]);
    $author = $proccesor->getAuthorID($_GET['authorName']);
    $authorID = $author[0]['?person']->getLabel();
    }
} else {
    $proccesor = new AuthorsProccesor($_GET['authorName'][0]);
    $author = $proccesor->getAuthorID($_GET['authorName']);
    $authorID = $author[0]['?person']->getLabel();
}
$dbsearcher = new DBPediaSearcher();
$data = $dbsearcher->searchAuthorInfo($authorID);
$bneSearcher = new BNESearcher();
$books = $bneSearcher->search($authorID);
$bnbSearcher = new BNBSearcher();
$ids = $bneSearcher->searchViafID($authorID);
foreach ($ids as $key => $id){
    $label = $id['?sameAs']->getLabel();
    $pos = strpos($label, 'viaf');
    if ($pos !== false) {
        $viafID = $label;
        break;
    }
}
$influences = $bnbSearcher->search($viafID);
$result['data'] = $data[0];
$result['books'] = $books;
$result['influences'] = $influences;
$x = json_encode($result);
echo $x;
?>
