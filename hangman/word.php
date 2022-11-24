<?php

include_once '../simple_html_dom.php';

$url = 'https://puzzle.mead.io/puzzle?wordCount=1'; 
$html = file_get_html($url); 
$word = strtoupper(explode("\"",$html)[3]);

$client_id = "Of3d2tHbTL8XWlRKxioE";
    $client_secret = "U9zG0UipYw";
    $encText = urlencode($word);
    $postvars = "source=en&target=ko&text=".$encText;
    $url = "https://openapi.naver.com/v1/papago/n2mt";
    $is_post = true;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, $is_post);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $postvars);
    $headers = array();
    $headers[] = "X-Naver-Client-Id: ".$client_id;
    $headers[] = "X-Naver-Client-Secret: ".$client_secret;
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec ($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close ($ch);
    if($status_code == 200) {
        $resArr = json_decode($response, true);
        $translatedText = $resArr['message']['result']['translatedText'];
    } else {
        echo "Error 내용:".$response;
    }

    $arrayData = array('word'=>trim($word) ,'translate'=>trim($translatedText));
    echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
?>