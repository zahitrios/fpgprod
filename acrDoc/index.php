<?php

	session_start();
	include_once ("../conf/functions.php");
	validarSession();
	$_SESSION["language_select"] = "es";

	$KoolControlsFolder="../lib/KoolPHPSuite/KoolControls";
	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";


	$koolajax->scriptFolder = "../lib/KoolPHPSuite/KoolControls/KoolAjax"; 	

	$link=conectDBReturn();
	$ds = new MySQLDataSource($link);
	
	$ds->SelectCommand = "SELECT * FROM tipoDocumentoIdentidad ORDER BY idtipoDocumentoIdentidad ASC";

	$ds->UpdateCommand = "UPDATE tipoDocumentoIdentidad SET descripcion='@descripcion' WHERE idtipoDocumentoIdentidad=@idtipoDocumentoIdentidad";
	//$ds->DeleteCommand = "";
	$ds->InsertCommand = "INSERT INTO tipoDocumentoIdentidad (descripcion) VALUES ('@descripcion')";
 	
 	$grid = new KoolGrid("grid");

	$grid->scriptFolder="../lib/KoolPHPSuite/KoolControls/KoolGrid";
	$grid->styleFolder="../lib/KoolPHPSuite/KoolControls/KoolGrid/styles/office2010blue"; 

	$grid->AjaxEnabled = true;
	$grid->AjaxLoadingImage =  "../lib/KoolPHPSuite/KoolControls/KoolAjax/loading/5.gif";	
	$grid->DataSource = $ds;
	$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
	$grid->Width = "860px";
	$grid->ColumnWrap = true;
	$grid->PageSize  = 40;
	$grid->AllowEditing = true;
	$grid->AllowDeleting = false;
	$grid->AllowResizing = true;
	$grid->MasterTable->ShowFunctionPanel = true;	
	
	
	$column = new GridBoundColumn();
	$column->HeaderText = "Id";
	$column->DataField = "idtipoDocumentoIdentidad";
	$column->ReadOnly = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->HeaderText = "Descripción";
	$column->DataField = "descripcion";
	$grid->MasterTable->AddColumn($column);

	$grid->AutoGenerateEditColumn = true;
	
	$column = new GridEditDeleteColumn();
	
	//$grid->MasterTable->AllowFiltering = true;

	$grid->Localization->Load("../lib/KoolPHPSuite/KoolControls/KoolGrid/localization/es.xml");
	$grid->Process();
?>

<html>
	<head>
		<title>FIPAGO - Acreditación de documentos</title>
		<meta charset="UTF-8">

		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../styles.css">		

		<script text="javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script text="javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

		<script language="javascript" src="../functions.js"></script>

	</head>


	<body>
		
		<div id="menuLateral">
			<img src="<?php echo RUTA; ?>img/logo.jpg" style="width:100%;">
			<div class="itemMenu" onclick="cargaModulo('home');">Inicio</div>
				<?php
					cargaModulos();
				?>
			<div class="itemMenu" onclick="cargaModulo('logout');">Salir</div>
		</div>



		<div id="containerPrincipal">
				
				<div class='titulos'>Acreditación de documentos</div>
				<div class='usuarioLogueado'><?php echo nombreUsuarioLogeado(); ?></div>
				<div style="clear:both;"></div>	


				<div class="tablaCentrada">
					<form id="form1" method="post">				

						<?php 
							echo $koolajax->Render();
							echo $grid->Render();
						?>

					</form>
				</div>

		</div>
		<div style="clear:both;"></div>
		
	</body>

</html>