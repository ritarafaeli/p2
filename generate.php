<?php

$data = array();


$_POST = json_decode(file_get_contents('php://input'), true);
//$data = file_get_contents("php://input");
//$request = json_decode($data, TRUE);
//print_r($request);

foreach ($_POST as $param_name => $param_val) {
    echo " $param_name = $param_val<br />\n";
}

//dictionary
$str = "On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so blinded by desire, that they cannot foresee the pain and trouble that are bound to ensue; and equal blame belongs to those who fail in their duty through weakness of will, which is the same as saying through shrinking from toil and pain. These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. But in certain circumstances and owing to the claims of duty or the obligations of business it will frequently occur that pleasures have to be repudiated and annoyances accepted. The wise man therefore always holds in these matters to this principle of selection: he rejects pleasures to secure other greater pleasures, or else he endures pains to avoid worse pains";
$dictionary = explode(" ",$str);
$size = sizeof($dictionary);

//static variables
$BREAKAGE_SPACES = 'spaces';
$BREAKAGE_HYPHENS = 'hyphens';
$BREAKAGE_CAMEL = 'camelcase';
$CASE_UPPER = 'upper';
$CASE_LOWER = 'lower';
$CASE_DEFAULT = 'default';

//form inputs
$num = 3;
$breakage = $BREAKAGE_HYPHENS;
$case = $CASE_DEFAULT;
$number = false;
$specialsymbol = false;


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


//TODO:calculate password

$answer = '';

$break = $breakage == $BREAKAGE_SPACES ? " " : "-";
for($i=0 ; $i < $num ; $i++){
    $rand = rand(1, $size);
    $word = $case == $CASE_DEFAULT ? $dictionary[$rand-1] : $case == $CASE_UPPER ? strtoupper($dictionary[$rand-1]) : strtolower($dictionary[$rand-1]);
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
echo $answer;


$data['answer'] = $answer;



//response back
echo json_encode($data);

// return all our data to an AJAX call
//echo json_encode($request);

?>
