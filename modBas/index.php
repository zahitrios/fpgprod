<?php

	session_start();
	include_once ("../conf/functions.php");
	include_once ("./functions.php");
	validarSession();

	set_time_limit (36000); //10 minutos para este script
	ini_set('memory_limit', '512M');

	$_SESSION["language_select"] = "es";
	$mensaje="";

	$idusuarios=dameIdUserMd5($_SESSION["i"]); 		
	if(usuarioTieneModulo($idusuarios,15)===false)//Valido que el usuario tenga el modulo de modificaciones
	{
		echo "SU USUARIO NO PUEDE REALIZAR ESTA ACCION";
		die;
	}

	cargaConstantesDelSistema();
?>

<html>
	<head>
		<title>FIPAGO - Base de datos</title>
		<meta charset="UTF-8">
		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
		
		<script text="javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script text="javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<link rel="stylesheet" type="text/css" href="../styles.css">
		<link rel="stylesheet" type="text/css" href="styles.css">		

		<link rel="stylesheet" type="text/css" href="<?php echo RUTA; ?>lib/CustomFileInputs/css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo RUTA; ?>lib/CustomFileInputs/css/demo.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo RUTA; ?>lib/CustomFileInputs/css/component.css" />

		<script language="javascript" src="../functions.js"></script>
		<script language="javascript" src="./functions.js"></script>
	</head>


	<body>		

		<div id="cargando">
			<img id="imagenCargando" src="<?php echo RUTA; ?>img/cargando.gif" />
			<br>
			<span id="progreso"></span>
		</div>

		<div id="menuLateral">
			<img src="<?php echo RUTA; ?>img/logo.jpg" style="width:100%;">
			<div class="itemMenu" onclick="cargaModulo('home');">Inicio</div>
				<?php
					cargaModulos();
				?>
			<div class="itemMenu" onclick="cargaModulo('logout');">Salir</div>
		</div>

		<div id="containerPrincipal">

			<div class='titulos'>Modificaciones a la de base de datos</div>
			<div class='usuarioLogueado'><?php echo nombreUsuarioLogeado(); ?></div>
			<div style="clear:both;"></div>	


			<div class="tablaCentrada">
			
					<?php
						actualizaErrores();
						$action=$_REQUEST["a"];
						

						switch($action)
						{
							case "upload":
								upload();
							break;

							case "checkFilasTodas":
								checkFilasTodas();
							break;

							case "comenzarReporteConsolidada":
								comenzarReporteConsolidada();
							break;

							case "comenzarReporteAnalitica":
								comenzarReporteAnalitica();
							break;

							case "revisaCabecerasYGeneralidades":
								revisaCabecerasYGeneralidades();
							break;

							case "muestraResumenReporte":
								muestraResumenReporte();
							break;

							case "pideFolioYFecha":
								pideFolioYFecha();
							break;

							case "comienzaActualizaciones":
								comienzaActualizaciones();
							break;

							default:
								formularioSubida();		
								gridModificaciones();						
							break;
						}
					?>
			</div>
		</div>
		<div style="clear:both;"></div>		
	</body>
</html>



