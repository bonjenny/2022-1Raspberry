<?php 

$services['getuid'] = '_getuid';
function _getuid() { 
   responseJSON("20202865", 'success');
};

$services['getsensor'] = '_getsensor';
function _getsensor() { 
   $rt = array("sensor"=>"습도","value"=>66);
   responseJSON($rt, 'success');
};

$services['getlog'] = '_getlog';
function _getlog() { 
    $rt = array(1653544423=>67, 1653544523=>50);
   responseJSON( $rt, 'success');
};

$services['collection'] = '_collection';
function _collection() { 

$rt = [array('sid'=>20202865
             ,'sensor'=>'습도'
             ,'value'=>66
             , 'epoch'=>1653544423)
       , array('sid'=>202200012
             ,'sensor'=>'온도'
             ,'value'=>27
             , 'epoch'=>1653544424)
       , array('sid'=>202200014
             ,'sensor'=>'거리'
             ,'value'=>34.22
             , 'epoch'=>1653544425)];
 
   responseJSON($rt, 'success');
};
