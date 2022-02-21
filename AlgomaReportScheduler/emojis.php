<?php 

$emojisKeys = array();
$emojisValues = array();


//https://github.com/wooorm/gemoji/blob/main/support.md
$emoticons = array(

	':pushpin:'		 => json_decode('"\ud83d\udccc"')
	,':clipboard:' => json_decode('"\ud83d\udccb"')
	,':smile:' => json_decode('"\uD83D\uDE2A"') 
	,':sluggy:' => json_decode('"\uD83D\uDE2A"') //pianto con singola lacrima
	,':angry:'  => json_decode('"\uD83D\uDE20"')
	,':tired:'  => json_decode('"\uD83D\uDE2B"')
	,':rocket:' => json_decode('"\uD83D\uDE80"')
	,':pizzaslice:' =>  json_decode('"\uD83C\uDF55"')
	,':beermug:' =>  json_decode('"\uD83C\uDF7A"') 
	,':redapple:' =>  json_decode('"\uD83C\uDF4E"')
	,':dblexl:' =>  json_decode('"\u3c\u20"')// !! rossi
	,':moneybag:' =>  json_decode('"\uD83D\uDCB0"')//	 
	,':chequered:'  =>  json_decode('"\uD83C\uDFC1"')//	 ,  	CHEQUERED FLAG
	,':sirena:' => json_decode('"\uD83D\uDEA8"')
	,':bar_chart:' => json_decode('"\uD83D\uDCCA"') 
	,':giraffe:' => json_decode('"\ud83e\udd92"') 
);


foreach ($emoticons as $key => $value){
	$emojisKeys[] = $key;
	$emojisValues[] = $value;
}

print_r($emojisValues);



function emojis($key, $times=1){
	
	
	$msg = "";
	global $emoticons;
	if($emoticons[$key]==null){
		return $key;
	}
	for($i =0;$i<$times;$i++)
		$msg .= $emoticons[$key];
		
	
	return $msg;
}



