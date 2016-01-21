<?php

$data = array();
$data['answer'] = 'test-test-test-test';

$_POST = json_decode(file_get_contents('php://input'), true);
//$data = file_get_contents("php://input");
//$request = json_decode($data, TRUE);
//print_r($request);


//TODO:calculate password


//response back
echo json_encode($data);












// return all our data to an AJAX call
//echo json_encode($request);

?>
