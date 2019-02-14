<?

$input = [
	// .... 
	123 => "#const_dfds45_435_DASDsd_ываыва_ывваВАЩЙ_ы_4545 Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at #const_value2_value3 convallis nisl, sed finibus erat. Vivamus commodo turpis at commodo lacinia. Praesent #const_value1_value2 vel sapien sed velit facilisis #const_value3_value8_value11_value12 sollicitudin a nec ante. Cras eu libero eget metus suscipit scelerisque ut vel ipsum. Etiam vestibulum ullamcorper #const_value3_value6_value7 venenatis. Nulla ac odio ut nisl #const_value3_value4_value5 vulputate #const_value3_value8_value9_value10 eleifend vitae nec erat.
		#const_dfds45_435_DASDsd_ываыва_ывваВАЩЙ_ы_4545
	",
	// .... 
	/*
	// тестовая простая строка для отладки пересекающихся ключей
	234=> "it  #const_value3_value8_value9_value10 amet, co #const_value3_value8_value11_value12 nsectetur adipiscing elit. 
	Pellentesque at ", 
	*/
	// тестовая простая строка для проверки отсутствия значений
	// 45756 => "s nisl, sed finibus erat. Vivamus commodo turpis at",
];

$output = [];
foreach ($input as $id => $string){
	$output[$id] = getArrRec($string);
}
echo "<pre>";
echo "input:\n";
var_dump($input);
echo "output:\n";
var_dump($output);
echo "</pre>";

/**
 * возвращает структурированный массив, извлекая ключи из выражений #const_value1_value2[..._valueN]
 * 
 * @param string $inputStr
 * @param string $prefix префикс разбираемого выражения, на случай если нужно будет его поменять и реиспользовать ф-цию
 * 
 * @return $array
 * @uses setByPath
 */
function getArrRec($inputStr,$prefix = '#const'){
	$res = array();
	// находим все вхождения характерных строк
	$parts = preg_match_all('@'.$prefix.'_[\w0-9]+@u', $inputStr, $matches);
	foreach ($matches[0] as $key => $value) {
		// в каждом отделяем часть, содержащую путь, и крайнюю, содержащую знаечение
		// @tothink: возможно, стоит бы подумать над первой регуляркой, чтобы уже сразу там разделять 
		$code = preg_match('@^'.$prefix.'_(.*)_([^_]+)$@u', $value, $parts);
		list(,$path,$value) = $parts;
		setByPath($res,$path,$value);
	}
	return $res;
}

/**
 * рекурсивно заполняет массив, используя части строки, разделенные символом подчеркивания, как ключи
 * 
 * @param &$array массив, который нужно наполнять
 * @param string $path строка содержащая путь в виде ключей, разделенных _
 * @param mixed значение, которое должно быть на самом глубоком уровне
 */
function setByPath(&$array,$path,$value){
	$firstDividerPos = strpos($path, '_');
	if($firstDividerPos == FALSE){
		$array[$path] = $value;
		return;
	}
	$firstPathKey = substr($path, 0, $firstDividerPos);
	$leftPath = substr($path, $firstDividerPos + 1);
	if(!isset($array[$firstPathKey])){
		$array[$firstPathKey] = [];
	}
	setByPath($array[$firstPathKey],$leftPath,$value);
}