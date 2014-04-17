<?php

/**
 * Description of generateXml
 *
 * @author gregzorb
 */
class GenerateXml {

    private $xml = null;
    private $version = '1.0';
    private $encoding = 'UTF-8';

    /**
     * Initialize the root XML node
     */
    public function init() {
        $this->xml = new DomDocument($this->version, $this->encoding);
    }

    public function &createXML($tag_name = '', $source = array()) {
        $xml = $this->getXMLRoot();
        if ( strlen($tag_name) > 0){
            $xml->appendChild($this->convert($tag_name, $source));
        }
        $this->xml = null;
        return $xml;
    }

    private function &convert($tag_name, $sources = array()) {
        $xml = $this->getXMLRoot();
        $node = $xml->createElement($tag_name);
        if (!empty($sources) ) {
            if (is_array($sources[$tag_name])) {
                $source = $sources[$tag_name];
                // attributes
                if (isset($source['@property_name'])) {
                    foreach ($source['@property_name'] as $key => $value) {
                        if (!$this->isValidTagName($key)) {
                            throw new Exception('[GenerateXml] Illegal character in attribute name. attribute: ' . $key . ' in node: ' . $tag_name);
                        }
                        $node->setAttribute($key, $value);
                    }
                    unset($sources[$tag_name]['@property_name']);
                }

                //Set inner text 
                if (isset($source['@text'])) {
                    $node->appendChild($xml->createTextNode($source['@text']));
                    unset($sources[$tag_name]['@text']);
                }

            }
        }
        if (!empty($sources) ) {
            if (is_array($sources[$tag_name])) {
                $source = $sources[$tag_name];
                foreach ( $source as $key => $value){
                        if (!$this->isValidTagName($key)) {
                            throw new Exception('[GenerateXml] Illegal character in attribute name. attribute: ' . $key . ' in node: ' . $tag_name);
                        }
                        $node->appendChild($this->convert($key,  array ($key => array('@text'=> $value) ) ));
                unset($sources[$tag_name][$key]);
                }
            }
        }

        return $node;
    }

    private function getXMLRoot() {
        if (empty($this->xml)) {
            $this->init();
        }
        return $this->xml;
    }

    /*
     * I like PERL. Don't be afraid regular expressions
     * Standarts of XML
     * http://www.w3.org/TR/xml/#sec-common-syn
     */

    public function isValidTagName($tag) {
        $pattern = '/^[a-z_]+[a-z0-9\:\-\.\_]*[^:]*$/i';
        return preg_match($pattern, $tag, $matches) && $matches[0] == $tag;
    }

}
