<?php

	session_start();
	include_once ("../conf/functions.php");
	validarSession();
	ob_start();

	$_SESSION["language_select"] = "es";

	$KoolControlsFolder="../lib/KoolPHPSuite/KoolControls";

	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";


	$koolajax->scriptFolder = "../lib/KoolPHPSuite/KoolControls/KoolAjax"; 	

	$link=conectDBReturn();
	$ds = new MySQLDataSource($link);
	
	$ds->SelectCommand = "SELECT * FROM bancos ORDER BY idbancos ASC";
	$ds->UpdateCommand = "UPDATE bancos SET nombre='@nombre',nombreCorto='@nombreCorto' WHERE idbancos=@idbancos";
	//$ds->DeleteCommand = "";
	$ds->InsertCommand = "INSERT INTO bancos (nombre,nombreCorto) VALUES ('@nombre','@nombreCorto')";
 	
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
	$grid->AllowFiltering = true;

	$grid->MasterTable->ShowFunctionPanel = true;	
	
	
	$column = new GridBoundColumn();
	$column->HeaderText = "Id";
	$column->DataField = "idbancos";
	$column->Width = "50px";
	$column->ReadOnly = true;
	$column->AllowSorting = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->HeaderText = "Nombre corto";
	$column->DataField = "nombreCorto";
	$column->AllowSorting = true;
	$grid->MasterTable->AddColumn($column);

	$column = new GridBoundColumn();
	$column->HeaderText = "Nombre";
	$column->DataField = "nombre";
	$column->AllowSorting = true;
	$grid->MasterTable->AddColumn($column);



	$grid->AutoGenerateEditColumn = true;
	
	$column = new GridEditDeleteColumn();
	
	//$grid->MasterTable->AllowFiltering = true;

	$grid->Localization->Load("../lib/KoolPHPSuite/KoolControls/KoolGrid/localization/es.xml");
	$grid->Process();

	if(isset($_POST["IgnorePaging"]))
	{
		$grid->ExportSettings->IgnorePaging = true;
	}
	
	if(isset($_POST["ExportToExcel"]))
	{
		ob_end_clean();
		$grid->GetInstanceMasterTable()->ExportToExcel();
	}	
	if(isset($_POST["ExportToWord"]))
	{
		ob_end_clean();
		$grid->GetInstanceMasterTable()->ExportToWord();
	}	
	if(isset($_POST["ExportToCSV"]))
	{
		ob_end_clean();
		$grid->GetInstanceMasterTable()->ExportToCSV();
	}
	if(isset($_POST["ExportToPDF"]))
	{
		ob_end_clean();
		$grid->GetInstanceMasterTable()->ExportToPDF();
	}
?>

<html>
	<head>
		<title>FIPAGO - Bancos</title>
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
				
				<div class='titulos'>Bancos</div>
				<div class='usuarioLogueado'><?php echo nombreUsuarioLogeado(); ?></div>
				<div style="clear:both;"></div>	


				<div class="tablaCentrada">
					<form id="form1" method="post">			
						<?php 
							echo $koolajax->Render();
						?>

						<div class="divOpcionesExportacion">
							<input type="submit" name="ExportToCSV" value = "Exportar a CSV" />
							<input type="submit" name="ExportToExcel" value = "Exportar a Excel" />
							<input type="submit" name="ExportToWord" value = "Exportar a Word" />
							<input type="submit" name="ExportToPDF" value = "Exportar a PDF" />
							&nbsp;&nbsp;
							<input type="checkbox" id="IgnorePaging" name="IgnorePaging"/> <label for="IgnorePaging">Ignorar Paginación</label>
						</div>

						<?php
							echo $grid->Render();
						?>

					</form>

				</div>

		</div>
		<div style="clear:both;"></div>
		
	</body>

</html>