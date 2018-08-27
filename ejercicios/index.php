<?php

	$aux1=1;
	$aux2=1;
	$aux3=2;
	$cont=2;
	echo "1, 1 ";
	for (;;)
	{
		$aux3=$aux1+$aux2;
		$aux1=$aux2;
		$aux2=$aux3;
		echo ", ".$aux3;
		$cont++;
		if($cont==100)
			break;
	}


?>	