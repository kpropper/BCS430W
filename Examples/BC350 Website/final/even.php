<?php 

$num = array(-2, 0, 1, 2, 2.2, "2", "Two");

foreach ($num as $val){

if (!(is_numeric($val) && is_int(0 + $val))){
echo $val . " is not an Integer<br>";
}else{
	oddEven($val);
}
}

function oddEven($i){
	if (($i % 2) == 0){
echo $i . " is an even number<br>";
} else {
echo $i . " is an odd number<br>";
}
}


?>