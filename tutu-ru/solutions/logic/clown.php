<?
/*
Злой клоун хочет, чтобы в смайликах не было больше одной скобки подряд. Напишите функцию, которая поможет ему в этом, для любой фразы.
*/


/** людей => доступных порций */
$testsCases = [
	':)) qwre )) выавы fsd ;))))) ))',
	'ывавыа ) fsd ;))) ',
	
];

foreach ($testsCases as $inputStr){
	$outputStr = makeSmilesSadder($inputStr);
	echo $inputStr.'<br>'.$outputStr.'<br><br><br>';
}

/**
 * заменяет все вхождения повторяющихся закрывающих скобок на одну
 * 
 * @param string $inputStr
 * @return string
 */
function makeSmilesSadder($inputStr){
	// про фигурные скобки и грустные смайлики речи не было, потому ф-ция их не учитывает. Пре необходимости легко доработать
	return preg_replace('#\)+#', ')', $inputStr);
}