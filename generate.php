<?php

$data = array();
$words = array();

$_POST = json_decode(file_get_contents('php://input'), true);


function scrape(){
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
        //var_dump(curl_exec($ch));
        //var_dump(curl_getinfo($ch));
        //var_dump(curl_error($ch));
        //$html = '<html><ul><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li><li>test</li></ul></html>';
        //load dom, pull out all words in <li></li> tags
        
        
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        
        
        $lis = $dom->getElementsByTagName('li');

        foreach ($lis as $li){
            echo trim($li->nodeValue).",";
            $words[] = $li->nodeValue;
        }
        echo "\n";    
    } 
        
    
    var_dump(array_values($words));
        
}

scrape();

//dictionary - TODO: replace with scraper
$str = "On the other hand we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment so blinded by desire that they cannot foresee the pain and trouble that are bound to ensue and equal blame belongs to those who fail in their duty through weakness of will which is the same as saying through shrinking from toil and pain These cases are perfectly simple and easy to distinguish In a free hour when our power of choice is untrammelled and when nothing prevents our being able to do what we like best every pleasure is to be welcomed and every pain avoided But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures or else he endures pains to avoid worse pains";
$dictionary = explode(" ",$str);
$size = sizeof($dictionary);

//static variables
$BREAKAGE_SPACES = 'spaces';
$BREAKAGE_HYPHENS = 'hyphens';
$BREAKAGE_CAMEL = 'camelcase';
$CASE_UPPER = 'upper';
$CASE_LOWER = 'lower';
$CASE_DEFAULT = 'default';

//form input defaults
$num = 3;
$breakage = $BREAKAGE_HYPHENS;
$case = $CASE_DEFAULT;
$number = false;
$specialsymbol = false;

//set inputs
if(!empty($_POST["num"]))
    $num = $_POST["num"];

if(!empty($_POST["breakage"]))
    $breakage = $_POST['breakage'];

if(!empty($_POST["case"]))
   $case = $_POST['case'];

if(!empty($_POST["number"]) && $_POST["number"]==1)
   $number = true;

if(!empty($_POST["specialsymbol"]) && $_POST["specialsymbol"]==1)
   $specialsymbol = true;


//generate password
$answer = '';

$break = $breakage == $BREAKAGE_SPACES ? " " : "-";
for($i=0 ; $i < $num ; $i++){
    $rand = rand(1, $size);
    $word = ucfirst(strtolower($dictionary[$rand-1]));
    if($case == $CASE_UPPER){
        $word = strtoupper($word);
    }else if($case == $CASE_LOWER){
        $word = strtolower($word);
    }
   
    if($breakage == $BREAKAGE_CAMEL){
        $word = strtolower($word);
        if($i > 0)
            $word = ucfirst($word);
    }
    if($i==0 && $number)
        $answer .= rand(1,100);
    $answer .= $word;    
    
    if($i != $num - 1 && $breakage != $BREAKAGE_CAMEL)
        $answer .= $break;
    
}
if($specialsymbol)
    $answer .= '@';

//return answer back to AngularJS
echo $answer;

?>
