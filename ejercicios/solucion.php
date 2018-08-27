<?php

	$palabra1="anita lava la tina";
	$palabra2=Array();
	$palabra3=Array();

	$palabra1=str_split($palabra1);
	$ultimaPosicion=count($palabra1);

	$indice=$ultimaPosicion-1;
	$indice2=0;

	for(;;)
	{	


		//guarda en reverse
		if($palabra1[$indice]==" ")
		{}		
		else
		{
			$palabra2[]=$palabra1[$indice];
		}
		//guarda en reverse



		//guarda sin espacios
		if($palabra1[$indice2]==" ")
		{}		
		else
		{

			$palabra3[]=$palabra1[$indice2];
		}
		//guarda sin espacios

		
		if($indice==0)
			break;

		$indice--;
		$indice2++;
		
	}


	if($palabra2==$palabra3)
	{
		echo "Sí es palindrome";
	}
	else
	{
		echo " No es palindrome";
	}
?>