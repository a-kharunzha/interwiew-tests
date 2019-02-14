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
	$output[$id] = getArr($string);
}

echo "<pre>";
echo "input:\n";
var_dump($input);
echo "output:\n";
var_dump($output);
echo "</pre>";

/**
 * возвращает структурированный массив, извлекая ключи из выражений #const_value1_value2[..._valueN]
 * не для prod, решение чисто фановое, поскольку использует eval
 * 
 * @param string $inputStr
 * @param string $prefix префикс разбираемого выражения, на случай если нужно будет его поменять и реиспользовать ф-цию
 * 
 * @return $array
 */
function getArr($inputStr,$prefix = '#const'){
	$res = array();
	$parts = preg_match_all('@'.$prefix.'_[\w0-9]+@u', $inputStr, $matches);
	foreach ($matches[0] as $key => $value) {
		$code = preg_replace('@^'.$prefix.'_(.*)_([^_]+)$@u', "['$1'] = '$2'", $value);
		$code = str_replace('_',"']['",$code);
		$code = '$res'.$code.';';
		eval($code);
	}
	return $res;
}

