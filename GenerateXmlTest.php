<?php

/**
 * Description of GenerateXmlTest
 *
 * @author gdp
 */
require_once 'source.php';
require_once 'GenerateXml.php';

class GenerateXmlTest extends PHPUnit_Framework_TestCase {

    protected $source;
    protected $xmlClass;
    
    protected function setUp() {
        include 'source.php';
        $this->source = $source;
        $this->xmlClass = new GenerateXml();
    }

    public function testSourceArray() {
        $this->assertTrue(!empty($this->source));
    }

    public function testGetXMLRoot() {
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>',  $this->xmlClass->createXML() );
    }

    //test header
    //test main element
    //test 
    //test inner element
}
