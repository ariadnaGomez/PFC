<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AuthorsProccesor
 *
 * @author Ariadna Gómez <ari.grr@gmail.com>
 */
class AuthorsProccesor {

    const PREFIX_YAGO = 'http://dbpedia.org/class/yago/';

    protected $_model;

    public function __construct($initial) {
        define("RDFAPI_INCLUDE_DIR", '../lib/rdfapi-php/api/');
        include_once(RDFAPI_INCLUDE_DIR . "RdfAPI.php");

        $char = strtoupper($initial);

        // Filename of the RDF document
        $base = "/var/www/PFC/data/" . $char . ".rdf";

        // Create a new MemModel
        $this->_model = ModelFactory::getDefaultModel();

        // Load and parse document
        $this->_model->load($base);
    }

    public function getAllAuthors() {
        $query = '
            PREFIX yago: <' . AuthorsProccesor::PREFIX_YAGO . '>
            SELECT ?name ?person
            WHERE {?person yago:hasName ?name}
            ORDER BY ?name
            ';
        $result = $this->_model->sparqlQuery($query);
        return $result;
    }
    
        public function getAuthorID($authorName) {
        $query = '
            PREFIX yago: <' . AuthorsProccesor::PREFIX_YAGO . '>
            SELECT ?person
            WHERE {
            ?person yago:hasName ?name.
            FILTER(regex(?name, "' . $authorName . '", "i"))
        }';
        $result = $this->_model->sparqlQuery($query);
        return $result;
    }

}

?>
