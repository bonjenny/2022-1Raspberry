<?php 
$services['test'] = '_test'; # test 이름으로 php 함수 "_test" 지정
function _test() { # 서비스 함수 지정
    error_log(__FILE__.":".__FUNCTION__); # 현 코드의 파일이름과 함수이름 저장
    $cs = "(".$_POST['func'].")".$_SERVER['REMOTE_ADDR']
           ."->".$_SERVER['SERVER_ADDR'];
    responseJSON($cs, "success"); # 종료
};

$services['create'] = '_create'; # create 서비스에 사용할 함수 "_create" 지정
function _create() { 
   $ctx = array();
   if (!file_exists("log")) mkdir ("log"); # 정보 저장할 log 폴더 생성
   if (file_exists("log/api.json")) { # 기존 정보가 있으면 읽어옴
     $ctx = json_decode(
        file_get_contents("log/api.json"), true);
   }
  
   $sid = $_POST['sid']; 
   $api = $_POST['api']; 
   $ctx[$sid]=array("sid"=>$sid, "api"=> $api); # 새로운 데이터를 SID 기준으로 업데이트
   file_put_contents("log/api.json", json_encode($ctx)); # 업데이트된 등록정보 파일로 저장
   responseJSON($sid, 'success');
};

$services['testapi'] = '_testapi'; # testapi 서비스에 사용할 함수 "_testapi" 지정
function _testapi() { 
   $api = $_POST['api'];
   $postdata = http_build_query(
     array(
	    'func' => 'test'
	 )
   );
   $opts = array('http' =>
     array(
	    'method' => 'POST',
		'header' =>
		   'Content-Type: application/x-www-form-urlencoded',
		'content' => $postdata # 전송 대상 데이터를 웹 형식으로 구성
	 )
   );
   $context = stream_context_create($opts);
   $rt = file_get_contents($api, false, $context); # 정보 수집
   responseJSON($rt, success);
};

$services['listapi'] = '_listapi'; # listapi 서비스에 사용할 함수 "_listapi" 지정
function _listapi() { 
   $ctx = array();
   if (!file_exists("log/api.json")) {
	 $ctx = json_decode(file_get_contents("log/api.json"), true);
   }
   $rt = array_values($ctx);
   responseJSON($rt, 'success');
};

$services['deleteapi'] = '_deleteapi'; # deleteapi 서비스에 사용할 함수 "_deleteapi" 지정
function _deleteapi() {
   error_log(__FILE__.__FUNCTION__);
   $sid = $_POST['sid'];
   if (!file_exists("log/api.json"))
	 responseJSON("nofile", "success");
   $old = json_decode(file_get_contents("log/api.json"), true);
   $ctx = array();
   forEach($old as $k => $v) {
	  if ("x".$sid == "x".$k) continue;
	  $ctx[$k] = $v;
   }
   file_put_contents("log/api.json", json_encode($ctx));
   responseJSON($sid, 'success');
};

$services['upload'] = '_upload'; # upload 서비스에 사용할 함수 "_upload" 지정
function _upload() {
   if($_FILES['file']['error'] > 0) {
	   responseJSON('An error occurred while uploading.');
   }
   $file = $_FILES["file"]["name"];
   $file = str_replace(" ","",$file);
   error_log("file name ".$file);
   if(!file_exists("media")) mkdir("media");
   if(!move_uploaded_file($_FILES['file']['tmp_name'], 'media/'.$file)) {
	   responseJSON('Error uploading file: '.print_r($_FILES, true));
   }
   // Success!
   responseJSON('File upload : ['.$file.'].', 'success');
};