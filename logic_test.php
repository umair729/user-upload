<?php
$number = 1;
$out = array();
while($number <= 100){
	if($number % 3 == 0 && $number % 5 == 0)
        {
            array_push($out, 'foobar');
        }
	else if($number % 3 == 0)
        {
            array_push($out, 'foo');
        }
	else if($number % 5 == 0)
        {
            array_push($out, 'bar');
        }
	else
        {
            array_push($out, "$number");
        }
        
	$number++;
}
echo implode(', ', $out);
?>