<?php


	function actualizaErrores()
	{
		$sql="SELECT * FROM modificaciones";
		$res=mysql_query($sql);
		while($fil=mysql_fetch_assoc($res))
		{
			$sqlE="SELECT COUNT(*) AS total FROM erroresModificaciones WHERE modificaciones_idmodificaciones='".$fil["idmodificaciones"]."'";
			$resE=mysql_query($sqlE);
			$filE=mysql_fetch_assoc($resE);
			$errores=$filE["total"];

			$sqlU="UPDATE modificaciones SET errores=".$errores." WHERE idmodificaciones='".$fil["idmodificaciones"]."'";
			$resU=mysql_query($sqlU);
		}		
	}

	function formularioSubida()
	{
		global $_REQUEST,$mensaje;
		?>
		<br>
		<form id="formulario" method="post" enctype="multipart/form-data" action="./">
			
		
			<div class="box">
				<input type="file" name="fileToUpload" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} archivo seleccionado" style="display:none;" />
				<label for="file-5">
					<figure>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
							<path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
						</svg>
					</figure>
					<span>Elegir un archivo&hellip;</span>
				</label>
			</div>

			<br><br>
			<input type="submit" value="Subir" class="botonRojoChico">
			
			<input type="hidden" name="a" value="upload">
		</form>
		<script src="<?php echo RUTA; ?>/lib/CustomFileInputs/js/custom-file-input.js"></script>
		<br><br>
		<span class="mensaje"><?php echo $mensaje; ?></span>		
		<?php
	}




	function gridModificaciones()
	{
		$_SESSION["language_select"] = "es";
		$KoolControlsFolder="../lib/KoolPHPSuite/KoolControls";

		require $KoolControlsFolder."/KoolAjax/koolajax.php";
		require $KoolControlsFolder."/KoolGrid/koolgrid.php";
		require $KoolControlsFolder."/KoolGrid/ext/datasources/MySQLiDataSource.php";
		require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";

		$koolajax->scriptFolder = "../lib/KoolPHPSuite/KoolControls/KoolAjax"; 	

		$link=conectDBReturn();
		$ds = new MySQLDataSource($link);
		
		$ds->SelectCommand = "SELECT modificaciones.idmodificaciones,
									 modificaciones.fecha,									 
									 modificaciones.errores, 
									 IF(modificaciones.aplicada=1,'SI','NO') AS aplicada,  
									 SUBSTRING(modificaciones.archivo,13) AS archivo 
									 FROM modificaciones ORDER BY fecha DESC ";

		$grid = new KoolGrid("grid");

		$grid->scriptFolder="../lib/KoolPHPSuite/KoolControls/KoolGrid";
		$grid->styleFolder="../lib/KoolPHPSuite/KoolControls/KoolGrid/styles/office2010blue"; 
		
		$grid->ClientSettings->ClientEvents["OnRowClick"] = "Handle_OnRowClick";

		$grid->AjaxEnabled = true;
		$grid->AjaxLoadingImage =  "../lib/KoolPHPSuite/KoolControls/KoolAjax/loading/5.gif";	
		$grid->DataSource = $ds;
		$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
		$grid->Width = "860px";
		$grid->ColumnWrap = true;
		$grid->PageSize  = 10;
		$grid->AllowEditing = true;
		$grid->AllowDeleting = false;
		$grid->AllowResizing = true;
		
		$column = new GridBoundColumn();
		$column->HeaderText = "Id";
		$column->DataField = "idmodificaciones";
		$column->ReadOnly=true;		
		$grid->MasterTable->AddColumn($column);

		$column = new GridDateTimeColumn();
		$column->HeaderText = "Fecha";
		$column->DataField = "fecha";	
		$column->FormatString = "d M, Y";
		$column->Picker = new KoolDatePicker();
		$column->Picker->scriptFolder = $KoolControlsFolder."/KoolCalendar";
		$column->Picker->styleFolder = "sunset";	
		$column->Picker->DateFormat = "d M, Y";
		$grid->MasterTable->AddColumn($column);

		$column = new GridBoundColumn();
		$column->HeaderText = "Archivo";
		$column->DataField = "archivo";		
		$grid->MasterTable->AddColumn($column);		

		$column = new GridBoundColumn();
		$column->HeaderText = "Errores";
		$column->DataField = "errores";		
		$grid->MasterTable->AddColumn($column);	

		$column = new GridBoundColumn();
		$column->HeaderText = "Aplicada";
		$column->DataField = "aplicada";		
		$grid->MasterTable->AddColumn($column);		


		$grid->Localization->Load("../lib/KoolPHPSuite/KoolControls/KoolGrid/localization/es.xml");
		$grid->Process();

		?>
		<div class="tablaCentrada">			
			Revisiones realizadas
			<br><br>
			<form id="form1" method="post">	
				<?php 
					echo $koolajax->Render();				
					echo $grid->Render();
				?>
			</form>
			<br>
			<strong>Para revisar el reporte de un registro da click sobre la revisión deseada</strong>
			<br><br><br>
		</div>
		<?php
	}




	function upload()
	{
		global $_REQUEST,$mensaje;

		$target_dir = "../modFiles/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;

		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

		if ($_FILES["fileToUpload"]["size"] > 50000000) 
		{
		    $mensaje= "El archivo es demasiado grande, intente con uno menor a 50 megas";
		    $uploadOk = 0;
		}		
		if($imageFileType != "xls" && $imageFileType != "xlsx" ) 
		{
		    $mensaje= "Solo se admiten archivos xls o xlsx";
		    $uploadOk = 0;
		}		
		if(file_exists($target_file))
		{
			$mensaje= "Ya existe un archivo con ese nombre en el servidor";
		    $uploadOk = 0;
		}	
		if ($uploadOk == 0) 
		{
			formularioSubida();
		}
		else //todo bien
		{
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
		    {
		        $mensaje="El archivo fue subido correctamente";
		    } 
		    else 
		    {
		       $mensaje="Ocurrio un eror al subir el archivo";
		    }
		    ?>
		    	<span class="mensaje">
		    		<?php echo $mensaje; ?>
		    		<br>		    		
		    		<?php
		    			muestraPosiblesHojas($target_file);
		    		?>
		    	</span>
		    <?php
		}	
	}




	function muestraPosiblesHojas($file)
	{
		include("../lib/PHPExcel_1.8.0_doc/Classes/PHPExcel.php"); 


		$Reader = PHPExcel_IOFactory::createReaderForFile($file);
		$Reader->setReadDataOnly(true); // set this, to not read all excel properties, just data
		$worksheetData = $Reader->listWorksheetInfo($file);
		$sheetCount=count($worksheetData);

		foreach($worksheetData as $hojas => $hoja)
		{
			if($hoja["totalRows"]>$filaMasGrande)
				$filaMasGrande=$hoja["totalRows"];
		}
		
		echo "Hojas en el documento: <strong>".$sheetCount."</strong> (incluyendo hojas ocultas)<br><br>";
		
		$opcionesHojas="";		
		foreach($worksheetData as $hojas => $hoja)
		{
			$opcionesHojas.="<option value='".$hoja["worksheetName"]."'>".$hoja["worksheetName"]."</option>";
		}

		?>
		<form id="formulario"  name="opcionesArchivo" method="post">		
			<fieldset name="fieldSetHojas" class="fieldsetZht">
				<legend>Selecciona las hojas del documento que contienen las modificaciones</legend>
				<br>
				Consolidada: <select name="hojaConsolidada"><?php echo $opcionesHojas; ?></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Analítica: <select name="hojaAnalitica"><?php echo $opcionesHojas; ?></select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<br><br>
			</fieldset>
			<br><br>
			<input type="hidden" name="a" value="revisaCabecerasYGeneralidades" />
			<input type="hidden" name="fileD" value="<?php echo $file; ?>" />
			<input type="submit" value="Continuar" class="botonRojo">
		</form>

		<?php
	}


	


	function revisaCabecerasYGeneralidades()
	{
		global $_REQUEST,$mensaje;		
		include_once ("./classes.php"); 

		

		$file=$_REQUEST["fileD"];
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];

		$erroresCabeceras=0;

		if($hojaConsolidada!="")
		{
			$registrosConsolidada=getAllRegistros($file,$hojaConsolidada,"consolidada");
			$erroresConsolidada=revisaCabecerasYGeneralidadesConsolidada($registrosConsolidada);
		}


		if($hojaAnalitica!="")
		{
			$registrosAnalitica=getAllRegistros($file,$hojaAnalitica,"analitica");
			$erroresAnalitica=revisaCabecerasYGeneralidadesAnalitica($registrosAnalitica);
		}
		

		if($erroresConsolidada>0 || $erroresAnalitica>0)
		{
			echo "<br>";
			$erroresCabeceras++;
		}



	
		//Busco el número de la solicitud de modificación
		$numeroSolicitud=0;
		foreach($registrosConsolidada as $indiceRegistros => $registro)			
		{			
			if(trim($registro[14])!="")
			{
				$numeroSolicitud=$registro[14];
				break;
			}
			if($numeroSolicitud!=0)
				break;
		}
		if($numeroSolicitud==0)
		{
			$erroresCabeceras++;
			echo "<br><span class='error'>En la columna O no se encontró el número de solicitud de la modificación</span><br>";
		}
		


		



		$foliosIncorrectosAnalitica=Array();
		$foliosIncorrectosConsolidada=Array();
		$foliosCorrectosAnalitica=Array();
		$foliosCorrectosConsolidada=Array();

		if($hojaConsolidada!="")
		{	
			//Reviso que la consolidada cuente con nuevo folio identificador
			foreach($registrosConsolidada as $indiceRegistros => $registro)			
			{			
				if($registro[2]!="" && strtoupper($registro[15])!="ALTA" && strlen($registro[2])!=14 && $registro[2]!="NUEVO FOLIO IDENTIFICADOR" && !esUltimaFilaModificacionesConsolidada($registro))
					$foliosIncorrectosConsolidada[]= $registro[2];
				else if($registro[2]!="" && strlen($registro[2])==14 && $registro[2]!="NUEVO FOLIO IDENTIFICADOR" && !esUltimaFilaModificacionesConsolidada($registro))
					$foliosCorrectosConsolidada[]= $registro[2];
				
			}
			if(count($foliosIncorrectosConsolidada)>0 )
			{
				echo "LOS SIGUIENTES FOLIOS DE LA BASE CONSOLIDA NO CUENTAN CON EL FORMATO CORRECTO (EESSSTTTTAAAAA) ";
				echo "<ul>";
					foreach($foliosIncorrectosConsolidada as $k => $v)
						echo "<li>".$v."</li>";
				echo "</ul>";			
			}
		}





		if($hojaAnalitica!="")
		{	
			//Reviso que la analitica cuente con nuevo folio identificador
			foreach($registrosAnalitica as $indiceRegistros => $registro)
			{			
				if($registro[2]!="" && strtoupper($registro[29])!="ALTA" && strlen($registro[2])!=14 && $registro[2]!="NUEVO FOLIO IDENTIFICADOR" && !esUltimaFilaModificacionesAnalitica($registro))
					$foliosIncorrectosAnalitica[]= $registro[2];	

				else if($registro[2]!="" && strlen($registro[2])==14 && $registro[2]!="NUEVO FOLIO IDENTIFICADOR" && !esUltimaFilaModificacionesAnalitica($registro))
					$foliosCorrectosAnalitica[]= $registro[2];		
			}
			if(count($foliosIncorrectosAnalitica)>0)
			{
				echo "LOS SIGUIENTES FOLIOS DE LA BASE ANALÍTICA NO CUENTAN CON EL FORMATO CORRECTO (EESSSTTTTAAAAA) ";
				echo "<ul>";
					foreach($foliosIncorrectosAnalitica as $k => $v)
						echo "<li>".$v."</li>";
				echo "</ul>";	
			}
		}

		if(count($foliosIncorrectosAnalitica)>0 || count($foliosIncorrectosConsolidada)>0)
		{		
			echo "<br>";	
			$erroresCabeceras++;
		}



		





		$foliosQueNoExistenConsolidada=Array();
		//Valido que los folios de la consolidada esten en el padron
		if($hojaConsolidada!="")
		{
			foreach($foliosCorrectosConsolidada as $k => $folioParaBuscar)
			{
				if(!existeAhorradorEnPadron($folioParaBuscar))
					$foliosQueNoExistenConsolidada[]=$folioParaBuscar;
			}

			$foliosQueNoExistenConsolidada=array_unique($foliosQueNoExistenConsolidada);
			if(count($foliosQueNoExistenConsolidada)>0)
			{
				echo "LOS SIGUIENTES FOLIOS DE LA BASE CONSOLIDADA NO EXISTEN EN EL PADRON NACIONAL DE AHORRADORES";
				echo "<ul>";
					foreach($foliosQueNoExistenConsolidada as $k => $v)
						echo "<li>".$v."</li>";
				echo "</ul>";	
			}

		}


		$foliosQueNoExistenAnalitica=Array();
		//Valido que los folios de la analitica esten en el padron
		if($hojaAnalitica!="")
		{
			foreach($foliosCorrectosAnalitica as $k => $folioParaBuscar)
			{
				if(!existeAhorradorEnPadron($folioParaBuscar))
					$foliosQueNoExistenAnalitica[]=$folioParaBuscar;
			}

			$foliosQueNoExistenAnalitica=array_unique($foliosQueNoExistenAnalitica);
			if(count($foliosQueNoExistenAnalitica)>0)
			{
				echo "LOS SIGUIENTES FOLIOS DE LA BASE ANALÍTICA NO EXISTEN EN EL PADRON NACIONAL DE AHORRADORES";
				echo "<ul>";
					foreach($foliosQueNoExistenAnalitica as $k => $v)
						echo "<li>".$v."</li>";
				echo "</ul>";	
			}

		}

		if(count($foliosQueNoExistenConsolidada)>0 || count($foliosQueNoExistenAnalitica)>0)
		{		
			echo "<br>";	
			$erroresCabeceras++;
		}






		$banderaConsolidada=0;
		$banderaAnalitica=0;		
		$filaConsolidada=0;
		$filaAnalitica=0;		
		$filaConsolidada2=0;
		$filaAnalitica2=0;
		
		foreach($registrosConsolidada as $indiceRegistros => $registro)
		{
			if(strtoupper($registro[0])=="ESTATUS")			
				$banderaConsolidada=1;
				
			if($registro[0]!="" && $banderaConsolidada==1 && strtoupper($registro[0])!="ESTATUS" && $filaConsolidada==0)			
				$filaConsolidada=$registro[count($registro)-1];

			if(strtoupper($registro[3])=="TOTAL DICE:" || strtoupper($registro[3])=="TOTAL DICE")
				$filaConsolidada2=$registro[count($registro)-1];	
		}

		
		foreach($registrosAnalitica as $indiceRegistros => $registro)
		{
			if(strtoupper($registro[0])=="ESTATUS")			
				$banderaAnalitica=1;
				
			if($registro[0]!="" && $banderaAnalitica==1 && strtoupper($registro[0])!="ESTATUS" && $filaAnalitica==0)			
				$filaAnalitica=$registro[count($registro)-1];

			if(strtoupper($registro[3])=="TOTAL DICE:" || strtoupper($registro[3])=="TOTAL DICE:")	
				$filaAnalitica2=$registro[count($registro)-1];	
		}

		
		$erroresFilas=0;
		$mensajeErroresFilas="";

		if($filaConsolidada==0)
		{
			$mensajeErroresFilas="No se encontró la celda con el valor 'ESTATUS' para la revisión de la base consolidada";
			$erroresFilas++;
		}

		else if($filaConsolidada2==0)
		{
			$mensajeErroresFilas="No se encontró la celda con el valor 'TOTAL DICE:' para la revisión de la base consolidada";
			$erroresFilas++;
		}

		else if($filaAnalitica==0)
		{
			$mensajeErroresFilas="No se encontró la celda con el valor 'ESTATUS' para la revisión de la base analítica";
			$erroresFilas++;
		}

		else if($filaAnalitica2==0)
		{
			$mensajeErroresFilas="No se encontró la celda con el valor 'TOTAL DICE:' para la revisión de la base analítica";
			$erroresFilas++;
		}

		if($erroresFilas>0)
		{
			echo "<br>";
			echo $mensajeErroresFilas."<br><br>";
			$erroresCabeceras++;
		}











		// VALIDO QUE NO VENGAN INCOMPLETOS LOS REGISTROS DE LA BASE CONSOLIDADA //
		$incompletosConsolidada=0;
		$registroIncompletoConsolidada=Array();
		
		foreach($registrosConsolidada as $indice => $registro)
		{
			if($registro[count($registro)-1]>=$filaConsolidada && $registro[count($registro)-1]<=$filaConsolidada2)
			{
				foreach($registro as $campo => $valor)
				{
					if(trim($valor)=="" && $registro[15]!="ALTA" && strpos(strtoupper($registro[3]),"TOTAL")===false)
					{
						$incompletosConsolidada=1;
						$registroIncompletoConsolidada=$registro;
						$campoIncompleto=$campo;
						break;
					}
				}
			}
			if($incompletosConsolidada==1)
				break;
		}
		if($incompletosConsolidada==1)
		{
			echo "<br>";
			echo "<span class='error'>EL REGISTRO DE LA FILA ".$registroIncompletoConsolidada[count($registro)-1]." DE LA BASE CONSOLIDADA CUENTA CON CELDAS VACIAS EN ".$campoIncompleto."</span>";
			$erroresCabeceras++;
		}










		// VALIDO QUE NO VENGAN INCOMPLETOS LOS REGISTROS DE LA BASE ANALÍTICA //
		// $incompletosAnalitica=0;
		// $registroIncompletoAnalitica=Array();
		// foreach($registrosAnalitica as $indice => $registro)
		// {
		// 	if($registro[count($registro)-1]>=$filaAnalitica && $registro[count($registro)-1]<=$filaAnalitica2)
		// 	{
		// 		foreach($registro as $campo => $valor)
		// 		{
		// 			if(trim($valor)=="" && $registro[29]!="ALTA" && strpos(strtoupper($registro[3]),"TOTAL")===false)
		// 			{
		// 				$incompletosAnalitica=1;
		// 				$registroIncompletoAnalitica=$registro;
		// 				break;
		// 			}
		// 		}
		// 	}
		// 	if($incompletosAnalitica==1)
		// 		break;
		// }
		// if($incompletosAnalitica==1)
		// {
		// 	echo "<br>";
		// 	echo "<span class='error'>EL REGISTRO DE LA FILA ".$registroIncompletoAnalitica[count($registro)-1]." DE LA BASE ANALÍTICA CUENTA CON CELDAS VACIAS</span>";
		// 	$erroresCabeceras++;
		// }













		// VALIDO QUE EN LA COLUMNA P (15) DE LA CONSOLIDADA TENGA SOLO LAS OPCIONES PERMITIDAS //
		$acciones[]="ALTA";
		$acciones[]="BAJA";
		$acciones[]="BAJA POR HOMONIMIA";
		$acciones[]="MODIFICACIÓN";

		$accionesNoRegistradasConsolidada=0;
		$registroMalConsolidada=Array();
		foreach($registrosConsolidada as $indice => $registro)
		{
			if($registro[count($registro)-1]>=$filaConsolidada && $registro[count($registro)-1]<=$filaConsolidada2)
			{	
				if(!in_array(strtoupper($registro[15]),$acciones)  && strpos(strtoupper($registro[3]),"TOTAL")===false)
				{
					$accionesNoRegistradasConsolidada++;
					$registrosMalConsolidada[]=$registro;
				}
			}
		}
		if($accionesNoRegistradasConsolidada!=0)
		{
			echo "<br>";
			foreach($registrosMalConsolidada as $k => $v)
				echo "<span class='error'>EL REGISTRO DE LA FILA ".$v[count($registro)-1]." DE LA BASE CONSOLIDADA NO CUMPLE CON LAS ACCIONES PERMITIDAS EN LA COLUMNA P</span><br>";
			$erroresCabeceras++;

			echo "<br><br>LAS ACCIONES PERMITIDAS SON";
			echo "<ul>";
				foreach($acciones as $k => $v)
					echo "<li>".$v."</li>";
			echo "</ul>";
		}












		// VALIDO QUE EN LA COLUMNA AD (29) DE LA ANALITICA TENGA SOLO LAS OPCIONES PERMITIDAS //
		$accionesNoRegistradasAnalitica=0;
		$registroMalAnalticia=Array();
		foreach($registrosAnalitica as $indice => $registro)
		{
			if($registro[count($registro)-1]>=$filaAnalitica && $registro[count($registro)-1]<=$filaAnalitica2)
			{	
				if(!in_array(strtoupper($registro[29]),$acciones)  && strpos(strtoupper($registro[3]),"TOTAL")===false)
				{
					$accionesNoRegistradasAnalitica++;
					$registrosMalAnalticia[]=$registro;
				}
			}
		}
		if($accionesNoRegistradasAnalitica!=0)
		{
			echo "<br>";
			foreach($registrosMalAnalticia as $k => $v)
				echo "<span class='error'>EL REGISTRO DE LA FILA ".$v[count($registro)-1]." DE LA BASE ANALÍTICA NO CUMPLE CON LAS ACCIONES PERMITIDAS EN LA COLUMNA AC</span><br>";
			$erroresCabeceras++;

			echo "<br><br>LAS ACCIONES PERMITIDAS SON";
			echo "<ul>";
				foreach($acciones as $k => $v)
					echo "<li>".$v."</li>";
			echo "</ul>";
		}






		if($erroresCabeceras>0)
		{
			echo "<br>";
			unlink($file); //Borro el archivo
			?>
			<br><br>
			<input type="button" value="Regresar" class="botonRojoChico" onclick="cargaModulo('modBas')">
			<br><br>
			<?php
			die;
		}
















		?>
		<form  id="formulario" name="opcionesArchivo" method="post">		

			<fieldset name="fieldSetfilas" class="fieldsetZht">
				<legend>Elegir convenio para las modificaciones</legend>
				<br>
				<?php
					$sql="SELECT * FROM convenio WHERE statusConvenio_idstatusConvenio=3 OR statusConvenio_idstatusConvenio=4"; //publicados y en proceso unicamente
					$res=mysql_query($sql);
					echo "<select name='convenio' required>";
						echo "<option value=''>Selecciona una opción</option>";
						while($fil=mysql_fetch_assoc($res))
						{
							$nombreEstado=dameNombreEstadoConvenio($fil["idconvenio"]);
							$statusConvenio=dameStatusConvenio($fil["idconvenio"]);
							echo "<option value='".$fil['idconvenio']."'>".$fil["idconvenio"]." - ".$nombreEstado." - ".convierteTimeStampCorto($fil["fechaFirma"])." - ".$statusConvenio."</option>";
						}
					echo "</select>";

				?>
				<br>
				Número de solicitud del archivo: <strong><?php echo  $numeroSolicitud; ?></strong>
				<br><br>
			</fieldset>

			<br><br>

			
				<fieldset name="fieldSetfilas" class="fieldsetZht">
					<legend>Confirma las <strong>filas</strong> desde donde <strong>comienzan</strong> las modificaciones de cada hoja</legend>
					<br>
					Consolidada: <input required type="number" name="filaConsolidada" value="<?php echo $filaConsolidada; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Analítica: <input required type="number" name="filaAnalitica" value="<?php echo $filaAnalitica; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					
					<br><br>
				</fieldset>

				<br><br>

				<fieldset name="fieldSetfilasFinal" class="fieldsetZht">
					<legend>Confirma las <strong>filas</strong>  donde <strong>finalizan</strong> las modificaciones de cada hoja</legend>
					<br>
					Consolidada: <input required type="number" name="filaConsolidada2" value="<?php echo $filaConsolidada2-1; ?>" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Analítica: <input required type="number" name="filaAnalitica2" value="<?php echo $filaAnalitica2-1; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					
					<br><br>				
				</fieldset>
				<br><br>

			<input type="hidden" name="a" value="checkFilasTodas" />
			<input type="hidden" name="fileD" value="<?php echo $file; ?>" />
			<input type="hidden" name="numeroSolicitudArchivo" value="<?php echo $numeroSolicitud; ?>" />
			
			<input type="hidden" name="hojaConsolidada" value="<?php echo $hojaConsolidada; ?>" />
			<input type="hidden" name="hojaAnalitica" value="<?php echo $hojaAnalitica; ?>" />
			
			<input type="submit" value="Continuar" class="botonRojo">
		</form>

		<?php
	}

	

	function revisaCabecerasYGeneralidadesConsolidada($registrosConsolidada)
	{
		global $_REQUEST,$mensaje;		
		include_once ("./classes.php"); 

		$file=$_REQUEST["fileD"];
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		
		$erroresCabeceras=0;

		$cabecera=0;
		//Valido la cabecera de la base consolidada
		foreach($registrosConsolidada as $fila => $celdas)
		{			
			foreach($celdas as $celda => $valor)
			{
				if(strtoupper($valor)==="NUEVO FOLIO IDENTIFICADOR")
				{
					$cabecera=$fila;
					break;
				}
				if($cabecera!=0)
					break;
			}
			if($cabecera!=0)
					break;
		}
		if($cabecera==0)
		{
			$erroresCabeceras++;
			echo "<br>";
			echo "<span class='error'>NO SE ENCONTRO EN LA COLUMNA <strong>C</strong> 'NUEVO FOLIO IDENTIFICADOR' DE LA BASE CONSOLIDADA, PARA INICIAR CON LA REVISIÓN DE LAS MODIFICACIONES</span>";
			echo "<br>";
			echo "<strong>DESCARGUE EL FORMATO PARA LAS MODIFICACIONES A LA BSE DE DATOS</strong>";
			echo "<br>";
			echo "<a href='/formatosModificacion.xlsx' target='blank'>DESCARGAR</a>";
			echo "<br><br>";	
		}
		else if(!validaCabeceraModificacionesConsolidada($registrosConsolidada,$cabecera))
		{
			$erroresCabeceras++;
			echo "<br>";
			echo "<strong>FORMATO PARA LA CABECERA DE LAS REVISIONES A LA BASE CONSOLIDADA</strong>";
			echo "<br>";
			imprimeCabeceraModificacionesConsolidada();
			echo "<br><br>";			
		}


		return $erroresCabeceras;

	}




	function revisaCabecerasYGeneralidadesAnalitica($registrosAnalitica)
	{
		global $_REQUEST,$mensaje;		
		include_once ("./classes.php"); 

		$file=$_REQUEST["fileD"];		
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];

		$erroresCabeceras=0;

		$cabecera=0;
		//Valido la cabecera de la base consolidada
		foreach($registrosAnalitica as $fila => $celdas)
		{			

			foreach($celdas as $celda => $valor)
			{
				
				if(trim(strtoupper($valor))=="NUEVO FOLIO IDENTIFICADOR")
				{
					$cabecera=$fila;
					break;
				}
				if($cabecera!=0)
					break;
			}
			
			if($cabecera!=0)
					break;
		}
		if($cabecera==0)
		{
			$erroresCabeceras++;
			echo "<br>";
			echo "<span class='error'>NO SE ENCONTRO EN LA COLUMNA <strong>C</strong> 'NUEVO FOLIO IDENTIFICADOR' DE LA BASE ANALÍTICA PARA INICIAR CON LA REVISIÓN DE LAS MODIFICACIONES</span>";
			echo "<br>";
			echo "<strong>DESCARGUE EL FORMATO PARA LAS MODIFICACIONES A LA BSE DE DATOS</strong>";
			echo "<br>";
			echo "<a href='/formatosModificacion.xlsx' target='blank'>DESCARGAR</a>";
			echo "<br><br>";	
		}
		else if(!validaCabeceraModificacionesAnalitica($registrosAnalitica,$cabecera))
		{
			$erroresCabeceras++;
			echo "<br>";
			echo "<strong>FORMATO PARA LA CABECERA DE LAS REVISIONES A LA BASE ANALÍTICA</strong>";
			echo "<br>";
			imprimeCabeceraModificacionesAnalitica();
			echo "<br><br>";			
		}


		return $erroresCabeceras;
	}





	function checkFilasTodas()
	{
		global $_REQUEST,$mensaje;

		require("./classes.php"); 

		$file=$_REQUEST["fileD"];
	
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];
		

		$filaConsolidada=$_REQUEST["filaConsolidada"];
		$filaAnalitica=$_REQUEST["filaAnalitica"];
		

		$filaConsolidada2=$_REQUEST["filaConsolidada2"];
		$filaAnalitica2=$_REQUEST["filaAnalitica2"];
		
		$idconvenio=$_REQUEST["convenio"];


		//Inserto la modificacion
		$sql="INSERT INTO modificaciones (convenio_idconvenio,archivo) VALUES ('".$idconvenio."','".$file."')";
		$res=mysql_query($sql);
		$idmodificaciones=mysql_insert_id();
		guardaLog(dameIdUserMd5($_SESSION["i"]),10,"modificaciones",$idmodificaciones);



		//// LA CONSOLIDADA ////	
		if($hojaConsolidada!="")
		{				
			echo "Leyendo las modificaciones a la base consolidada, hoja <strong>".$hojaConsolidada."</strong> <br>";
			$registros=insertRegistrosModificaciones($file,$hojaConsolidada,$filaConsolidada,$filaConsolidada2+2);

			$contador=1;
			$registroCompleto=Array();
			$registroFinal=Array();
			foreach($registros as $indice => $registro)
			{			
				if($contador%2!=0) //IMPAR	
				{				
					$registroCompleto[0]=$registro;
				}
				
				else //PAR
				{
					$registroCompleto[1]=$registro;

					// echo "<pre>";
					// 	print_r($registroCompleto[0]);
					// echo "</pre>";
					// die;

 					$sqlInsert="INSERT INTO modificacionesConsolidada (modificaciones_idmodificaciones, consecutivo, folioIdentificador, nombreAhorradorDice, nombreAhorradorDebeDecir, curpDice, curpDebeDecir, parteSocialDice, parteSocialDebeDecir, cuentasDeAhorroDice, cuentasDeAhorroDebeDecir, cuentaDeInversionDice, cuentaDeInversionDebeDecir, depositosEnGarantiaDice, depositosEnGarantiaDebeDecir, chequesNoCobradosDice, chequesNoCobradosDebeDecir, otrosDepositosDice, otrosDepositosDebeDecir, prestamosACargoDice, prestamosACargoDebeDecir, saldoNeto100Dice, saldoNeto100DebeDecir, saldoNeto70Dice, saldoNeto70DebeDecir, montoMaximoPagoDice, montoMaximoPagoDebeDecir, observacionesDice, observacionesDebeDecir, filaOriginalDocumento ) VALUES ('".$idmodificaciones."', '".$registroCompleto[0][1]."', '".$registroCompleto[0][2]."', '".$registroCompleto[0][3]."', '".$registroCompleto[1][3]."', '".$registroCompleto[0][4]."', '".$registroCompleto[1][4]."', '".$registroCompleto[0][5]."', '".$registroCompleto[1][5]."', '".$registroCompleto[0][6]."', '".$registroCompleto[1][6]."', '".$registroCompleto[0][7]."', '".$registroCompleto[1][7]."', '".$registroCompleto[0][8]."', '".$registroCompleto[1][8]."', '".$registroCompleto[0][9]."', '".$registroCompleto[1][9]."', '".$registroCompleto[0][10]."', '".$registroCompleto[1][10]."', '".$registroCompleto[0][11]."', '".$registroCompleto[1][11]."', '".$registroCompleto[0][12]."', '".$registroCompleto[1][12]."', '".$registroCompleto[0][13]."', '".$registroCompleto[1][13]."', '".$registroCompleto[0][14]."', '".$registroCompleto[1][14]."', '".$registroCompleto[0][15]."', '".$registroCompleto[1][15]."', '".$registroCompleto[0][count($registroCompleto[0])-1]."')";
					 $resInsert=mysql_query($sqlInsert);
				    if(!$resInsert)
				    {
				    	echo "error:<br><br>".$sqlInsert."<br><br>".mysql_error()."<br><br>";
				    	die;
				    }
				}
				$contador++;				
			}//foreach($registros as $indice => $registro)
		}//if($hojaConsolidada!="")





		//// LA ANALITICA ////
		if($hojaAnalitica!="")
		{			
			echo "Leyendo la base analítica, hoja <strong>".$hojaAnalitica."</strong> <br>";			
			$registros=insertRegistrosModificaciones($file,$hojaAnalitica,$filaAnalitica,$filaAnalitica2+2);

			foreach($registros as $indice => $registro)
			{	
				$sqlInsert="INSERT INTO modificacionesAnalitica (modificaciones_idmodificaciones, estatus, numero, folioIdentificador, nombreAhorrador, curp, folioPS, tipoDocumentoPS, importePS, folioCA, tipoDocumentoCA, importeCA, folioCI, tipoDocumentoCI, importeCI, folioDG, tipoDocumentoDG, importeDG, folioCNC, tipoDocumentoCNC, importeCNC, folioOD, tipoDocumentoOD, importeOD, folioPC, tipoDocumentoPC, importePC, saldoNeto100, saldoNeto70, montoMaximoPago, observaciones, filaOriginalDocumento ) VALUES ('".$idmodificaciones."', '".$registro[0]."', '".$registro[1]."', '".$registro[2]."', '".$registro[3]."', '".$registro[4]."', '".$registro[5]."', '".$registro[6]."', '".$registro[7]."', '".$registro[8]."', '".$registro[9]."', '".$registro[10]."', '".$registro[11]."', '".$registro[12]."', '".$registro[13]."', '".$registro[14]."', '".$registro[15]."', '".$registro[16]."', '".$registro[17]."', '".$registro[18]."', '".$registro[19]."', '".$registro[20]."', '".$registro[21]."', '".$registro[22]."', '".$registro[23]."', '".$registro[24]."', '".$registro[25]."', '".$registro[26]."', '".$registro[27]."', '".$registro[28]."', '".$registro[29]."', '".$registro[count($registro)-1]."')";
				$resInsert=mysql_query($sqlInsert);
			    if(!$resInsert)
			    {
			    	echo "error:<br><br>".$sqlInsert."<br>".mysql_error()."<br><br>";
			    	die;
			    }

			}//foreach
		}//if($hojaAnalitica)


		?>
		<br>
		<form  id="formulario" method="post">

			<input type="hidden" name="a" value="comenzarReporteConsolidada" />

			<input type="hidden" name="fileD" value="<?php echo $_REQUEST['fileD']; ?>" />
			<input type="hidden" name="hojaConsolidada" value="<?php echo $_REQUEST['hojaConsolidada']; ?>" />
			<input type="hidden" name="hojaAnalitica" value="<?php echo $_REQUEST['hojaAnalitica']; ?>" />
			
			<input type="hidden" name="filaConsolidada" value="<?php echo $_REQUEST['filaConsolidada']; ?>" />
			<input type="hidden" name="filaAnalitica" value="<?php echo $_REQUEST['filaAnalitica']; ?>" />
			
			<input type="hidden" name="filaConsolidada2" value="<?php echo $_REQUEST['filaConsolidada2']; ?>" />
			<input type="hidden" name="filaAnalitica2" value="<?php echo $_REQUEST['filaAnalitica2']; ?>" />
			
			<input type="hidden" name="idmodificaciones" value="<?php echo $idmodificaciones; ?>" />
			<input type="hidden" name="idconvenio" value="<?php echo $idconvenio; ?>" />
			<input type="hidden" name="numeroSolicitudArchivo" value="<?php echo $_REQUEST['numeroSolicitudArchivo']; ?>" />

			<input type="submit" value="Generar reporte" class="botonRojo">
		
		</form>
		<?php

	}


	





	function comenzarReporteConsolidada($getErrores=0)
	{
		global $_REQUEST,$mensaje;

		$erroresTotalesReporte=0;

		$idmodificaciones=$_REQUEST["idmodificaciones"];
		$idconvenio=$_REQUEST["idconvenio"];
		$numeroSolicitudArchivo=$_REQUEST["numeroSolicitudArchivo"];
		$erroresConsolidada=0;		

	
		echo "<span class='subTitulos' style='font-weight:bold;'>Detalle del reporte de la base consolidada</span>";

		?>
			<div id='divDetalleErrores'>
				<fieldset class="fieldsetZht fieldSetReporte">
					<legend><strong>Reporte sobre la base de datos consolidada</strong></legend>
					<br>
					<?php


						//Busco que la solicitud de la modificacion sea la correcta				
						$sqlNM="SELECT COUNT(*) AS total FROM modificaciones WHERE convenio_idconvenio='".$idconvenio."' AND aplicada=1";
						$resNM=mysql_query($sqlNM);
						$filNM=mysql_fetch_assoc($resNM);
						$totalModificacionesAnteriores=$filNM["total"];
						$totalModificacionesAnteriores++;


						if($totalModificacionesAnteriores!=$numeroSolicitudArchivo)
						{
							$cadenaError="El archivo indica la modificación número <strong>".$numeroSolicitudArchivo."</strong> y debe ser <strong>".$totalModificacionesAnteriores."</strong>";
							$erroresConsolidada++;
							echo $cadenaError."<br>";
							guardaErrorModificacion($idmodificaciones,$cadenaError);
						}


						echo "<br>";


						$foliosNoEncontrados=Array();




						// BUSCO CARACTERES ESPECIALES //
						$camposDoblesEspacios=Array("nombreAhorradorDebeDecir","curpDebeDecir");
						$leyendasDoblesEspacios=Array("Nombre del ahorrador debe decir","CURP debe decir");
						foreach($camposDoblesEspacios as $k => $campo)
						{							
							$sql="SELECT * FROM modificacionesConsolidada WHERE ".$campo." regexp '[^a-zA-Z0-9\ \ñ\Ñ\/ ]' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorradorDice) NOT LIKE 'TOTAL%'";
							$res=mysql_query($sql);							
							echo "Caracteres especiales en el campo ".$leyendasDoblesEspacios[$k]." : <strong>".mysql_num_rows($res)."</strong>";
							if(mysql_num_rows($res)>0)
							{
								echo "<span class='botonMostrar' onclick='muestraOculta(\"divCaracteresEspecialesConsolidada".$k."\");' >Mostrar/Ocultar</span>";

								echo "<div class='oculta' id='divCaracteresEspecialesConsolidada".$k."'>";
									echo "<ul>";									
									$res=mysql_query($sql);
									while($fil=mysql_fetch_assoc($res))
									{
										$cadenaError="Se encontraron caracteres especiales en el campo <strong>".$leyendasDoblesEspacios[$k]."</strong>: <span class=\"error\">".addslashes($fil[$campo])."</span>";
										echo "<li>".$cadenaError."</li>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
									}
									echo "</ul>";
								echo "</div>";
							}

							echo "<br><br>";
						}
						//FIN BUSCO CARACTERES ESPECIALES //






						//VALIDO EL CONSECUTIVO
						$consecutivo=1;
						$sqlCon="SELECT consecutivo,filaOriginalDocumento FROM modificacionesConsolidada WHERE UPPER(nombreAhorradorDice) NOT LIKE 'TOTAL%' AND modificaciones_idmodificaciones='".$idmodificaciones."' ORDER BY 	idmodificacionesConsolidada ASC ";
						//echo $sqlCon."<br>";
						$resCon=mysql_query($sqlCon);
						while($filCon=mysql_fetch_assoc($resCon))
						{
							if($filCon["consecutivo"]!=$consecutivo)
							{
								$cadenaError="El consecutivo <strong>".$filCon["consecutivo"]."</strong> rompe con la secuencia en la fila <strong>".$filCon["filaOriginalDocumento"]." </strong>";
								echo "<span class='error'>".$cadenaError."</span><br>";
								guardaErrorModificacion($idmodificaciones,$cadenaError);
							}

							$consecutivo++;
						}
						//VALIDO EL CONSECUTIVO
						echo "<br><br>";









						//BUSCO QUE LOS FOLIOS QUE NO ESTEN EN EL CONVENIO
						$sql="SELECT folioIdentificador FROM modificacionesConsolidada WHERE UPPER(observacionesDice)<>'ALTA' AND folioIdentificador NOT IN(SELECT folioIdentificador FROM ahorrador INNER JOIN convenio_has_ahorrador ON idahorrador=ahorrador_idahorrador WHERE convenio_idconvenio='".$idconvenio."') AND modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>''";
						$res=mysql_query($sql);
						echo "Folios no econtrados en el convenio: ".mysql_num_rows($res);						
						if(mysql_num_rows($res)>0)
						{
							$cadenaError="Folios de la base consolidada no econtrados en el convenio (".mysql_num_rows($res)."): ";
							$erroresConsolidada++;
							echo "<span class='botonMostrar' onclick='muestraOculta(\"divFoliosNoEncontradosConsolidada\");' >Mostrar/Ocultar</span>";
							echo "<div class='oculta' id='divFoliosNoEncontradosConsolidada'>";	
								echo "<ul>";									
									while($fil=mysql_fetch_assoc($res))
									{
										echo "<li>".$fil["folioIdentificador"]."</li>";
										$cadenaError.=", ".$fil["folioIdentificador"];
										$foliosNoEncontrados[]=$fil["folioIdentificador"];
									}
								echo "</ul>";					
							echo "</div>";

							guardaErrorModificacion($idmodificaciones,$cadenaError);
						}
						//FIN BUSCO QUE LOS FOLIOS QUE NO ESTEN EN EL CONVENIO
						echo "<br><br>";





					//VALIDO LAS SUMAS VERTICALES BIEN CALCULADAS//
					$leyendasImportes=array("parteSocialDice"=>"dice en parte social", "parteSocialDebeDecir"=>"debe decir en parte social", "cuentasDeAhorroDice"=>"dice en cuentas de ahorro", "cuentasDeAhorroDebeDecir"=>"debe decir en cuentas de ahorro", "cuentaDeInversionDice"=>"dice en cuentas de inversión", "cuentaDeInversionDebeDecir"=>"debe decir en cuentas de inversión", "depositosEnGarantiaDice"=>"dice en depósitos en garantía", "depositosEnGarantiaDebeDecir"=>"debe decir en depósitos en garantía", "chequesNoCobradosDice"=>"dice en cheques no cobrados", "chequesNoCobradosDebeDecir"=>"debe decir en cheques no cobrados", "otrosDepositosDice"=>"dice en otros depósitos", "otrosDepositosDebeDecir"=>"debe decir en otros depósitos", "prestamosACargoDice"=>"dice en préstamos a cargo", "prestamosACargoDebeDecir"=>"debe decir en préstamos a cargo", "saldoNeto100Dice"=>"dice en saldo neto al 100%", "saldoNeto100DebeDecir"=>"debe decir en saldo neto al 100%", "saldoNeto70Dice"=>"dice en saldo neto al 70%", "saldoNeto70DebeDecir"=>"debe decir en saldo neto al 70%", "montoMaximoPagoDice"=>"dice en monto máximo de pago", "montoMaximoPagoDebeDecir"=>"debe decir en monto máximo de pago");
					
					$sqlArch="SELECT * FROM modificacionesConsolidada WHERE UPPER(nombreAhorradorDice) LIKE 'TOTAL%' AND modificaciones_idmodificaciones='".$idmodificaciones."'";
					$resArch=mysql_query($sqlArch);
					$filArch=mysql_fetch_assoc($resArch);

					$sqlSumas="SELECT ROUND(SUM(parteSocialDice),2) AS parteSocialDice , ROUND(SUM(parteSocialDebeDecir),2) AS parteSocialDebeDecir, ROUND(SUM(cuentasDeAhorroDice),2) AS cuentasDeAhorroDice, ROUND(SUM(cuentasDeAhorroDebeDecir),2) AS cuentasDeAhorroDebeDecir, ROUND(SUM(cuentaDeInversionDice),2) AS cuentaDeInversionDice, ROUND(SUM(cuentaDeInversionDebeDecir),2) AS cuentaDeInversionDebeDecir, ROUND(SUM(depositosEnGarantiaDice),2) AS depositosEnGarantiaDice, ROUND(SUM(depositosEnGarantiaDebeDecir),2) AS depositosEnGarantiaDebeDecir, ROUND(SUM(chequesNoCobradosDice),2) AS chequesNoCobradosDice, ROUND(SUM(chequesNoCobradosDebeDecir),2) AS chequesNoCobradosDebeDecir, ROUND(SUM(otrosDepositosDice),2) AS otrosDepositosDice, ROUND(SUM(otrosDepositosDebeDecir),2) AS otrosDepositosDebeDecir, ROUND(SUM(prestamosACargoDice),2) AS prestamosACargoDice, ROUND(SUM(prestamosACargoDebeDecir),2) AS prestamosACargoDebeDecir, ROUND(SUM(saldoNeto100Dice),2) AS saldoNeto100Dice, ROUND(SUM(saldoNeto100DebeDecir),2) AS saldoNeto100DebeDecir, ROUND(SUM(saldoNeto70Dice),2) AS saldoNeto70Dice, ROUND(SUM(saldoNeto70DebeDecir),2) AS saldoNeto70DebeDecir, ROUND(SUM(montoMaximoPagoDice),2) AS montoMaximoPagoDice, ROUND(SUM(montoMaximoPagoDebeDecir),2) AS montoMaximoPagoDebeDecir FROM modificacionesConsolidada WHERE nombreAhorradorDice NOT LIKE 'TOTAL%' AND modificaciones_idmodificaciones='".$idmodificaciones."'";
					$resSumas=mysql_query($sqlSumas);
					$filSumas=mysql_fetch_assoc($resSumas);

					foreach($filSumas as $campo => $valor)
					{
						if($filArch[$campo]!=$valor)
						{
							$cadenaError="La suma calculada de todos los registros en el campo  <strong>".$leyendasImportes[$campo]."</strong> de la base consolidada es $ ".separarMiles($valor)." y el archivo dice $ ".separarMiles($filArch[$campo]);
							echo "<span class='error'>".$cadenaError."</span><br>";
							guardaErrorModificacion($idmodificaciones,$cadenaError);
						}
					}
					//FIN VALIDO LAS SUMAS VERTICALES BIEN CALCULADAS//

					
				





						echo "<br><br>";
						//RECORRO TODA LA CONSOLIDADA
						$sql="SELECT * FROM modificacionesConsolidada WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorradorDice) NOT LIKE 'TOTAL%'";

						$foliosNoEncontradosString=implode(",",$foliosNoEncontrados);
						if(strlen($foliosNoEncontradosString)>0)
							$sql.=" AND folioIdentificador NOT IN(".$foliosNoEncontradosString.")";
						
						$res=mysql_query($sql);

						$diferenciaMontoMaximoPagoConvenio=0;

						while($modCon=mysql_fetch_assoc($res))
						{
							

							// VALIDO QUE EL NOMBRE DICE ESTE EN EL PADRON //
							if($modCon["observacionesDice"]!="ALTA")
							{								
								$sqlP="SELECT nombre FROM ahorrador WHERE folioIdentificador='".$modCon["folioIdentificador"]."'";
								$resP=mysql_query($sqlP);
								$filP=mysql_fetch_assoc($resP);
								if(strtoupper(trim($filP["nombre"]))!=strtoupper(trim($modCon["nombreAhorradorDice"])))
								{
									$erroresConsolidada++;
									$cadenaError="El folio ".$modCon["folioIdentificador"]." pertenece a  ".$filP["nombre"]." y el nombre en el archivo es ".$modCon["nombreAhorradorDice"];
									echo "<br>".$cadenaError."<br>";
									guardaErrorModificacion($idmodificaciones,$cadenaError);
								}
							}



							//VALIDO QUE EL MONTO QUE DICE SEA EL QUE ESTA EN EL PADRON
							if($modCon["observacionesDice"]!="ALTA")
							{
								$camposParaValidarDice=Array("parteSocialDice","cuentasDeAhorroDice","cuentaDeInversionDice","depositosEnGarantiaDice","chequesNoCobradosDice","otrosDepositosDice","prestamosACargoDice","saldoNeto100Dice","saldoNeto70Dice","montoMaximoPagoDice");
								$camposParaValidarDebeDice=Array("parteSocialDebeDecir","cuentasDeAhorroDebeDecir","cuentaDeInversionDebeDecir","depositosEnGarantiaDebeDecir","chequesNoCobradosDebeDecir","otrosDepositosDebeDecir","prestamosACargoDebeDecir","saldoNeto100DebeDecir","saldoNeto70DebeDecir","montoMaximoPagoDebeDecir");
								$camposPadron=Array("sps","sca","sci","sdg","scnc","sod","spc","montoAl100","montoAl70","montoMaximo");
								$leyendas=Array("parte social","cuenta de ahorro","cuenta de inversión","depósitos en garantía","cheques no cobrados","otros depósitos","préstamos a cargo","saldo neto al 100%","saldo neto al 70%","monto máximo de pago");

								foreach($camposParaValidarDebeDice as $indice => $campoParaValidarDebeDecir)
								{
									$campoParaValidarDice=$camposParaValidarDice[$indice];
									$campoPadron=$camposPadron[$indice];
									$leyenda=$leyendas[$indice];

									if($modCon[$campoParaValidarDebeDecir]!=0  || ($modCon[$campoParaValidarDebeDecir]==0 && $modCon[$campoParaValidarDice]!=0))
									{
										//Busco el campo en el padron
										$sqlP="SELECT ".$campoPadron." FROM ahorrador WHERE folioIdentificador='".$modCon["folioIdentificador"]."'";
										$resP=mysql_query($sqlP);
										$filP=mysql_fetch_row($resP);

										if($filP[0]!=$modCon[$campoParaValidarDice])
										{
											$cadenaError="El folio ".$modCon["folioIdentificador"]." en el campo ".$leyenda." es $".separarMiles($filP[0])." y el archivo dice $".separarMiles($modCon[$campoParaValidarDice]);
											echo "<br><span class='error'>".$cadenaError."</span><br>";
											guardaErrorModificacion($idmodificaciones,$cadenaError);
										}
									}
								}
							}






 
							$erroresEnCalculados=0;

							


							// BUSCO QUE LOS SALDOS ESTEN BIEN CALCULADOS EN EL DEBE DECIR //
							if($modCon["observacionesDice"]!="BAJA")
							{
									$montoAl100Calculado=$modCon["parteSocialDebeDecir"]+$modCon["cuentasDeAhorroDebeDecir"]+$modCon["cuentaDeInversionDebeDecir"]+$modCon["depositosEnGarantiaDebeDecir"]+$modCon["chequesNoCobradosDebeDecir"]+$modCon["otrosDepositosDebeDecir"]-$modCon["prestamosACargoDebeDecir"];
									$montoAl100Calculado=round($montoAl100Calculado,2);
									if($montoAl100Calculado!=$modCon["saldoNeto100DebeDecir"])
									{
										$cadenaError="El monto al 100% en DEBE DECIR del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoAl100Calculado)." y el archivo dice $".separarMiles($modCon["saldoNeto100DebeDecir"]);
										echo "<span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}

									$montoAl70Calculado=$montoAl100Calculado*0.70;
									$montoAl70Calculado=round($montoAl70Calculado,2);
									

									if($montoAl70Calculado!=$modCon["saldoNeto70DebeDecir"])
									{
										$cadenaError="El monto al 70% en DEBE DECIR  del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoAl70Calculado)." y el archivo dice $".separarMiles($modCon["saldoNeto70DebeDecir"]);
										echo "<br><span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}

									$montoMaximoCalculadoDebeDecir=$montoAl70Calculado;
									if($montoMaximoCalculadoDebeDecir>MONTO_MAXIMO_PAGO_70)
										$montoMaximoCalculadoDebeDecir=MONTO_MAXIMO_PAGO_70;

									if($montoMaximoCalculadoDebeDecir!=$modCon["montoMaximoPagoDebeDecir"])
									{
										$cadenaError="El monto máximo de pago DEBE DECIR del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoMaximoCalculadoDebeDecir)." y el archivo dice $".separarMiles($modCon["montoMaximoPagoDebeDecir"]);
										echo "<br><span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}
							}	
							//FIN BUSCO QUE LOS SALDOS ESTEN BIEN CALCULADOS EN EL DEBE DECIR //	
							echo "<br>";











							// BUSCO QUE LOS SALDOS ESTEN BIEN CALCULADOS EN EL DICE //
							if($modCon["observacionesDice"]!="ALTA")
							{
									$montoAl100Calculado=$modCon["parteSocialDice"]+$modCon["cuentasDeAhorroDice"]+$modCon["cuentaDeInversionDice"]+$modCon["depositosEnGarantiaDice"]+$modCon["chequesNoCobradosDice"]+$modCon["otrosDepositosDice"]-$modCon["prestamosACargoDice"];
									$montoAl100Calculado=round($montoAl100Calculado,2);
									if($montoAl100Calculado!=$modCon["saldoNeto100Dice"])
									{
										$cadenaError="El monto al 100% en DICE del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoAl100Calculado)." y el archivo dice $".separarMiles($modCon["saldoNeto100Dice"]);
										echo "<span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}

									$montoAl70Calculado=$montoAl100Calculado*0.70;
									$montoAl70Calculado=round($montoAl70Calculado,2);	
									

									if($montoAl70Calculado!=$modCon["saldoNeto70Dice"])
									{
										$cadenaError="El monto al 70% en DICE  del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoAl70Calculado)." y el archivo dice $".separarMiles($modCon["saldoNeto70Dice"]);
										echo "<br><span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}

									$montoMaximoCalculadoDice=$montoAl70Calculado;
									if($montoMaximoCalculadoDice>MONTO_MAXIMO_PAGO_70)
										$montoMaximoCalculadoDice=MONTO_MAXIMO_PAGO_70;

									if($montoMaximoCalculadoDice!=$modCon["montoMaximoPagoDice"])
									{
										$cadenaError="El monto máximo de pago DICE del folio <strong>".$modCon["folioIdentificador"]."</strong> calculado es $".separarMiles($montoMaximoCalculadoDice)." y el archivo dice $".separarMiles($modCon["montoMaximoPagoDice"]);
										echo "<br><span class='error'>".$cadenaError."</span>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
										$erroresEnCalculados=1;
									}
							}	
							//FIN BUSCO QUE LOS SALDOS ESTEN BIEN CALCULADOS EN EL DICE //	
							echo "<br>";
							










							if($modCon["observacionesDice"]!="ALTA" && $modCon["observacionesDice"]!="BAJA")				
							{
								$sqlP="SELECT montoMaximo,nombre FROM ahorrador WHERE folioIdentificador='".$modCon["folioIdentificador"]."'";
								$resP=mysql_query($sqlP);
								$filP=mysql_fetch_assoc($resP);

								$diferenciaMontoMaximoAhorrador=$montoMaximoCalculadoDebeDecir-$filP["montoMaximo"];
								echo "<br>La diferencia del ahorrador ".$filP["nombre"]." en el monto máximo de pago es de $ ".separarMiles(round($diferenciaMontoMaximoAhorrador,2));
								$diferenciaMontoMaximoPagoConvenio=$diferenciaMontoMaximoPagoConvenio+$diferenciaMontoMaximoAhorrador;
							}


							if($modCon["observacionesDice"]=="ALTA")
							{								
								echo "<br>Se dará de alta el ahorrador ".$modCon["nombreAhorradorDebeDecir"]." con un monto máximo de pago de $ ".separarMiles(round($montoMaximoCalculadoDebeDecir,2));
								$diferenciaMontoMaximoPagoConvenio=$diferenciaMontoMaximoPagoConvenio+$montoMaximoCalculadoDebeDecir;
							}

							if($modCon["observacionesDice"]=="BAJA" )
							{
								echo "<br>Se dará de baja el ahorrador ".$modCon["nombreAhorradorDice"]." con un monto máximo de pago de $ ".separarMiles(round($montoMaximoCalculadoDebeDecir,2));
								$diferenciaMontoMaximoPagoConvenio=$diferenciaMontoMaximoPagoConvenio-$montoMaximoCalculadoDebeDecir;
							}
							echo "<br>";



							
							if($modCon["observacionesDice"]=="ALTA")
							{

								//VERIFICO QUE LAS ALTAS NO TENGAN NADA EN EL DICE//
								$camposQueNoDebenTenerImporte=Array("parteSocialDice","cuentasDeAhorroDice","cuentaDeInversionDice","depositosEnGarantiaDice","chequesNoCobradosDice","otrosDepositosDice","prestamosACargoDice","saldoNeto100Dice","saldoNeto70Dice","montoMaximoPagoDice");
								$leyendasQueNoDebenTenerImporte=Array("DICE PARTE SOCIAL","DICE CUENTAS DE AHORRO","DICE CUENTAS DE INVERSIÓN","DICE DEPÓSITOS EN GARANTIA","DICE CHEQUES NO COBRADOS","DICE OTROS DEPÓSITOS","DICE PRÉSTAMOS A CARGO","DICE SALDO NETO AL 100%","DICE SALDO NETO AL 70%","DICE MONTO MÁXIMO DE PAGO");

								foreach($camposQueNoDebenTenerImporte as $indiceCamposQueNoDebenTenerImporte => $valorCamposQueNoDebenTenerImporte)
								{
									if($modCon[$valorCamposQueNoDebenTenerImporte]>0)
									{
										$cadenaError="El ahorrador ".$modCon["nombreAhorradorDebeDice"]." no debe contar con importe en el campo <strong>".$leyendasQueNoDebenTenerImporte[$indiceCamposQueNoDebenTenerImporte]."</strong> porque será dado de alta, el importe incorrecto es <strong>$ ".separarMiles($modCon[$valorCamposQueNoDebenTenerImporte])."</strong>";
										echo '<span class="error">'.$cadenaError."</span><br>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
									}
								}
								//VERIFICO QUE LAS ALTAS NO TENGAN NADA EN EL DICE//



								// VERIFICO QUE LAS ALTAS TENGAN BIEN EL FOLIO IDENTIFICADOR (SSSAAAAA)//
								$folioIdentificadorNuevo=trim($modCon["folioIdentificador"]); 
								if(strlen($folioIdentificadorNuevo)<8)
								{
									$cadenaError="El folio del ahorrador ".$modCon["nombreAhorradorDice"]." no cuenta con el formato correcto SSSAAAAA en la base consolidada";
									echo '<span class="error">'.$cadenaError."</span><br>";
									guardaErrorModificacion($idmodificaciones,$cadenaError);
								}
								else //Valido que la sociedad exista y este ligada al convenio $idconvenio
								{
									$sociedadNuevoAhorrador=substr ($folioIdentificadorNuevo,0 ,3);
									if(validaSociedadLigadaAlConvenio($sociedadNuevoAhorrador,$idconvenio)==false)
									{
										$cadenaError="El folio del ahorrador ".$modCon["nombreAhorradorDice"]." en la base consolidada indica la sociedad ".$sociedadNuevoAhorrador." la cual no tiene relación con el convenio elegido";
										echo '<span class="error">'.$cadenaError."</span><br>";
										guardaErrorModificacion($idmodificaciones,$cadenaError);
									}
								}
								// VERIFICO QUE LAS ALTAS TENGAN BIEN EL FOLIO IDENTIFICADOR (SSSAAAAA)//
							}
							


							// VALIDO QUE EL AHORRADOR NO ESTE DADO DE BAJA //
							if(ahorradorEstaBaja($modCon["folioIdentificador"]))
							{
								$erroresConsolidada++;
								$cadenaError="El folio ".$modCon["folioIdentificador"]." perteneciente a  ".dameNombreAhorrador($modCon["folioIdentificador"])." esta dado de baja, no puede ser modificado";
								echo "<br><span class='error'>".$cadenaError."</span><br>";
								guardaErrorModificacion($idmodificaciones,$cadenaError);
							}
							// VALIDO QUE EL AHORRADOR NO ESTE DADO DE BAJA //


					
						} // WHILE RECORRO TODA LA CONSOLIDADA //






	 				echo "<br><br>";
	 				// echo "LA DIFERENCIA EN EL MONTO DEL CONVENIO SERÍA: <strong>$ ".separarMiles($diferenciaMontoMaximoPagoConvenio)."</strong><br><br>";


	 				$cadenaError="";
	 				//Verifico que el monto por el cual se firmo el convenio alcance
	 				$sqlMontoTotalConvenio="SELECT montoTotalConvenio,montoMaximoPagoTotal FROM convenio WHERE idconvenio='".$idconvenio."'";
	 				$resMontoTotalConvenio=mysql_query($sqlMontoTotalConvenio);
	 				$filMontoTotalConvenio=mysql_fetch_assoc($resMontoTotalConvenio);
	 				$montoFirmadoDelConvenio=$filMontoTotalConvenio["montoTotalConvenio"];
	 				$montoMaximoPagoTotal=$filMontoTotalConvenio["montoMaximoPagoTotal"];

	 				if($diferenciaMontoMaximoPagoConvenio>0 && ($montoMaximoPagoTotal+$diferenciaMontoMaximoPagoConvenio)>$montoFirmadoDelConvenio) //No alcanza
	 				{	
	 					//$cadenaError="El monto máximo por el que se firmo el convenio es <strong>$ ".separarMiles($montoFirmadoDelConvenio)."</strong> y esta modificación necesita <strong>$ ".separarMiles($diferenciaMontoMaximoPagoConvenio+$montoMaximoPagoTotal)."</strong>";
						echo "Esta modificación a la base de datos es de: $".separarMiles($diferenciaMontoMaximoPagoConvenio)."<br>";
	 					echo "El monto máximo del convenio autorizado es: $".separarMiles($montoFirmadoDelConvenio)."<br>";
	 					echo "El nuevo monto máximo de pago es: $".separarMiles($diferenciaMontoMaximoPagoConvenio+$montoMaximoPagoTotal)."<br>";
						echo $cadenaError."<br><br><span class='error'>RECHAZADA</span><br>";
						guardaErrorModificacion($idmodificaciones,$cadenaError);
	 				}
	 				else
	 				{
	 					echo "Esta modificación a la base de datos es de: $".separarMiles($diferenciaMontoMaximoPagoConvenio)."<br>";
	 					echo "El monto máximo del convenio autorizado es: $".separarMiles($montoFirmadoDelConvenio)."<br>";
	 					echo "El nuevo monto máximo de pago es: $".separarMiles($diferenciaMontoMaximoPagoConvenio+$montoMaximoPagoTotal)."<br>";
	 					echo "<span class='exito'>SUCEPTIBLE DE SER APROBADA</span>";
	 					//echo "El monto máximo por el que se firmo el convenio es <strong>$ ".separarMiles($montoFirmadoDelConvenio)."</strong> y esta modificación necesita <strong>$ ".separarMiles($diferenciaMontoMaximoPagoConvenio+$montoMaximoPagoTotal)."</strong> <span class='exito'>SUCEPTIBLE DE SER APROBADA</span>";
	 				}
					?>
					<br>
					<br>
					<form id="formulario"  method="post">
						<input type="hidden" name="a" value="comenzarReporteAnalitica" />
						<br><br>
						<?php
							foreach($_REQUEST as $k => $v)
							{								
								if($k!="a" && $k!="PHPSESSID")
									echo "<input type='hidden' name='".$k."' value='".$v."' />";								
							}
						?>
						<input type="submit" value="Siguiente" class="botonRojo">
					</form>
				</fieldset>
			</div>			
		<?php
	}













	function comenzarReporteAnalitica()
	{

		global $_REQUEST,$mensaje;

		$erroresAanalitica=0;

		$idmodificaciones=$_REQUEST["idmodificaciones"];
		$idconvenio=$_REQUEST["idconvenio"];
		$erroresAnalitica=0;

		$fileD=$_REQUEST["fileD"];
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];
		
		$filaConsolidada=$_REQUEST["filaConsolidada"];
		$filaAnalitica=$_REQUEST["filaAnalitica"];
		
		$filaConsolidada2=$_REQUEST["filaConsolidada2"];
		$filaAnalitica2=$_REQUEST["filaAnalitica2"];		


		echo "<span class='subTitulos' style='font-weight:bold;'>Detalle del reporte de la base analítica</span>";
		?>			
		<div id='divDetalleErrores'>
			<fieldset class="fieldsetZht fieldSetReporte">
				<legend><strong>Reporte sobre la base de datos analítica</strong></legend>
				<br>
				<?php

					//BUSCO FOLIOS EN BLANCO
					$sql="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador='' AND estatus='DICE' AND observaciones IN('ALTA','BAJA')";
					$res=mysql_query($sql);
					echo "Folios en blanco en la base analítica: ".mysql_num_rows($res);
					if(mysql_num_rows($res)>0)
					{
						$cadenaError="Folios en blanco en la base analítica (".mysql_num_rows($res)."): ";
						$erroresAanalitica++;
						echo "<span class='botonMostrar' onclick='muestraOculta(\"divFoliosBlancosAnalitica\");' >Mostrar/Ocultar</span>";
						echo "<div class='oculta' id='divFoliosBlancosAnalitica'>";	
							echo "<ul>";									
								while($fil=mysql_fetch_assoc($res))
								{
									echo "<li>Fila: ".$fil["filaOriginalDocumento"]."</li>";
									$cadenaError.=$fil["filaOriginalDocumento"]." - ";
								}
							echo "</ul>";					
						echo "</div>";

						guardaErrorModificacion($idmodificaciones,$cadenaError);
					}
					//BUSCO FOLIOS EN BLANCO
					echo "<br><br>";




					//BUSCO QUE LOS FOLIOS QUE NO ESTEN EN EL CONVENIO
					$sql="SELECT folioIdentificador FROM modificacionesAnalitica WHERE UPPER(observaciones)<>'ALTA' AND folioIdentificador NOT IN(SELECT folioIdentificador FROM ahorrador INNER JOIN convenio_has_ahorrador ON idahorrador=ahorrador_idahorrador WHERE convenio_idconvenio='".$idconvenio."') AND modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>''";
					$res=mysql_query($sql);
					echo "Folios de la base analítica no econtrados en el convenio: ".mysql_num_rows($res);
					if(mysql_num_rows($res)>0)
					{
						$cadenaError="Folios de la base analítica no econtrados en el convenio (".mysql_num_rows($res)."): ";
						$erroresAanalitica++;
						echo "<span class='botonMostrar' onclick='muestraOculta(\"divFoliosNoEncontradosConsolidada\");' >Mostrar/Ocultar</span>";
						echo "<div class='oculta' id='divFoliosNoEncontradosConsolidada'>";	
							echo "<ul>";									
								while($fil=mysql_fetch_assoc($res))
								{
									echo "<li>".$fil["folioIdentificador"]."</li>";
									$cadenaError.=", ".$fil["folioIdentificador"];
								}
							echo "</ul>";					
						echo "</div>";

						guardaErrorModificacion($idmodificaciones,$cadenaError);
					}








					//BUSCO FOLIOS QUE NO ESTAN EN LA CONSOLIDADA
					$foliosNoEncontrados=Array();
					$sql="SELECT folioIdentificador FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>'' AND folioIdentificador NOT IN(SELECT folioIdentificador FROM modificacionesConsolidada WHERE modificaciones_idmodificaciones='".$idmodificaciones."') ";
					$res=mysql_query($sql);
					echo "<br><br>Folios que no se encuentran en la base consolidada: ".mysql_num_rows($res);
					if(mysql_num_rows($res)>0)
					{
						$cadenaError="Folios que no se encuentran en la base consolidada (".mysql_num_rows($res).")";
						$erroresAnalitica++;
						echo "<span class='botonMostrar' onclick='muestraOculta(\"divFoliosNoEncontradosAnalitica\");' >Mostrar/Ocultar</span>";
						echo "<div class='oculta' id='divFoliosNoEncontradosAnalitica'>";	
							echo "<ul>";									
								while($fil=mysql_fetch_assoc($res))
								{
									echo "<li>".$fil["folioIdentificador"]."</li>";
									$cadenaError.=", ".$fil["folioIdentificador"];
									if($fil["folioIdentificador"]!="")
										$foliosNoEncontrados[]=$fil["folioIdentificador"];
								}
							echo "</ul>";					
						echo "</div>";

						guardaErrorModificacion($idmodificaciones,$cadenaError);
					}









					echo "<br><br>";
					//RECORRO TODA LA ANALÍTICA
					$sql="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>'' ";
					
					$foliosNoEncontradosString=implode(",",$foliosNoEncontrados);
					if(strlen($foliosNoEncontradosString)>0)
						$sql.=" AND folioIdentificador NOT IN(".$foliosNoEncontradosString.")";
					

					$res=mysql_query($sql);
					while($modAna=mysql_fetch_assoc($res))
					{
						$erroresModificacionAnalitica=Array();
						if(strtoupper($modAna["estatus"])=="DICE" && strtoupper($modAna["observaciones"])!="ALTA")
						{
							$folioIdentificador=$modAna["folioIdentificador"];
							$erroresModificacionAnalitica=validaModificacionAnalitica($folioIdentificador,$modAna["idmodificacionesAnalitica"]);
							foreach($erroresModificacionAnalitica as $indice => $error)
								guardaErrorModificacion($idmodificaciones,$error);
							
							$filaInicial=$modAna["filaOriginalDocumento"];						

							$sqlF="SELECT * FROM modificacionesAnalitica WHERE filaOriginalDocumento>'".$filaInicial."' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>'' ";
							if(strlen($foliosNoEncontradosString)>0)
								$sqlF.=" AND folioIdentificador NOT IN(".$foliosNoEncontradosString.")";
							$resF=mysql_query($sqlF);
							$filF=mysql_fetch_assoc($resF);
							$filaFinal=$filF["filaOriginalDocumento"];

							$sqlModAna2="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."'  ";
							if(strlen($foliosNoEncontradosString)>0)
								$sqlModAna2.=" AND folioIdentificador NOT IN(".$foliosNoEncontradosString.")";
							$sqlModAna2.=" AND filaOriginalDocumento>'".$filaInicial."' AND filaOriginalDocumento<'".$filaFinal."'";
							
							$resModAna2=mysql_query($sqlModAna2);

							if(mysql_num_rows($resModAna2)>0) // TIENE FILAS ASOCIADAS
							{
								while($modAna2=mysql_fetch_assoc($resModAna2))
								{									
									$erroresModificacionAnalitica=validaModificacionAnalitica($folioIdentificador,$modAna2["idmodificacionesAnalitica"]);
									foreach($erroresModificacionAnalitica as $indice => $error)
										guardaErrorModificacion($idmodificaciones,$error);
								}
							}
						}

					} //WHILE TODA LA ANALITICA



					

					$totalesDice=Array("importePS"=>0, "importeCA"=>0, "importeCI"=>0, "importeDG"=>0, "importeCNC"=>0, "importeOD"=>0, "importePC"=>0, "saldoNeto100"=>0, "saldoNeto70"=>0, "montoMaximoPago"=>0);
					

					//SALDOS MAL CALCULADOS EN EL DICE 2.0//	
						$sql="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%' ORDER BY idmodificacionesAnalitica DESC";
						$res=mysql_query($sql);
						$fil=mysql_fetch_assoc($res);
						$ultimoRegistroRevision=$fil;

						$sql="SELECT * FROM modificacionesAnalitica WHERE folioIdentificador<>'' AND estatus='DICE' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%' ORDER BY idmodificacionesAnalitica";
						//echo $sql."<br>";
						$res=mysql_query($sql);
						while($fil=mysql_fetch_assoc($res))
						{
							$al100Calculado=0;
							$idAuxInicial=$fil["idmodificacionesAnalitica"];
							$alCienDice=$fil["saldoNeto100"];

							$al100Calculado=$fil["importePS"]+$fil["importeCA"]+$fil["importeCI"]+$fil["importeDG"]+$fil["importeCNC"]+$fil["importeOD"]-$fil["importePC"];
							//echo $sql."<br>";
							foreach($totalesDice as $campo => $valor)
							{
								$totalesDice[$campo]=$valor+$fil[$campo];
								//echo "sumo ".$valor." y ".$fil[$campo]." en ".$campo."<br>";
							}
							
							//PARA LAS FILAS ASOCIADAS
								$sql2="SELECT idmodificacionesAnalitica FROM modificacionesAnalitica WHERE folioIdentificador<>'' AND estatus='DEBE DECIR' AND idmodificacionesAnalitica>'".$idAuxInicial."' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica LIMIT 1";
								$res2=mysql_query($sql2);
								if(mysql_num_rows($res2)>0)
								{
									$fil2=mysql_fetch_assoc($res2);
									$idAuxFinal=$fil2["idmodificacionesAnalitica"];
									$sql3="SELECT * FROM modificacionesAnalitica WHERE idmodificacionesAnalitica>'".$idAuxInicial."' AND idmodificacionesAnalitica<'".$idAuxFinal."' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica";
									//echo $sql3."<br>";
									$res3=mysql_query($sql3);
									while($fil3=mysql_fetch_assoc($res3))
									{
										$al100Calculado+=$fil3["importePS"]+$fil3["importeCA"]+$fil3["importeCI"]+$fil3["importeDG"]+$fil3["importeCNC"]+$fil3["importeOD"]-$fil3["importePC"];
										foreach($totalesDice as $campo => $valor)
										{
											$totalesDice[$campo]=$valor+$fil3[$campo];
											//echo "sumo ".$valor." y ".$fil3[$campo]." en ".$campo."<br>";
										}
									}
								}
								else //YA NO HUBO SIGUIENTES AHORRADORES, EVALUO SI SOBRAN AÚN FILAS ASOCIADAS
								{
									//TRAIGO TODAS LAS FILAS "VACIAS" DE ADELANTE
									$sql3="SELECT * FROM modificacionesAnalitica WHERE folioIdentificador='' AND estatus='' AND idmodificacionesAnalitica>".$idAuxInicial." AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica";
									$res3=mysql_query($sql3);
									$consecutivo=$idAuxInicial;
									while($fil3=mysql_fetch_assoc($res3))
									{
										$consecutivo++;
										if($consecutivo==$fil3["idmodificacionesAnalitica"])
										{
											$al100Calculado+=$fil3["importePS"]+$fil3["importeCA"]+$fil3["importeCI"]+$fil3["importeDG"]+$fil3["importeCNC"]+$fil3["importeOD"]-$fil3["importePC"];
											foreach($totalesDice as $campo => $valor)
											{
												$totalesDice[$campo]=$valor+$fil3[$campo];
												//echo "sumo ".$valor." y ".$fil3[$campo]." en ".$campo."<br>";
											}
										}
										else
											break;
									}
								}								
							//PARA LAS FILAS ASOCIADAS

							




							$al100Calculado=round($al100Calculado,2);
							if($alCienDice!=$al100Calculado) //SON DIFERENTES
							{
								$cadenaError="El monto al 100% <strong>DICE</strong> del folio <strong>".$fil["folioIdentificador"]."</strong> en la base analítica dice <strong>$ ".separarMiles($alCienDice)."</strong> y el monto calculado es <strong>$ ".separarMiles($al100Calculado)."</strong>";
								echo "<span class='error'>".$cadenaError."</span><br>";
								guardaErrorModificacion($idmodificaciones,$cadenaError);
							}

						}
					//SALDOS MAL CALCULADOS EN EL DICE 2.0//
					echo "<br><br>";









					$totalesDebeDecir=Array("importePS"=>0, "importeCA"=>0, "importeCI"=>0, "importeDG"=>0, "importeCNC"=>0, "importeOD"=>0, "importePC"=>0, "saldoNeto100"=>0, "saldoNeto70"=>0, "montoMaximoPago"=>0);

					//SALDOS MAL CALCULADOS EN EL DEBE DECIR 2.0//					
						$sql="SELECT * FROM modificacionesAnalitica WHERE folioIdentificador<>'' AND estatus='DEBE DECIR' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica";
						//echo $sql."<br>";
						$res=mysql_query($sql);
						while($fil=mysql_fetch_assoc($res))
						{
							$al100Calculado=0;
							$idAuxInicial=$fil["idmodificacionesAnalitica"];
							$alCienDice=$fil["saldoNeto100"];

							$al100Calculado=$fil["importePS"]+$fil["importeCA"]+$fil["importeCI"]+$fil["importeDG"]+$fil["importeCNC"]+$fil["importeOD"]-$fil["importePC"];
							foreach($totalesDebeDecir as $campo => $valor)
							{
								$totalesDebeDecir[$campo]+=$fil[$campo];
							}


							//PARA LAS FILAS ASOCIADAS
								$sql2="SELECT idmodificacionesAnalitica FROM modificacionesAnalitica WHERE folioIdentificador<>'' AND estatus='DICE' AND idmodificacionesAnalitica>'".$idAuxInicial."' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica LIMIT 1";
								$res2=mysql_query($sql2);
								if(mysql_num_rows($res2)>0)
								{
									$fil2=mysql_fetch_assoc($res2);
									$idAuxFinal=$fil2["idmodificacionesAnalitica"];

									$sql3="SELECT * FROM modificacionesAnalitica WHERE idmodificacionesAnalitica>'".$idAuxInicial."' AND idmodificacionesAnalitica<'".$idAuxFinal."' AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica";
									$res3=mysql_query($sql3);
									while($fil3=mysql_fetch_assoc($res3))
									{
										$al100Calculado+=$fil3["importePS"]+$fil3["importeCA"]+$fil3["importeCI"]+$fil3["importeDG"]+$fil3["importeCNC"]+$fil3["importeOD"]-$fil3["importePC"];
										foreach($totalesDebeDecir as $campo => $valor)
										{
											if($campo!="saldoNeto100" && $campo!="saldoNeto70" && $campo!="montoMaximoPago")
												$totalesDebeDecir[$campo]+=$fil3[$campo];
										}
									}
								}
								else //YA NO HUBO SIGUIENTES AHORRADORES, EVALUO SI SOBRAN AÚN FILAS ASOCIADAS
								{
									//TRAIGO TODAS LAS FILAS "VACIAS" DE ADELANTE
									$sql3="SELECT * FROM modificacionesAnalitica WHERE folioIdentificador='' AND estatus='' AND idmodificacionesAnalitica>".$idAuxInicial." AND modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(nombreAhorrador) NOT LIKE 'TOTAL%'  ORDER BY idmodificacionesAnalitica";
									$res3=mysql_query($sql3);
									$consecutivo=$idAuxInicial;
									while($fil3=mysql_fetch_assoc($res3))
									{
										$consecutivo++;
										if($consecutivo==$fil3["idmodificacionesAnalitica"])
										{	
											$al100Calculado+=$fil3["importePS"]+$fil3["importeCA"]+$fil3["importeCI"]+$fil3["importeDG"]+$fil3["importeCNC"]+$fil3["importeOD"]-$fil3["importePC"];
											foreach($totalesDebeDecir as $campo => $valor)
											{
												if($campo!="saldoNeto100" && $campo!="saldoNeto70" && $campo!="montoMaximoPago")
													$totalesDebeDecir[$campo]+=$fil3[$campo];
											}
										}
										else
											break;
									}
								}		
							//PARA LAS FILAS ASOCIADAS



							$al100Calculado=round($al100Calculado,2);

							if($alCienDice!=$al100Calculado) //SON DIFERENTES
							{
								$cadenaError="El monto al 100% <strong>DEBE DECIR</strong> del folio <strong>".$fil["folioIdentificador"]."</strong> en la base analítica dice <strong>$ ".separarMiles($alCienDice)."</strong> y el monto calculado es <strong>$ ".separarMiles($al100Calculado)."</strong>";
								echo "<span class='error'>".$cadenaError."</span><br>";
								guardaErrorModificacion($idmodificaciones,$cadenaError);
							}

						}
						// $totalesDebeDecir["saldoNeto100"]=$totalesDebeDecir["importePS"]+$totalesDebeDecir["importeCA"]+$totalesDebeDecir["importeCI"]+$totalesDebeDecir["importeDG"]+$totalesDebeDecir["importeCNC"]+$totalesDebeDecir["importeOD"]-$totalesDebeDecir["importePC"];
						// $totalesDebeDecir["saldoNeto70"]=$totalesDebeDecir["saldoNeto100"]*0.70;

						// , "saldoNeto100"=>0, "saldoNeto70"=>0, "montoMaximoPago"=>0
					//SALDOS MAL CALCULADOS EN EL DEBE DECIR 2.0//









					

					// SUMAS VERTICALES DICE ANALITICA
					$leyendasImportes=Array("importePS"=>"Importe en parte social", "importeCA"=>"Importe en cuentas de ahorro", "importeCI"=>"Importe en cuentas de inversión", "importeDG"=>"Importe en depósitos en garantía", "importeCNC"=>"Importe en cheques no cobrados", "importeOD"=>"Importe en otros depósitos", "importePC"=>"Importe en préstamos a cargo", "saldoNeto100"=>"Saldo neto al 100% ", "saldoNeto70"=>"Saldo neto al 70%", "montoMaximoPago"=>"Monto máximo de pago");

					$sqlArch="SELECT * FROM modificacionesAnalitica WHERE UPPER(nombreAhorrador) LIKE 'TOTAL DICE%' AND modificaciones_idmodificaciones='".$idmodificaciones."'";
					//echo $sqlArch."<br>";
					$resArch=mysql_query($sqlArch);
					$filArch=mysql_fetch_assoc($resArch);
					foreach($totalesDice as $campo => $valor)
					{
						//echo "comparo ".ROUND($valor,2)." con ".ROUND($totalesDice[$campo],2)."<br>";
						if(ROUND($valor,2)!=ROUND($filArch[$campo],2))
						{
							$cadenaError="La suma calculada del campo ".$leyendasImportes[$campo]." en DICE de la base analítica es $ ".separarMiles(ROUND($valor))." y el archivo dice $ ".separarMiles(ROUND($filArch[$campo],2));
							echo "<span class='error'>".$cadenaError."</span><br>";
							guardaErrorModificacion($idmodificaciones,$cadenaError);
						}
					}
					// SUMAS VERTICALES DICE ANALITICA

					// SUMAS VERTICALES DEBE DECIR ANALITICA
					$sqlArch="SELECT * FROM modificacionesAnalitica WHERE UPPER(nombreAhorrador) LIKE 'TOTAL DEBE DECIR%' AND modificaciones_idmodificaciones='".$idmodificaciones."'";
					//echo $sqlArch."<br>";
					$resArch=mysql_query($sqlArch);
					$filArch=mysql_fetch_assoc($resArch);
					foreach($totalesDebeDecir as $campo => $valor)
					{
						if(ROUND($valor,2)!=ROUND($filArch[$campo],2))
						{
							$cadenaError="La suma calculada del campo ".$leyendasImportes[$campo]." en DEBE DECIR de la base analítica es $ ".separarMiles(ROUND($valor,2))." y el archivo dice $ ".separarMiles(ROUND($filArch[$campo],2));
							echo "<span class='error'>".$cadenaError."</span><br>";
							guardaErrorModificacion($idmodificaciones,$cadenaError);
						}
					}
					// SUMAS VERTICALES DEBE DECIR ANALITICA




					


				?>
				<br><br>
				<form  id="formulario" method="post">
					<input type="hidden" name="a" value="pideFolioYFecha" />
					<br><br>
					<?php
						foreach($_REQUEST as $k => $v)
						{								
							if($k!="a" && $k!="PHPSESSID")
								echo "<input type='hidden' name='".$k."' value='".$v."' />";								
						}
					?>
					<input type="submit" value="Siguiente" class="botonRojo">				
				</form>
			</fieldset>
		</div>
			<?php
	}


	function pideFolioYFecha()
	{
		global $_REQUEST,$mensaje;

		$erroresTotalesReporte=0;

		$idmodificaciones=$_REQUEST["idmodificaciones"];
		$idconvenio=$_REQUEST["idconvenio"];

		$KoolControlsFolder="../lib/KoolPHPSuite/KoolControls";

		require $KoolControlsFolder."/KoolAjax/koolajax.php";
		require $KoolControlsFolder."/KoolCalendar/koolcalendar.php";
		$koolajax->scriptFolder = "../lib/KoolPHPSuite/KoolControls/KoolAjax"; 	

		$datesSesion = new KoolDatePicker("fechaOficio"); //Create calendar object
		$datesSesion->scriptFolder = $KoolControlsFolder."/KoolCalendar";//Set scriptFolder
		$datesSesion->styleFolder="default";						 
		$datesSesion->Init();

		?>
		<form id="formulario" method="post">
			Folio del oficio: <input type="text" name="oficio" required>
			<br><br>
			Fecha de oficio: <?php echo $datesSesion->Render();?>
			<br><br>
			<?php
				foreach($_REQUEST as $k => $v)
				{								
					if($k!="a" && $k!="PHPSESSID")
						echo "<input type='hidden' name='".$k."' value='".$v."' />";								
				}
			?>
			<input type="submit" value="Continuar" class="botonRojoChico" >
			<input type="hidden" name="a" value="muestraResumenReporte" />
		</form>
		<br><br>
		<?php

	}


	function muestraResumenReporte()
	{
		global $_REQUEST,$mensaje;

		$erroresTotalesReporte=0;

		$idmodificaciones=$_REQUEST["idmodificaciones"];
		$idconvenio=$_REQUEST["idconvenio"];
		$erroresAnalitica=0;

		$fileD=$_REQUEST["fileD"];
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];
		
		$filaConsolidada=$_REQUEST["filaConsolidada"];
		$filaAnalitica=$_REQUEST["filaAnalitica"];
		
		$filaConsolidada2=$_REQUEST["filaConsolidada2"];
		$filaAnalitica2=$_REQUEST["filaAnalitica2"];

		$fechaOficio=$_REQUEST["fechaOficio"];	
		$oficio=$_REQUEST["oficio"];	


		$sqlFF="UPDATE modificaciones SET fechaSolicitud='".$fechaOficio."', folioSolicitud='".$oficio."' WHERE idmodificaciones='".$idmodificaciones."'";
		$resFF=mysql_query($sqlFF);

		$sqlErr="SELECT COUNT(*) AS total FROM erroresModificaciones WHERE  modificaciones_idmodificaciones='".$idmodificaciones."'";
		$resErr=mysql_query($sqlErr);
		$filErr=mysql_fetch_assoc($resErr);
		$erroresTotalesReporte=$filErr["total"];

		echo "<br><br>";
		echo "<span class='subTitulos' style='font-weight:bold; color:#ff0000;'>Resumen del reporte</span>";
		echo "<div id='divSoloErrores'>";
			echo "TOTAL DE ERRORES ENCONTRADOS: ".$erroresTotalesReporte."<br><br>";
			muestraErroresModificacion($idmodificaciones,1);			
		echo "</div>";
		echo "<br><br>";
		?>
		<form id="formulario" method="post">
			<?php
				foreach($_REQUEST as $k => $v)
				{								
					if($k!="a" && $k!="PHPSESSID")
						echo "<input type='hidden' name='".$k."' value='".$v."' />";								
				}
				if($erroresTotalesReporte==0 && $_REQUEST["readOnly"]!=1)
				{
					?>
					Al dar click en <strong>Continuar</strong> se se harán las modificaciones al convenio y al padrón de ahorradores
					<br><br>
					<input type="submit" value="Continuar" class="botonRojoChico" >
					<input type="hidden" name="a" value="comienzaActualizaciones" />
					<?php
				}
				else
				{
					?>
					<input type="button" value="Continuar" class="botonRojoChico" onclick="cargaModulo('modBas')">
					<?php
				}
			?>
		</form>
		<?php

	}









	function comienzaActualizaciones()
	{

		global $_REQUEST,$mensaje;

		$erroresTotalesReporte=0;


		$idmodificaciones=$_REQUEST["idmodificaciones"];
		$idconvenio=$_REQUEST["idconvenio"];
		$erroresAnalitica=0;

		$fileD=$_REQUEST["fileD"];
		$hojaConsolidada=$_REQUEST["hojaConsolidada"];
		$hojaAnalitica=$_REQUEST["hojaAnalitica"];
		
		$filaConsolidada=$_REQUEST["filaConsolidada"];
		$filaAnalitica=$_REQUEST["filaAnalitica"];
		
		$filaConsolidada2=$_REQUEST["filaConsolidada2"];
		$filaAnalitica2=$_REQUEST["filaAnalitica2"];

		$fechaOficio=$_REQUEST["fechaOficio"];	
		$oficio=$_REQUEST["oficio"];	



		//Actualizo el total de errores
		$sqlUp="UPDATE modificaciones SET errores='".$erroresTotalesReporte."' WHERE idmodificaciones='".$idmodificaciones."'";
		$resUp=mysql_query($sqlUp);


		//Comienzo a realizar las modificaciones en el padrón nacional de ahorradores
		if($erroresTotalesReporte==0)
		{
			$ahorradoresActualizados=0;

			//// MODIFICO SALDOS DE LA CONSOLIDADA TABLA ahorrador  ////
			$sqlMod="SELECT * FROM modificacionesConsolidada WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND (UPPER(observacionesDice) ='MODIFICACION' OR UPPER(observacionesDice) ='MODIFICACIÓN')";
			$resMod=mysql_query($sqlMod);
			while($filMod=mysql_fetch_assoc($resMod))
			{

				echo "<br>MODIFICANDO AL AHORRADOR <strong>".$filMod["nombreAhorradorDice"]."</strong> - ";
				
				$update="UPDATE ahorrador SET ";
				$updateArray=Array();
				
				//Traigo el ahorrador
				$sqlAho="SELECT * FROM ahorrador WHERE folioIdentificador='".$filMod["folioIdentificador"]."'";
				$resAho=mysql_query($sqlAho);
				$filAho=mysql_fetch_assoc($resAho);
				
				
				$updateArray[]="nombre='".$filMod["nombreAhorradorDebeDecir"]."'";
				$updateArray[]="sps='".$filMod["parteSocialDebeDecir"]."'";
				$updateArray[]="sca='".$filMod["cuentasDeAhorroDebeDecir"]."'";
				$updateArray[]="sci='".$filMod["cuentaDeInversionDebeDecir"]."'";
				$updateArray[]="sdg='".$filMod["depositosEnGarantiaDebeDecir"]."'";
				$updateArray[]="scnc='".$filMod["chequesNoCobradosDebeDecir"]."'";
				$updateArray[]="sod='".$filMod["otrosDepositosDebeDecir"]."'";
				$updateArray[]="spc='".$filMod["prestamosACargoDebeDecir"]."'";
				$updateArray[]="montoAl100='".$filMod["saldoNeto100DebeDecir"]."'";
				$updateArray[]="montoAl70='".$filMod["saldoNeto70DebeDecir"]."'";
				$updateArray[]="montoMaximo='".$filMod["montoMaximoPagoDebeDecir"]."'";

				$update.=implode(",",$updateArray);
				$update.=" WHERE folioIdentificador='".$filMod["folioIdentificador"]."'";

				
				if($resUpdate=mysql_query($update))
				{
					$ahorradoresActualizados++;
					echo "<span class='exito'> CORRECTO </span><br>";

					// ANTES DEL UPDATE TODO LO ANTERIOR VIENE EN $filAho //
					//echo "<br>guardando el historico del ahorrador<br>";

					guardaHistorialAhorradorConsolidada($filAho);

					// MOSTRAMOS LO QUE DECIA Y LO QUE AHORA ES
					muestraAntesYDespuesAhorradorConsolidada($filAho,$filMod["folioIdentificador"]);
				}
				else
				{
					echo "<span class='error'> OCURRIÓ UN ERROR AL MODIFICAR EL AHORRADOR </span>";
					echo "<br>".$update."<br>";
				}

				echo "<br>";				
			}
			//// MODIFICO SALDOS DE LA CONSOLIDADA TABLA ahorrador  ////








			
			// TRAIGO TODAS LAS ALTAS TABLA ahorrador //			
			$sqlMod="SELECT * FROM modificacionesConsolidada WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(observacionesDice) LIKE '%ALTA%'";
			$resMod=mysql_query($sqlMod);
			while($filMod=mysql_fetch_assoc($resMod))
			{
				//Sociedad del nuevo ahorrador
				$claveSociedadFinal=$filMod["folioIdentificador"];
				$claveSociedadFinal=substr($claveSociedadFinal,0,3);
				

				//$idconvenio;
				//Armo el folio
				$sqlAux="SELECT * FROM ahorrador INNER JOIN convenio_has_ahorrador ON ahorrador_idahorrador=idahorrador WHERE convenio_idconvenio='".$idconvenio."' LIMIT 1";
				$resAux=mysql_query($sqlAux);
				$filAux=mysql_fetch_assoc($resAux);
				$parteInicialFolio=$filAux["folioIdentificador"];
				$parteInicialFolio= substr ($parteInicialFolio,0,9);

				
				$claveEstado=substr($parteInicialFolio,0,2);
				$etapaConvenio=substr($parteInicialFolio,5,4);


				$sqlAux="SELECT COUNT(*) AS total FROM ahorrador INNER JOIN convenio_has_ahorrador ON ahorrador_idahorrador=idahorrador WHERE convenio_idconvenio='".$idconvenio."'";
				$resAux=mysql_query($sqlAux);
				$filAux=mysql_fetch_assoc($resAux);
				$consecutivo=$filAux["total"]+1;

				if($consecutivo<=9)
					$consecutivoTexto="0000".$consecutivo;
				else if($consecutivo<=99)
					$consecutivoTexto="000".$consecutivo;
				else if($consecutivo<=999)
					$consecutivoTexto="00".$consecutivo;
				else if($consecutivo<=9999)
					$consecutivoTexto="0".$consecutivo;

				
				$folioIdentificador=$claveEstado.$claveSociedadFinal.$etapaConvenio.$consecutivoTexto;
				
				$sql="INSERT INTO ahorrador (folioIdentificador, nombre, montoAl100, montoAl70, montoMaximo, sca, sci, sps, sdg, scnc, spc, sod ) VALUES ('".$folioIdentificador."', '".$filMod["nombreAhorradorDebeDecir"]."', '".$filMod["saldoNeto100DebeDecir"]."', '".$filMod["saldoNeto70DebeDecir"]."', '".$filMod["montoMaximoPagoDebeDecir"]."', '".$filMod["cuentasDeAhorroDebeDecir"]."', '".$filMod["cuentaDeInversionDebeDecir"]."', '".$filMod["parteSocialDebeDecir"]."', '".$filMod["depositosEnGarantiaDebeDecir"]."', '".$filMod["chequesNoCobradosDebeDecir"]."', '".$filMod["prestamosACargoDebeDecir"]."', '".$filMod["otrosDepositosDebeDecir"]."') ";
				echo "<br>INSERTANDO AL CONVENIO A: ".$filMod["nombreAhorradorDebeDecir"]." - ";

				if($res=mysql_query($sql))
				{
					$ahorradoresActualizados++;

					$idahorrador=mysql_insert_id();
					$sqlAux="INSERT INTO convenio_has_ahorrador (convenio_idconvenio,ahorrador_idahorrador) VALUES ('".$idconvenio."','".$idahorrador."')";
					$resAux=mysql_query($sqlAux);

					echo "<span class='exito'> CORRECTO </span>";
				}
				else
					echo "<span class='error'> OCURRIÓ UN ERROR AL MODIFICAR EL AHORRADOR </span>";










				// COMIENZO A INSERTAR LA ANALÍTICA EL NUEVO AHORRADOR $filMod["folioIdentificador"]  $folioIdentificador //
				$tablasInsert=Array('ahorradorParteSocial','ahorradorCuentasAhorro','ahorradorCuentasInversion','ahorradorOtrosDepositos','ahorradorDepositosGarantia','ahorradorChequesNoCobrados','ahorradorPrestamosCargo');
	    		
	    		$camposLectura[]=Array('tipoDocumentoPS','folioPS','importePS');
	    		$camposLectura[]=Array('tipoDocumentoCA','folioCA','importeCA');
	    		$camposLectura[]=Array('tipoDocumentoCI','folioCI','importeCI');
	    		$camposLectura[]=Array('tipoDocumentoOtros','folioOtros','importeOtros');
	    		$camposLectura[]=Array('tipoDocumentoDG','folioDG','importeDG');
	    		$camposLectura[]=Array('tipoDocumentoCNC','folioCNC','importeCNC');	    		
	    		$camposLectura[]=Array('tipoDocumentoPrestamos','folioPrestamos','importePrestamos');
	    	
				$sqlSearchAn="SELECT * FROM modificacionesAnalitica WHERE folioIdentificador='".$filMod["folioIdentificador"]."' AND estatus='DICE' AND modificaciones_idmodificaciones='".$idmodificaciones."'";
				$resSearchAn=mysql_query($sqlSearchAn);
				while($filSearchAn=mysql_fetch_assoc($resSearchAn))
				{
					
					//HAGO EL PRIMER INSERT
					foreach($tablasInsert as $indice => $tablaInsert)
		    		{
		    			if($filSearchAn[$camposLectura[$indice][2]]!=0)
		    			{
		    				$sqlIA="INSERT INTO ".$tablaInsert." (tipoDocumento,folio,importe,ahorrador_idahorrador) VALUES ('".$filSearchAn[$camposLectura[$indice][0]]."','".$filSearchAn[$camposLectura[$indice][1]]."','".$filSearchAn[$camposLectura[$indice][2]]."','".$idahorrador."')";
		    				$resIA=mysql_query($sqlIA);
		    				if(!$resIA)
		    				{
		    					echo "error al dar de alta analitica: <br>".$sqlIA."<br>".mysql_error();
		    					die;
		    				}
		    			}
		    		}
		    		//FIN DE HAGO EL PRIMER INSERT

		    		//BUSCO SI TIENE FILAS SIGUIENTES
		    			$filaOriginalDocumentoInicial=$filSearchAn["filaOriginalDocumento"];
			    		$sqlA="SELECT filaOriginalDocumento FROM modificacionesAnalitica WHERE nombreAhorrador<>'' AND filaOriginalDocumento>'".$filaDocumentoOriginalInicial."' AND modificaciones_idmodificaciones='".$idmodificaciones."' ORDER BY filaOriginalDocumento ASC LIMIT 1";
			    		$resA=mysql_query($sqlA);
			    		$filA=mysql_fetch_assoc($resA);
			    		$filaOriginalDocumentoFinal=$filA["filaOriginalDocumento"];
			    		

			    		$sqlA="SELECT * FROM modificacionesAnalitica WHERE nombreAhorrador='' AND filaOriginalDocumento>'".$filaOriginalDocumentoInicial."' AND filaOriginalDocumento<'".$filaOriginalDocumentoFinal."' AND modificaciones_idmodificaciones='".$idmodificaciones."' ORDER BY filaOriginalDocumento";
			    		$resA=mysql_query($sqlA);
			    		while($filA=mysql_fetch_assoc($resA))
			    		{
			    			//HAGO TODOS LOS DEMAS INSERTS
								foreach($tablasInsert as $indice => $tablaInsert)
					    		{
					    			if($filA[$camposLectura[$indice][2]]!=0)
					    			{
					    				$sqlIA="INSERT INTO ".$tablaInsert." (tipoDocumento,folio,importe,ahorrador_idahorrador) VALUES ('".$filSearchAn[$camposLectura[$indice][0]]."','".$filSearchAn[$camposLectura[$indice][1]]."','".$filSearchAn[$camposLectura[$indice][2]]."','".$idahorrador."')";
					    				$resIA=mysql_query($sqlIA);
					    			}
					    		}
			    			//HAGO TODOS LOS DEMAS INSERTS
			    		}
		    		//FIN DE BUSCO SI TIENE FILAS SIGUIENTES

				}
				// FIN DE INSERTAR LA ANALÍTICA EL NUEVO AHORRADOR //
				echo "<br>";
			}// FIN DE TRAIGO TODAS LAS ALTAS TABLA ahorrador //














			// TRAIGO TODAS LAS BAJAS TABLA ahorrador//
			$sqlMod="SELECT * FROM modificacionesConsolidada WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND UPPER(observacionesDice) LIKE '%BAJA%'";
			$resMod=mysql_query($sqlMod);
			while($filMod=mysql_fetch_assoc($resMod))
			{
				echo "<br>DANDO DE BAJA AHORRADOR: ".$filMod["nombreAhorradorDice"];
				

				//GUARDO EN EL HISTÓRICO LOS MONTOS ACTUALES
				$sqlAho="SELECT * FROM ahorrador WHERE folioIdentificador='".$filMod["folioIdentificador"]."'";
				$resAho=mysql_query($sqlAho);
				$filAho=mysql_fetch_assoc($resAho);
				guardaHistorialAhorradorConsolidada($filAho);
				//FIN DE GUARDO EN EL HISTÓRICO LOS MONTOS ACTUALES


				//PONGO TODOS SUS MONTOS EN CERO
				$sql="UPDATE ahorrador SET montoAl100=0, montoAl70=0, montoMaximo=0, sca=0, sci=0, sps=0, sdg=0, scnc=0, spc=0, sod=0 WHERE folioIdentificador='".$filMod["folioIdentificador"]."'";
				//echo $sql."<br>";
				$res=mysql_query($sql);
				// if(!$res)
				// {
				// 	echo mysql_error()."<br>";
				// 	die;
				// }

				$sql="UPDATE ahorrador SET baja=1 WHERE folioIdentificador='".$filMod["folioIdentificador"]."'";
				if($res=mysql_query($sql))
				{
					$ahorradoresActualizados++;
					echo "<span class='exito'> CORRECTO </span>";
				}
				else
					echo "<span class='error'> OCURRIÓ UN ERROR AL MODIFICAR EL AHORRADOR </span>";
			}
			// TRAIGO TODAS LAS BAJAS TABLA ahorrador//

			echo "<br><br><br>";
			echo "<div class='separador'></div>";










			$camposFolios=Array("folioPS","folioCA","folioCI","folioDG","folioCNC","folioOD","folioPC");
			$tiposDocumentos=Array("tipoDocumentoPS","tipoDocumentoCA","tipoDocumentoCI","tipoDocumentoDG","tipoDocumentoCNC","tipoDocumentoOD","tipoDocumentoPC");
			$importes=Array("importePS","importeCA","importeCI","importeDG","importeCNC","importeOD","importePC");
			$tablas=Array("ahorradorParteSocial","ahorradorCuentasAhorro","ahorradorCuentasInversion","ahorradorDepositosGarantia","ahorradorChequesNoCobrados","ahorradorOtrosDepositos","ahorradorPrestamosCargo");
			$leyendasA=Array("parte social","cuentas de ahorro","cuentas de inversión","depósitos en garantía","cheques no cobrados","otros depósitos","prestamos a cargo");
			$idTablas=Array("idahorradorParteSocial","idahorradorCuentasAhorro","idahorradorCuentasInversion","idahorradorDepositosGarantia","idahorradorChequesNoCobrados","idahorradorOtrosDepositos","idahorradorPrestamosCargo");
			$tablasHistoricosAnalitica=Array("historicoAhorradorParteSocial","historicoAhorradorCuentasAhorro","historicoAhorradorCuentasInversion","historicoAhorradorDepositosGarantia","historicoAhorradorChequesNoCobrados","historicoAhorradorOtrosDepositos","historicoAhorradorPrestamosCargo");


			// ACTUALIZACION DE LA BASE ANALITICA //
			$sqlAn="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND folioIdentificador<>'' AND estatus='DICE' AND observaciones<>'ALTA'";
			$resAn=mysql_query($sqlAn);
			while($filAn=mysql_fetch_assoc($resAn))
			{
				$idInicial=$filAn["idmodificacionesAnalitica"];

				$sqlAn2="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND (folioIdentificador<>'' OR observaciones='ALTA') AND estatus='DICE' AND idmodificacionesAnalitica>".$idInicial;
				$resAn2=mysql_query($sqlAn2);
				if(mysql_num_rows($resAn2)>0)
				{	
					$filAn2=mysql_fetch_assoc($resAn2);
					$idFinal=$filAn2["idmodificacionesAnalitica"]-1;
				}
				else
					$idFinal=$idInicial+1;


				// echo "el inicial: ".$idInicial."<br>";
				// echo "el final: ".$idFinal."<br>";

				$sqlAhorradorCompleto="SELECT * FROM modificacionesAnalitica WHERE modificaciones_idmodificaciones='".$idmodificaciones."' AND idmodificacionesAnalitica>='".$idInicial."' AND idmodificacionesAnalitica<='".$idFinal."'";
				//echo $sqlAhorradorCompleto."<br>";
				$resAhorradorCompleto=mysql_query($sqlAhorradorCompleto);


				while($filAhorradorCompleto=mysql_fetch_assoc($resAhorradorCompleto))
				{
					if($filAhorradorCompleto["estatus"]=='DICE')					
						$banderaAuxiliar="DICE";
					if($filAhorradorCompleto["estatus"]=='DEBE DECIR')					
						$banderaAuxiliar="DEBE DECIR";
					
					if($filAhorradorCompleto["estatus"]=='DICE' || $banderaAuxiliar=="DICE")
					{
						$filAhorradorCompleto["estatus"]="DICE";
						$ahorradoresAnalitica[$filAn["folioIdentificador"]]["dice"][]=$filAhorradorCompleto;
					}

					else if($filAhorradorCompleto["estatus"]=='DEBE DECIR' || $banderaAuxiliar=="DEBE DECIR")
					{
						$filAhorradorCompleto["estatus"]="DEBE DECIR";
						$ahorradoresAnalitica[$filAn["folioIdentificador"]]["debedecir"][]=$filAhorradorCompleto;						
					}
				}
			}


			// echo "DICE: <br>";
			// echo "<pre>";
			// print_r($ahorradoresAnalitica["09035200000002"]["dice"]);
			// echo "</pre>";


			// echo "DEBE DECIR: <br>";
			// echo "<pre>";
			// print_r($ahorradoresAnalitica["09035200000002"]["debedecir"]);
			// echo "</pre>";






			
			// AQUI YA TENGO TODOS LOS AHORRADORES EN UN ARREGLO $ahorradoresAnalitica//
			
			echo "COMIENZA LA ACTUALIZACIÓN DE LA BASE ANALÍTICA";
			echo "<div class='separador'></div>";

			//GUARDO LOS HISTÓRICOS ANALITICOS DE LOS AHORRADORES Y LOS BORRO YA DE LA TABLA
			guardaHistoricoAnalitica($ahorradoresAnalitica);


			// INSERTO TODO EL DEBE DECIR  //
			foreach($ahorradoresAnalitica as $k => $v)
			{
				$folioIdentificador=$k;
				$idahorrador=dameIdAhorrador($folioIdentificador);

				echo "MODIFICANDO EL DETALLE (BASE ANALÍTICA) EL AHORRADOR: <strong>".dameNombreAhorrador($folioIdentificador)."</strong> (".$folioIdentificador.")<br>";

				// $diceArr=$v["dice"];
				$debedecirArr=$v["debedecir"];
				
				// echo "<pre>";
				// print_r($debedecirArr);
				// echo "</pre>";
				// echo "<br>";
				

				foreach($debedecirArr as $indice => $debeDecir)
				{
					if($debeDecir["estatus"]=="DEBE DECIR")
					{
						foreach($camposFolios as $indiceCampos => $folio)
						{
							$tabla=$tablas[$indiceCampos];
							$idTabla=$idTablas[$indiceCampos];					
							$tipoDocumento=$debeDecir[$tiposDocumentos[$indiceCampos]];
							$folio=$debeDecir[$camposFolios[$indiceCampos]];
							$importe=$debeDecir[$importes[$indiceCampos]];

							if($importe>0)
							{
								$sqlInsertNew="INSERT INTO ".$tabla." (tipoDocumento, folio, importe, ahorrador_idahorrador) VALUES ('".$tipoDocumento."','".$folio."','".$importe."','".$idahorrador."')";
								//echo $sqlInsertNew."<br>";
								$resInsertNew=mysql_query($sqlInsertNew);
								if(!$resInsertNew)
									echo "<br>".$sqlInsertNew."<br>error:<br>".mysql_error()."<br>";
								else
								{
									echo "<span class='exito'>SE REGISTRÓ EL DOCUMENTO <strong>".$tipoDocumento."</strong> CON FOLIO <strong>".$folio."</strong> y monto <strong>$ ".separarMiles($importe)."</strong></span><br>";
								}
							}
						}
					}
				}
				echo "<br><br>";
				echo "<div class='separador'></div>";
			}
			// FIN INSERTO TODO EL DEBE DECIR //







			echo "<br><br>";
			// RECALCULO TODO EL CONVENIO CON LA TABLA ahorrador //
			$sqlConv="SELECT SUM(montoMaximo) AS total FROM ahorrador INNER JOIN convenio_has_ahorrador ON ahorrador_idahorrador=idahorrador WHERE convenio_idconvenio='".$idconvenio."'";
			$resConv=mysql_query($sqlConv);
			$filConv=mysql_fetch_assoc($resConv);
			$montoMaximoTotal=$filConv["total"];


			$montoMaximoDePagoEstado=$montoMaximoTotal*1.00/2.75;
			$montoMaximoDePagoEstado=round($montoMaximoDePagoEstado,2);

			$montoMaximoDePagoFipago=$montoMaximoTotal*1.75/2.75;
			$montoMaximoDePagoFipago=round($montoMaximoDePagoFipago,2);

			
			$sqlCon="UPDATE convenio SET montoMaximoPagoTotal='".$montoMaximoTotal."', montoMaximoPagoEstado='".$montoMaximoDePagoEstado."', montoMaximoPagoFipago='".$montoMaximoDePagoFipago."' WHERE idconvenio='".$idconvenio."'";
			
			if($resCon=mysql_query($sqlCon))
			{
				echo "<span class='exito'> EL CONVENIO FUE ACTUALIZADO CORRECTAMENTE </span>";
				echo "<br><br>";
				echo "Monto máximo de pago del convenio: $".separarMiles(round($montoMaximoTotal,2))."<br>";
				echo "<br>";
				echo "Monto máximo de pago del convenio del estado: $".separarMiles(round($montoMaximoDePagoEstado,2))."<br>";
				echo "<br>";
				echo "Monto máximo de pago del convenio de FIPAGO: $".separarMiles(round($montoMaximoDePagoFipago,2))."<br>";
			}
			
			else
				echo "<span class='error'> OCURRIÓ UN ERROR AL ACTUALIZAR EL CONVENIO </span><br>".$sqlCon."<br>".mysql_error()."<br>";

			echo "<br>";

			//echo "<strong>TOTAL DE AHORRADORES ACTUALIZADOS: ".$ahorradoresActualizados."</strong>";
			//echo "<br><br>";
			// RECALCULO TODO EL CONVENIO CON LA TABLA ahorrador //




			// ACTUALIZO LA MODIFICACION COMO APLICADA
			$sqlFinal="UPDATE modificaciones SET aplicada=1 WHERE idmodificaciones='".$idmodificaciones."'";
			$resFinal=mysql_query($sqlFinal);

		}

		?>
		<input type="button" value="Continuar" class="botonRojoChico" onclick="cargaModulo('modBas')">
		<?php
	}




	function eliminaError()
	{
		global $_REQUEST;

		$iderroresRevisiones=$_REQUEST["id"];

		$sql="SELECT * FROM erroresRevisiones WHERE iderroresRevisiones='".$iderroresRevisiones."'";
		$res=mysql_query($sql);
		$fil=mysql_fetch_assoc($res);
		$idrevisionesTemporales=$fil["revisionesTemporales_idrevisionesTemporales"];

		$sql="DELETE FROM erroresRevisiones WHERE iderroresRevisiones='".$iderroresRevisiones."'";
		$res=mysql_query($sql);

		//Recalculo los errores
		$sqlErr="SELECT COUNT(*) AS total FROM erroresRevisiones WHERE  revisionesTemporales_idrevisionesTemporales='".$idrevisionesTemporales."'";
		$resErr=mysql_query($sqlErr);
		$filErr=mysql_fetch_assoc($resErr);
		$totalErrores=$filErr["total"];


		$sqlUp="UPDATE revisionesTemporales SET totalErrores='".$totalErrores."' WHERE idrevisionesTemporales='".$idrevisionesTemporales."'";
		$resUpd=mysql_query($sqlUp);

		$_REQUEST["idrevisionesTemporales"]=$idrevisionesTemporales;
		muestraResumenReporte();
	}



?>





