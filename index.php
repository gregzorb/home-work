<?php
require_once 'source.php';
require_once 'GenerateXml.php';
$xmlClass = new GenerateXml();
$xml = $xmlClass->createXML('tag_name', $source);
echo $xml->saveXML();
?>