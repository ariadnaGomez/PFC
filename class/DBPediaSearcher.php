<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Class to query sparql
 *
 * @author Ariadna Gómez <ari.grr@gmail.com>
 */
class DBPediaSearcher extends Searcher {

    /**
     * SPARQL endpoint
     */
    const DBPEDIA_ENDPOINT = 'http://dbpedia.org/sparql';
    
    /**
     * YAGO prefix
     */
    const YAGO = 'http://dbpedia.org/class/yago/';
    
    /**
     * RDF subclass of prefix
     */
    const SUBCLASSOF = 'http://www.w3.org/2000/01/rdf-schema#suBClassOf';
    
    /**
     * DBPedia owl-writer prefix
     */
    const OWLWRITER = 'dbpedia-owl:Writer';
    
    /**
     * Yago writer prefix
     */
    const YAGOWRITER = 'yago:Writer110794014 ';
    
    
    public function __construct() {
        parent::__construct(DBPediaSearcher::DBPEDIA_ENDPOINT);
    }

    public function searchWriter($authorName, $type = DBPediaSearcher::WRITER) {
        $name = $this->_bneNameToDbpedia($authorName);
        if ($type == DBPediaSearcher::WRITER) {
            $queryString = $this->_createQueryWriterType($name);
        } else {
            $queryString = $this->_createQueryWriterSubClass($name);
        }
        $result = $this->_query($queryString);
        return ($result);
    }
    

    public function searchAuthorInfo($authorID, $completeInfo = TRUE) {
        $queryString = ($completeInfo) ?
             $this->_createQueryAuthorInfo($authorID) :
             $this->_createQueryAuthorName($authorID);
        return $this->_query($queryString);
    }
    
    public function constructAllAuthors(){
        $queryString = $this->_createQueryAllAuthors();
        return $this->_query($queryString);
    }
    
    private function _createQueryAllAuthors(){
       $queryString = 'PREFIX yago: <http://dbpedia.org/class/yago/>

                        CONSTRUCT {?person yago:hasName  ?name.
                        ?person yago:hasId ?viaf }
WHERE
{
        ?person a ?type .
        ?type <http://www.w3.org/2000/01/rdf-schema#suBClassOf> yago:Writer110794014 OPTION (TRANSITIVE) .
  
?person foaf:name ?name .
OPTIONAL {?person dbpprop:viaf ?viaf.}
}';
        return $queryString;
    
    }
    private function _createQueryWriterType($names) {
        foreach ($names as $name) {
            $filterQuery .= 'FILTER(regex(?name, "' . $name . '", "i")) ';
        }

        $queryString = '
            SELECT DISTINCT ?person WHERE 
            {
                ?person a ' . DBPediaSearcher::OWLWRITER . ' .
                ?person foaf:name ?name .
                ' . $filterQuery . '
            }';
        return $queryString;
    }

    private function _createQueryWriterSubClass($names) {
        foreach ($names as $name) {
            $filterQuery .= 'FILTER(regex(?name, "' . $name . '", "i")) ';
        }
        $queryString = 'PREFIX yago: <' . DBPediaSearcher::YAGO . '> SELECT DISTINCT ?person WHERE { ?person a ?type. ?type <' . DBPediaSearcher::SUBCLASSOF . '> ' . DBPediaSearcher::YAGOWRITER . ' OPTION (TRANSITIVE) . ?person foaf:name ?name . ' . $filterQuery . ' }';
        return $queryString;
    }
    
    private function _createQueryAuthorName($author) {
        $queryString = '
            SELECT DISTINCT ?name WHERE 
            {
               <' . $author . '> foaf:name ?name .
             }';
        return $queryString;
    }
    
    private function _createQueryAuthorInfo($author) {
        $queryString = '
            SELECT DISTINCT * WHERE 
            {
               <' . $author . '> foaf:name ?name .
                OPTIONAL { <' . $author . '> dbpedia-owl:abstract ?abstract. 
                            FILTER(langMatches(lang(?abstract), "EN"))}
                OPTIONAL { <' . $author . '> dbpprop:birthPlace ?birthPlace.
                            FILTER(langMatches(lang(?birthPlace), "EN"))}
                OPTIONAL { <' . $author . '> dbpprop:deathPlace ?deathPlace.
                            FILTER(langMatches(lang(?deathPlace), "EN"))}
                OPTIONAL { <' . $author . '> foaf:depiction ?photo.}
                OPTIONAL { <' . $author . '> dbpedia-owl:deathDate ?deathDate.}
                OPTIONAL { <' . $author . '> dbpedia-owl:birthDate ?birthDate.} 
            }';
        return $queryString;
    }

    private function _bneNameToDbpedia($name) {
        $surname = split(',', $name);
        $surname[1] = substr($surname[1], 1);
        $arraySurname = split(' ', $surname[0]);
        $arrayName = split(' ', $surname[1]);
        $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,u");
        $replace = explode(",", ".,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.,.");
        $final[0] = str_replace($search, $replace, $arrayName[0]);
        $final[1] = str_replace($search, $replace, $arraySurname[0]);
        return $final;
    }

}

?>
