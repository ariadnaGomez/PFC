<?php

//define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
//include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
//
//$char = strtoupper($_GET['char']);
//
//// Filename of an RDF document
//$base="/var/www/PFC/data/".$char.".rdf";
//
//// Create a new MemModel
//$model = ModelFactory::getDefaultModel();
//
//// Load and parse document
//$model->load($base);
//
//$rdql_query = '
//PREFIX yago: <http://dbpedia.org/class/yago/>
//SELECT ?name
//WHERE {?person yago:hasName ?name}
//ORDER BY ?name
//';
//
//// query the model
//$res = $model->sparqlQuery($rdql_query);

include_once('../class/AuthorsProccesor.php');


$memcache = new Memcache;
if ($memcache->connect('localhost', 11211) && 
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
    if ($memcache->connect('localhost', 11211)) {
        $memcache->set('authors' . $_GET['char'], $cache, false);
    }
}
$a = json_encode($result);

echo $a;
?>
