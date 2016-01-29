<?php

$data = array();
$words = array();

$_POST = json_decode(file_get_contents('php://input'), true);


$PAGES_TO_SCRAPE = 15;
$scrapeurlbegin = 'www.paulnoll.com/Books/Clear-English/words-'; //'http://www.paulnoll.com/Books/Clear-English/words-01-02-hundred.html'
$scrapeurlend = '-hundred.html';     

for($i=0 ; $i < $PAGES_TO_SCRAPE ; $i++){
    //create url
    $val1 = 2*$i+1;
    $val2 = $val1 + 1;
    $url = $scrapeurlbegin . strval(sprintf("%02s", $val1)) . '-' . strval(sprintf("%02s", $val2)) . $scrapeurlend;

    //use curl to request html from url
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPGET, 1);
    curl_setopt($ch, CURLOPT_URL, $url );
    curl_setopt($ch, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 2 );      

    $html = curl_exec($ch);
    $dom = new DOMDocument();
    @$dom->loadHTML($html);


    $lis = $dom->getElementsByTagName('li');

    foreach ($lis as $li){
        $words[] = trim($li->nodeValue);
    }
}
        
//var_dump(array_values($words));

//return answer back to AngularJS
echo json_encode($words);
?>
