<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BNBSearcher
 *
 * @author Ariadna Gómez <ari.grr@gmail.com>
 */
class BNBSearcher extends Searcher{

    const BNB_ENDPOINT = 'http://bnb.data.bl.uk/sparql';

    public function __construct() {
        parent::__construct(BNBSearcher::BNB_ENDPOINT);
    }
    
    public function search($viafID){
        $queryString = $this->_createQuery($viafID);
        return $this->_query($queryString);
    }
    
    private function _createQuery($viafID) {
        $queryString = 
        'PREFIX blt: <http://www.bl.uk/schemas/bibliographic/blterms#>
        PREFIX dct: <http://purl.org/dc/terms/> 
        PREFIX owl: <http://www.w3.org/2002/07/owl#>
        PREFIX foaf: <http://xmlns.com/foaf/0.1/>

            SELECT distinct ?title ?name WHERE {
                ?author owl:sameAs <'.$viafID.'>.
                ?author blt:hasContributedTo ?book.
                ?book dct:title ?title.
                ?book dct:creator ?au.
                ?au foaf:name ?name.
        }';
        return $queryString;
    }

}

?>
