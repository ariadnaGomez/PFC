<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BNESearcher
 *
 * @author Ariadna Gómez <ari.grr@gmail.com>
 */
class BNESearcher extends Searcher {

    const BNE_ENDPOINT = 'http://datos.bne.es/sparql';
    const METADATA_URL = 'http://iflastandards.info/ns/fr/frbr/frbrer/';
    const OWL_SAMEAS = 'http://www.w3.org/2002/07/owl#sameAs';
    const AUTHOR_FILTER = '?authorName';
    const TITLE_FILTER = '?title';

    protected $_isCreatorPersonOf;
    protected $_hasNameOfPerson;
    protected $_hasTitleOfWork;
    protected $_lastResult;

    public function __construct() {
        parent::__construct(BNESearcher::BNE_ENDPOINT);
        $this->_isCreatorPersonOf = BNESearcher::METADATA_URL . 'P2010';
        $this->_hasNameOfPerson = BNESearcher::METADATA_URL . 'P3039';
        $this->_hasTitleOfWork = BNESearcher::METADATA_URL . 'P3001';
    }

    public function search($authorName) {
        $queryString = $this->_createQueryString($authorName);
        return $this->_query($queryString);
    }

    public function searchViafID($authorID) {
        $queryString = $this->_getViafQuery($authorID);
        return $this->_query($queryString);
    }
    
    public function filterAuthors($data) {
        foreach ($data as $key => $author) {
            if (!strstr($author['?authorName']->getLabel(), ',')) {
                unset($data[$key]);
            }
        }
        return array_values($data);
    }

    public function calculateQueryParams($iniData) {
        $result = new stdClass();
        if ($iniData['offset'] == 'first') {
            $result->offset = 0;
            $result->searchBy = $iniData['searchBy'];
            $result->input = $iniData['input'];
        } else {
            $result->searchBy = $this->getResult('searchBy');
            $result->input = $this->getResult('input');
            if ($iniData['offset'] == 'next') {
                $result->offset = $this->getResult('offset');
            } else if ($iniData['offset'] == 'prev') {
                $lastOffset = $this->getResult('offset');
                if ($lastOffset < BNESearcher::QUERY_LIMIT * 2) {
                    $result->offset = 0;
                } else {
                    $result->offset = $this->getResult('offset') - BNESearcher::QUERY_LIMIT * 2;
                }
            }
        }
        return $result;
    }

    public function saveQueryData($offset, $filter, $searchedData) {
        $this->saveResult($offset, 'offset');
        $this->saveResult($filter, 'searchBy');
        $this->saveResult($searchedData, 'input');
    }

    public function getNextOffset($result, $queryParams) {
        $nextOffset = count($result) + $queryParams->offset;
        $this->saveQueryData($nextOffset, $queryParams->searchBy, $queryParams->input);
        // If there are more pages enable next button
        if (count($result) % 100 == 0 && count($result) > 0) {
            $data['nextButton'] = TRUE;
        } else {
            $data['nextButton'] = FALSE;
        }
        // If it's the first page disable previous button
        if ($queryParams->offset == 0) {
            $data['prevButton'] = FALSE;
        } else {
            $data['prevButton'] = TRUE;
        }
        return $data;
    }

    ////////////////////////////////////////////////////////////////
    //
    //  PRIVATE FUNCTIONS
    //  
    ///////////////////////////////////////////////////////////////

    private function _createQueryString($authorID) {
        $queryString = '
            SELECT DISTINCT ?title ?sameAs
            WHERE 
            {
                ?author <'.BNESearcher::OWL_SAMEAS.'>  <'.$authorID.'> .
                ?author <'.$this->_isCreatorPersonOf.'> ?book.
                ?book <'.$this->_hasTitleOfWork.'> ?title. 
                ?author <'.BNESearcher::OWL_SAMEAS.'> ?sameAs.
                FILTER(regex(?sameAs, "viaf","i"))
            }';
        return $queryString;
    }

    private function _getViafQuery($authorID) {
        $queryString = '
            SELECT DISTINCT ?sameAs
            WHERE 
            {
                <'.$authorID.'> <'.BNESearcher::OWL_SAMEAS.'>  ?sameAs . 
            }';
        return $queryString;
    }

}

?>
