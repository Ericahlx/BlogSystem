<?php
//预定义常量
	echo 'hello world';
	echo "<br>"."当前文件路径：".__FILE__;
	echo "<br>当前行数：".__LINE__;
	//PHP内建常量
	echo "<br>当前PHP版本信息：".PHP_VERSION;
	echo "<br>当前操作系统：".PHP_OS;

//可变变量，前一个变量的值需要跟后一个变量的名保持一致
	$change_name = "trans";
	$trans = "YYY";
	echo "<br>".$change_name;
	echo "<br>".$$change_name;

	$num = rand(1,31);
	if($num %2 == 0){
		echo "<br>\$num = $num";
		echo "<br>$num 是偶数";
	}


	