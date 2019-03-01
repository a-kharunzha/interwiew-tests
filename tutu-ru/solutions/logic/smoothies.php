<?
/*
1. В лофте `n` хипстерам достались `m` смузи. 
При этом все хипстеры - люди вежливые, и поэтому должны выпить одинаковое количество смузи (можно выбросить несколько). 
Напишите функцию `distributeSmoothies(int $m, int $n): int`, результатом которой будет количество смузи, которое выпьет каждый хипстер.
*/

/**
 *  
 * @param int $m количество порций
 * @param int $n количество людей
 */
function distributeSmoothies(int $m, int $n): int{
	return floor($m/$n);
}

/** людей => доступных порций */
$testsCases = [
	5=>8, // по одному, три лишних
	3=>16, // один лишний
	56=>13, // людей заведомо больше
	4=>8, // поровну без остатка
];

foreach ($testsCases as $peoples => $smoothies){
	echo "на {$peoples} людей из ".$smoothies." смузи придется по ". distributeSmoothies($smoothies, $peoples). "<br>";
}