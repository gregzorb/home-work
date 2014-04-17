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
        $this->tag_name = 'tag_name';
        $this->xmlClass = new GenerateXml();
    }

    public function testSourceArray() {
        $this->assertTrue(!empty($this->source));
    }

    public function testgetXMLRoot() {
        $xmlObject = $this->xmlClass->createXML('');
        $this->assertEquals('<?xml version="1.0" encoding="UTF-8"?>' . "\n", $xmlObject->saveXML());
    }

    public function testIsValidTagName() {
        $this->assertTrue($this->xmlClass->isValidTagName($this->tag_name));
    }

    public function testNodeAttributes() {
        $expected = new DOMDocument;
        $expected->loadXML('<tag_name property_name="property_value">outer_text<inner_tag_name>inner_text</inner_tag_name></tag_name>');

        $actual = $this->xmlClass->createXML($this->tag_name, $this->source);

        $this->assertEqualXMLStructure(
                $expected->firstChild, $actual->firstChild, TRUE
        );
    }

    public function testChildString() {
        $xmlObject = $this->xmlClass->createXML($this->tag_name, $this->source);
        $this->assertContains('<inner_tag_name>inner_text</inner_tag_name>', $xmlObject->saveXML());
    }

    public function testChildCount() {
        $expected = new DOMDocument;
        $expected->loadXML('<tag_name><inner_tag_name></inner_tag_name></tag_name>');

        $actual = $this->xmlClass->createXML($this->tag_name, $this->source);

        $this->assertEqualXMLStructure(
                $expected->firstChild, $actual->firstChild
        );
    }

    //Test string output
    public function testStringResult() {
        $result = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<tag_name property_name="property_value">outer_text<inner_tag_name>inner_text</inner_tag_name></tag_name>' . "\n";
        $xmlObject = $this->xmlClass->createXML($this->tag_name, $this->source);
        $this->assertEquals($result, $xmlObject->saveXML());
    }

    //Compare temp XML file and test.xmls with results
    public function testXmlFile() {
        $xmlObject = $this->xmlClass->createXML($this->tag_name, $this->source);
        $xmlObject->formatOutput = true;
        echo $xmlObject->save("tmp/actual.xml");
        $this->assertXmlFileEqualsXmlFile('test.xml', 'tmp/actual.xml');
    }

}
