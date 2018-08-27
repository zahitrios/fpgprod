<?php

	$palabra1="anita lava la tina";
	$palabra2=Array();

	$palabra1=str_split($palabra1);
	$ultimaPosicion=count($palabra1);

	$indice=;

	foreach(;;)
	{	

		//echo $v."<br>";
		echo $palabra1[$indice];


		if($v==" ")
		{
			$v="";
		}
		
		else
		{


		}

		//$palabra2[]=$v;

		if($indice==)
		{
			break;
		}

		$indice++;
		
	}


	if($palabra1==$palabra2)
	{
		echo "Sí es palindrome";
	}
	else
	{
		echo "No es palindrome";
	}
?>