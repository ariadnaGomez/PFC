<?php

include_once '../class/Searcher.php';
include_once '../class/BNESearcher.php';
$searcher = new BNESearcher();
$queryParams = $searcher->calculateQueryParams($_GET);
switch ($queryParams->searchBy) {
    case 'author' :
        $result = $searcher->search($queryParams->input, $queryParams->offset);           
        break;
    case 'title' :

        $result = $searcher->search($queryParams->input, $queryParams->offset, FALSE);             
        break;
}
$data = $searcher->getNextOffset($result, $queryParams);
$data['data'] = $searcher->filterAuthors($result);
echo json_encode($data);

//$a = $_SERVER['DOCUMENT_ROOT'] . "/PFC/lib/rdfapi-php/api/" . "RdfAPI.php";
//define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
//include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
//
//
//    $bneClient = ModelFactory::getSparqlClient("http://datos.bne.es/sparql");
//
//$query = new ClientQuery();
//
//
//
//$query->query($queryString);
//$result = $bneClient->query($query);
//$queryString = 'select distinct ?titulo ?Obras ?nombre ?Autor where {
//
//?Autor <http://iflastandards.info/ns/fr/frbr/frbrer/P2010> ?Obras.
//?Autor <http://iflastandards.info/ns/fr/frbr/frbrer/P3039> ?nombre.
//?Obras <http://iflastandards.info/ns/fr/frbr/frbrer/P3001> ?titulo.
//FILTER (regex(?titulo, "'.$_GET['input'].'", "i")).
//}
//LIMIT 100
//';
//$data = filterAuthors($result);
//echo json_encode($data);
//$memcache = new Memcache;
//$memcache->connect('localhost', 11211) or die ("Could not connect");
//
//$memcache->set('lastSearch', $data, false, 10) or die ("Failed to save data at the server");



//function sparqlQuery($url, $query){
//    
//}
?>
