## Задача
Есть массив, часть данных из которого необходимо перебрать.

В цикле получаем строку с разным содержанием, а также некий идентификатор итерации. В некоторых строках присутствуют тэги, вида "**#const_value1_value2...**". Первая часть тэга "**#const_**" – не меняется. Все, что идет далее может меняться (с разделителями в виде "_"). Этих тегов может быть любое количество (а может и не быть вовсе). После первой части, количество value может быть сколько угодно. Значения value могут быть содержать цифры и буквы разных языков. Необходимо создать массив, сгруппировав одинаковые value.  

Пример входных данных одной из итераций:
$id = 123;
$string = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at #const_value2_value3 convallis nisl, sed finibus erat. Vivamus commodo turpis at commodo lacinia. Praesent #const_value1_value2 vel sapien sed velit facilisis #const_value3_value8_value11_value12 sollicitudin a nec ante. Cras eu libero eget metus suscipit scelerisque ut vel ipsum. Etiam vestibulum ullamcorper #const_value3_value6_value7 venenatis. Nulla ac odio ut nisl #const_value3_value4_value5 vulputate #const_value3_value8_value9_value10 eleifend vitae nec erat.";

Массив, который должен получиться на выходе:
```
123 => // $id
	value1 => value2, // #const_value1_value2
	value2 => value3, // #const_value2_value3
	value3 =>
		value4 => value5, // #const_value3_value4_value5
		value6 => value7 // #const_value3_value6_value7
		value8 =>
			value9 => value 10 // #const_value3_value8_value9_value10
			value11 => value 12 // #const_value3_value8_value11_value12
```

задача была найдена случайно на фриланс бирже