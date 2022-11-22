<?php

include_once '../simple_html_dom.php';

$url = 'https://puzzle.mead.io/puzzle?wordCount=1'; 
$html = file_get_html($url); 
$word = strtoupper(explode("\"",$html)[3]);

echo $word;
?>