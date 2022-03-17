<?php 
$xml = Xml::fromArray(array('response' => $produtos));
echo $xml->asXML();
?>