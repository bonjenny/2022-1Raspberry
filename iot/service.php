<?php
session_start();
if ($_SESSION['user.name'] != 'anhive') {
	$_SESSION['user.name'] = 'anhive';
};

$func = isset($_POST["func"])?$_POST["func"]:"none";
$_SESSION['last.service']=$func;

// whois 서비스
if(strcmp($func, "whois") == 0) {
	if(isset($_POST["name"]) || isset($_POST["age"])) {
		$rt = array("name" => $_POST["name"], "age" => $_POST['age']);
		outJSON($rt, 'success');
	}
// howlong 서비스
} else if(strcmp($func, "howlong") == 0) {
	$logf = 'log/check.log';
	if(!file_exists($logf))
		outJSON("log is not exist", 'success');
	else outJSON(file_get_contents($logf), 'success');
} else outJSON('['.$func.'] 오류');
// 신규 서비스 추가

function outJSON($msg, $status = 'error') {
	header('Content-Type: application/json');
	die(json_encode(array(
		'data' => $msg,
		'status' => $status
	)));
}
?>
