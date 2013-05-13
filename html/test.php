<?php

$response = file_get_contents('http://bnb.data.bl.uk/sparql?query=PREFIX+blt%3A+%3Chttp%3A%2F%2Fwww.bl.uk%2Fschemas%2Fbibliographic%2Fblterms%23%3E%0A++++++++PREFIX+dct%3A+%3Chttp%3A%2F%2Fpurl.org%2Fdc%2Fterms%2F%3E+%0A++++++++PREFIX+owl%3A+%3Chttp%3A%2F%2Fwww.w3.org%2F2002%2F07%2Fowl%23%3E+%0A%0A++++++++++++SELECT+distinct+%3Ftitle+WHERE+{%0A++++++++++++++++%3Fauthor+owl%3AsameAs+%3Chttp%3A%2F%2Fviaf.org%2Fviaf%2F95218067%3E.%0A++++++++++++++++%3Fauthor+blt%3AhasContributedTo+%3Fbook.%0A++++++++++++++++%3Fbook+dct%3Atitle+%3Ftitle.%0A++++++++}');
var_dump($response);die();



//$queryString = 'CONSTRUCT  {?person yago:hasName ?name} WHERE {
//   
//
//#{
//?person a ?type .
//        ?type <http://www.w3.org/2000/01/rdf-schema#subClassOf> yago:Writer110794014.
//    
//
//
//#} UNION {
//    
//#        ?person a dbpedia-owl:Writer
//#} UNION {
//#?person a yago:Writer110794014
//
//#}
//
//
//?person foaf:name ?name.
//}';

//$queryString ='SELECT DISTINCT count(?person) WHERE {
//    
//{
//?person a ?type .
//        ?type <http://www.w3.org/2000/01/rdf-schema#subClassOf> yago:Writer110794014.
//    
//
//
//} UNION {
//    
//        ?person a dbpedia-owl:Writer
//} UNION {
//?person a yago:Writer110794014
//
//}
//}';
//http
// display Hello World
//echo (String) $myObj->getHelloWorld();

// var_dump()

//require_once("/var/lib/tomcat7/webapps/JavaBridgeTemplate621/java/Java.inc");

//$session = java_session();
//java_autoload();
//$System = java("java.lang.System");
//echo $System->getProperties();

//include_once '../class/Searcher.php';
//include_once '../class/DBPediaSearcher.php';
//$serach = new DBPediaSearcher();
//$a = $serach->constructAllAuthors();
//var_dump($a);die();
//$a = $_SERVER['DOCUMENT_ROOT'] . "/PFC/lib/rdfapi-php/api/" . "RdfAPI.php";
//
define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
//$x = new MemModel();
//$docu = $_SERVER['DOCUMENT_ROOT'] . "/PFC/data/sparql.n3";
//$x->load($docu);
//$x ->writeAsHtmlTable();
//$title = "Trípode G5";
//$search = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,u");
//$replace = explode(",",".,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.");
//$urlTitle = str_replace($search, $replace, $title);


//$name = 'Cervantes Saavedra, Miguel de';
//$surname = split(',', $name);
//$surname[1] = substr($surname[1],1);
//$arraySurname = split(' ',$surname[0]);
//$arrayName = split(' ',$surname[1]);
//$final[0]=$arrayName[0];
//$final[1]= $arraySurname[0];
//var_dump($final);
//ini_set('memory_limit', '-1');
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//
//echo 'bbbb';
//
//$a = $_SERVER['DOCUMENT_ROOT'] . "/PFC/lib/rdfapi-php/api/" . "RdfAPI.php";
//
//define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
//include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");
//
//
//
//// Filename of an RDF document
//$base="/var/www/PFC/data/G.rdf";
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
//try{
//// query the model
//$res = $model->sparqlQuery($rdql_query);
//$result = array();
//foreach($res as $key => $author){
//    $result[$key]=$author['?name']->getLabel();
//}
//var_dump($result);
//} catch (Exception $e){
//    var_dump($e);
//}
// Output model as HTML table
//$model->writeAsHtmlTable();

$bnbClient = ModelFactory::getSparqlClient("http://bnb.data.bl.uk/sparql");
$bneClient = ModelFactory::getSparqlClient("http://datos.bne.es/sparql");

$query = new ClientQuery();
$queryString = '# Select an author based on the ISBN of one of their books.
PREFIX bio: <http://purl.org/vocab/bio/0.1/> 
PREFIX bibo: <http://purl.org/ontology/bibo/> 
PREFIX blterms: <http://www.bl.uk/schemas/bibliographic/blterms#> 
PREFIX dct: <http://purl.org/dc/terms/> 
PREFIX event: <http://purl.org/NET/c4dm/event.owl#> 
PREFIX foaf: <http://xmlns.com/foaf/0.1/> 
PREFIX geo: <http://www.w3.org/2003/01/geo/wgs84_pos#> 
PREFIX isbd: <http://iflastandards.info/ns/isbd/elements/> 
PREFIX org: <http://www.w3.org/ns/org#> 
PREFIX owl: <http://www.w3.org/2002/07/owl#> 
PREFIX rda: <http://RDVocab.info/ElementsGr2/> 
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#> 
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#> 
PREFIX skos: <http://www.w3.org/2004/02/skos/core#> 
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#> 

SELECT ?author WHERE {
  #Match the book
  ?uri bibo:isbn10 "0261102214";
       #Match its author
	   dct:creator ?author.
}
';

$query->query($queryString);
 $result = $bnbClient->query($query);
 var_dump($result);
//$memcache = new Memcache;
//$memcache->connect('localhost', 11211) or die ("Could not connect");
//
//$version = $memcache->getVersion();
//echo "Server's version: ".$version."<br/>\n";
//
//$tmp_object = new stdClass;
//$tmp_object->str_attr = 'test';
//$tmp_object->int_attr = 123;
//
//$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
//echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";
//
//$get_result = $memcache->get('key');
//echo "Data from the cache:<br/>\n";
//
//var_dump($get_result);

?>
