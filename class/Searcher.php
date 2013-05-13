<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Searcher
 *
 * @author Ariadna Gómez <ari.grr@gmail.com>
 */
abstract class Searcher {

    protected $_sparqlEndpoint;

    const QUERY_LIMIT = 100;

    protected function __construct($endpoint) {
        $this->_sparqlEndpoint = $endpoint;
    }

    protected function _query($queryString) {
        define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
        include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");

        $bneClient = ModelFactory::getSparqlClient($this->_sparqlEndpoint);
        $query = new ClientQuery();
        $query->query($queryString);
        return $bneClient->queryBNB($query);
    }

    public function saveResult($result , $key) {
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) or die("Could not connect");
        $memcache->set($key, $result, false) or die("Failed to save data at the server");
    }
    
    public function getResult($key){
        $memcache = new Memcache;
        $memcache->connect('localhost', 11211) or die("Could not connect");
        return $memcache->get($key);
    }
    

}

?>
