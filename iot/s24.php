<?php  
	$services['test'] = '_test'; # test 이름으로 php 함수 "_test" 지정
	function _test() { # 서비스 함수 지정
	    error_log(__FILE__.":".__FUNCTION__); # 현 코드의 파일이름과 함수이름 저장
	    $cs = "(".$_POST['func'].")".$_SERVER['REMOTE_ADDR']
		   ."->".$_SERVER['SERVER_ADDR'];
	    responseJSON($cs, "success"); # 종료
	};
	
	$services['getuid']='_getuid';
	function _getuid() {
		responseJSON("20202865",'success');  
	};
	$services['getsensor']='_getsensor';
	function _getsensor() {
		$logf = file('log/check.log');
		$logf = str_replace(array("\t"), '', $logf);
		for($i=0; $i<10; $i++){
			$num=$i+1;
			if($num>$i){
				$rt=array("sensor"=>"usonic", "value"=>$logf[$i]);
				responseJSON($rt, 'success');			
			}
		}				
		#$i  = count($logf)-1;
		#$logf = str_replace(array("\n"), '', $logf);
		#$rt=array("sensor"=>"usonic","value"=>$logf[$i]);
		#responseJSON($rt, 'success');
	};  
	$services['getlog']='_getlog';  
	function _getlog(){
		$logf = file('log/check_time.log');
		$logf = str_replace(array("\t"), '', $logf);
		for($i=0; $i<10; $i++){
			$num=$i+1;
			$rt=array($logf[$i]);
			if($num>$i){
				responseJSON($rt, 'success');			
			}
		}				
	};  

	$services['collection']='_collection';  
	function _collection(){
		$rt=file('log/listapi.log');
		$rt = str_replace(array("\n"), '', $rt); 
		responseJSON($rt, 'success');
	};
	$services['listapi'] = '_listapi'; 
	function _listapi() {
    		$postdata = http_build_query(
        	array(
            	'func' => 'listapi'
        	)
    	);
    	$opts = array('http' =>
        	array(
            	'method' => 'POST',
            	'header' => 'Content-type: application/x-www-form-urlencoded',
            	'content' => $postdata
        	)
    	);

	$context = stream_context_create($opts);
    	$result = file_get_contents('http://rpi.allof.fun/s01.php', false, $context);
    	$object = json_decode($result);
    	$apii = $object->data;
	$myfile = fopen("log/listapi.log","w") or die("Unable to open file!");
	$j=10;
    	for ($i=0;$i<$j;$i=$i+1){
	$urll = $apii[$i]->api;
    	$getuid = uidPlus($urll);
    	$getsensor = sensorPlus($urll);
	if(empty($getuid) || empty($getsensor->sensor) || empty($getsensor->value) || !(is_numeric($getsensor->value))){
	$j=$j+1;
	continue;
	}
	$startTime = round(microtime(true));
	$list="{sid:$getuid,sensor:$getsensor->sensor,value:$getsensor->value,epoch:$startTime}\n";
	usleep(1);
	fwrite($myfile,$list);

			}
	fclose($myfile);
	};
	
	function uidPlus($u) {
    	$postdata = http_build_query(
        	array(
            	'func' => 'getuid'
        	)
    	);
    	$opts = array('http' =>
        	array(
            	'method' => 'POST',
            	'header' => 'Content-type: application/x-www-form-urlencoded',
            	'content' => $postdata
        	)
    	);
    	$context = stream_context_create($opts);
    	$result = file_get_contents($u, false, $context);
    	$object = json_decode($result);
    	$apii = $object->data;
    	return $apii;
	}

	function sensorPlus($u) {
    	$postdata = http_build_query(
        	array(
            	'func' => 'getsensor'
        	)
    	);
    	$opts = array('http' =>
        	array(
            	'method' => 'POST',
            	'header' => 'Content-type: application/x-www-form-urlencoded',
            	'content' => $postdata
        	)
    	);
    	$context = stream_context_create($opts);
    	$result = file_get_contents($u, false, $context);
    	$object = json_decode($result);
    	$apii = $object->data;
    	return $apii;
	}	

?>
