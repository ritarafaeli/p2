<?php

$data = array();
$words = array();

$_POST = json_decode(file_get_contents('php://input'), true);

//default dictionary that gets replaced with scraped words
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

//form inputs - default values (will be updated upon server side validation)
$num = 3;
$breakage = $BREAKAGE_HYPHENS;
$case = $CASE_DEFAULT;
$isNumber = false;
$isSpecialsymbol = false;

//update form inputs - form validation - if validation fails, default values will be used
if(!empty($_POST["num"]) && is_int($_POST["num"]) && $_POST["num"] > 3 && $_POST["num"] < 10 )
    $num = $_POST["num"];

if(!empty($_POST["breakage"]) && is_string($_POST["breakage"]))
    $breakage = $_POST['breakage'];

if(!empty($_POST["case"]) && is_string($_POST["case"]))
   $case = $_POST['case'];

if(!empty($_POST["number"]) && is_bool($_POST["number"]))
   $isNumber = $_POST["number"];

if(!empty($_POST["specialsymbol"]) && is_bool($_POST["specialsymbol"]==1))
   $isSpecialsymbol = $_POST["specialsymbol"];

if(!empty($_POST['words'])){
    $scrapedwords = $_POST['words'];
    $dictionary = $scrapedwords;
    $size = sizeof($dictionary);
}


//generate password
$answer = '';

$break = $breakage == $BREAKAGE_SPACES ? " " : "-";

$indexToAddNumber = $isNumber ? rand(1, $num) : -1; //if user wants to add a number, use random index
$indexToAddSymbol = $isSpecialsymbol ? rand(1, $num) : -1; //if user wants to add symbol, use random index

$symbolArray = array('!','@','#','$','%','^','&','*');

for($i=0 ; $i < $num ; $i++){ //iterate through number of words needed for password
    
    $rand = rand(1, $size); //choose a random index
    
    $word = ucfirst(strtolower($dictionary[$rand-1]));
    
    if($case == $CASE_UPPER){
        $word = strtoupper($word);
    }
    else if($case == $CASE_LOWER){
        $word = strtolower($word);
    }
   
    if($breakage == $BREAKAGE_CAMEL){
        $word = strtolower($word);
        if($i > 0)
            $word = ucfirst($word);
    }
    
    if($i==$indexToAddNumber-1)
        $answer .= rand(1,100);
    
    $answer .= $word;
    
    if($i==$indexToAddSymbol-1)
        $answer .= $symbolArray[rand(1,sizeof($symbolArray))-1]; //choose a random symbol from symbolArray
    
    if($i != $num - 1 && $breakage != $BREAKAGE_CAMEL)
        $answer .= $break;
    
}

//return answer back to AngularJS
echo $answer;

?>
