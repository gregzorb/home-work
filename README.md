TASK DESCRIPTION:

"Реализовать библиотку для быстрой генерации XML из масива. Входящие данные в формате:
array(
'tag_name' => array(
'@property_name' => 'property_value',
'inner_tag_name' => 'inner_text',
'@text' => 'outer_text',
)
)
Должны генерить xml:
<tag_name property_name=""property_value"">outer_text<inner_tag_name>inner_text</inner_tag_name></tag_name>"


USAGE:
$xmlClass = new GenerateXml();
$xml = $xmlClass->createXML('tag_name', array() ;
echo $xml->saveXML();