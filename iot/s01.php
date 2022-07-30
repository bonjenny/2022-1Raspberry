<?php 
function responseJSON($msg, $status = 'error') {
    header('Content-Type: application/json');
    die(json_encode(array(
        'data' => $msg,
        'status' => $status
    )));
}

#include_once("s01_service.php");
include_once("s24.php");

$func= isset($_POST['func'])?$_POST["func"]:"none"; # 서비스 이름을 지정
error_log("Function[".$func."] called");
if (!isset($services[$func])) # 서비스 이름이 지정되지 않은 경우
        responseJSON("No service[$func]."); # 알림
try {
    call_user_func( $services[$func]); # 지정된 함수를 찾아 실행
} catch (Exception $e) {
    responseJSON($e->getMessage()); # error 값 표시
    error_log(print_r($e->getTrace())); # error 발생위치 표시
}
?>
