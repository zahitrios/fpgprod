<?php

	session_start();
	include_once ("../conf/functions.php");
	validarSession();
	ob_start();
	$_SESSION["language_select"] = "es";

	$KoolControlsFolder="../lib/KoolPHPSuite/KoolControls";

	require $KoolControlsFolder."/KoolAjax/koolajax.php";
	require $KoolControlsFolder."/KoolGrid/koolgrid.php";
	require $KoolControlsFolder."/KoolAutoComplete/koolautocomplete.php";
	require $KoolControlsFolder."/KoolTabs/kooltabs.php";

	$koolajax->scriptFolder = "../lib/KoolPHPSuite/KoolControls/KoolAjax"; 	

	$link=conectDBReturn();
	$ds = new MySQLDataSource($link);



	$kac = new KoolAutoComplete("kac");
	$kac->scriptFolder = $KoolControlsFolder."/KoolAutoComplete";
	$kac->width = "350px";
	$kac->attachTo = "txtSearch";
	$kac->styleFolder="default";
 
 
	function service($text)
	{
		global $ds; 

		$items = array();
 
		$result = mysql_query("SELECT folioIdentificador,nombre FROM ahorrador WHERE folioIdentificador LIKE '$text%'");
		while($row = mysql_fetch_assoc($result))
		{
			$item = array("text"=>$row["folioIdentificador"],"nombre"=>$row["nombre"]);
			
			array_push($items,$item);
		}
		return $items;
	}
 
	
	$kac->itemTemplate ="<table style='text-align:left'><tr><td class='keyword'>{text}</td><td class='resultno' align='right'>{nombre}</td></tr></table>";
	$kac->footerTemplate = "<div class='footer'><a href='javascript:close_autocomplete()'>cerrar</a></div>";
	$kac->serviceFunction = "service";
	$koolajax->enableFunction("service");


?>

<html>
	<head>
		<title>FIPAGO - Verificaciones</title>
		<meta charset="UTF-8">

		<link href="https://fonts.googleapis.com/css?family=Raleway:300,400,700" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../styles.css">
		<link rel="stylesheet" type="text/css" href="styles.css">		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

		<!-- <script text="javascript" src="//code.jquery.com/jquery-1.10.2.js"></script>
		<script text="javascript" src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> -->

		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		
		<script language="javascript" src="../functions.js"></script>
		<script language="javascript" src="./functions.js"></script>

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
				
				<div class='titulos'>Verificaciones</div>
				<div class='usuarioLogueado'><?php echo nombreUsuarioLogeado(); ?></div>
				<div style="clear:both;"></div>	

				<form id="formTabs" name="formTabs" action="./index.php" method="post">
					<?php
						$kts = new KoolTabs("kts");
						$kts->scriptFolder = $KoolControlsFolder."/KoolTabs";
						$kts->styleFolder="silver";
							
						$kts->addTab("root","documentos","Documentos");	
						$kts->addTab("root","sociedades","Sociedades");																
						$kts->addTab("root","aclaraciones","Aclaraciones");																
						$kts->addTab("root","reembolsos","Reembolsos");																
						$_select_tab = "documentos";

						$estiloDocumentos="block";						
						$estiloSociedades="none";
						$estiloAclaraciones="none";
						$estiloRembolsos="none";


						if(isset($_REQUEST["kts_selected"]))
						{
							$_select_tab = $_REQUEST["kts_selected"];
							
							if($_select_tab=="documentos")
							{
								$estiloDocumentos="block";						
								$estiloSociedades="none";	
								$estiloAclaraciones="none";
								$estiloRembolsos="none";							
							}
							else if($_select_tab=="sociedades")
							{
								$estiloDocumentos="none";						
								$estiloSociedades="block";	
								$estiloAclaraciones="none";
								$estiloRembolsos="none";								
							}
							else if($_select_tab=="aclaraciones")
							{
								$estiloDocumentos="none";						
								$estiloSociedades="none";	
								$estiloAclaraciones="block";
								$estiloRembolsos="none";								
							}
							else if($_select_tab=="reembolsos")
							{
								$estiloDocumentos="none";						
								$estiloSociedades="none";	
								$estiloAclaraciones="none";
								$estiloRembolsos="block";								
							}
						}

						$kts->getTab($_select_tab)->selected = true;
						echo $kts->Render();
					?>
					<script type="text/javascript">
						kts.registerEvent("OnSelect",function(sender,arg)
						{
							document.getElementById("formTabs").submit();
						});
					</script>
				</form>



				<!-- tab documentos -->
				<div style="display:<?php echo $estiloDocumentos; ?>;">


						<div class="tabsBuscador">
							<div class="itemTabBuscador" onclick="muestraBuscadorContenedor();">Búsqueda por contenedor</div>
							<div class="itemTabBuscador" onclick="muestraBuscadorFolio();">Búsqueda por folio</div>
							<div style="clear:both;"></div>
						</div>

						<div class="tablaCentrada bordeBuscador" id="buscadorPorContenedor" style="display:block;">


							<div style="width: 100%; text-align: left; padding-left: 10px; display: block;" class="oculta">
								<img src="../img/banderin.png" onclick="disminuyeAumentaTamanoBuscador('tablaBusquedaPorContenedor');" style="cursor: pointer; width: 40px; margin-left: 20px; margin-bottom: -35px; float: left; margin-top: -16px;">
							</div>


							<div class="tablaCentrada" id="tablaBusquedaPorContenedor">
								<span class='titulosRojos'>BÚSQUEDA POR CONTENEDOR</span>
								<br>
									<select onchange="cargaContenedoresDelConvenio(this.value);">	
										<option value="">Seleccione un convenio</option>							
										<?php
											$todosLosConvenios=dameConveniosConStatus(3); //Traigo los convenios en operación											
											foreach($todosLosConvenios as $k => $convenio)
											{											
												$detalleConvenio=dameDetalleConvenio($convenio["idconvenio"]);
												echo "<option value='".$convenio["idconvenio"]."'>";
													echo $detalleConvenio["nombreEstado"]." - $ ".separarMiles($detalleConvenio["montoTotalConvenio"])." - ".convierteTimeStampCorto($detalleConvenio["fechaFirma"]);
												echo "</option>";
											}
										?>
									</select>
									<br><br>
									
									<div id="divSelectContenedores">
									</div>
									<br><br>

									<div id="divListaAhorradoresContenedores">
									</div>



								<br>							
							</div>
						</div>


						<div class="tablaCentrada bordeBuscador" style="display:none;" id="buscadorPorFolio">

								<div style="width: 100%; text-align: left; padding-left: 10px; display: block;" class="oculta">
									<img src="../img/banderin.png" onclick="disminuyeAumentaTamanoBuscador('tablaBusquedaPorFolio');" style="cursor: pointer; width: 40px; margin-left: 20px; margin-bottom: -35px; float: left; margin-top: -16px;">
								</div>


							<div class="tablaCentrada" id="tablaBusquedaPorFolio">

								<span class='titulosRojos'>BÚSQUEDA POR FOLIO</span>
								<br>
								<?php echo $koolajax->Render();?>
								<input type="text" id="txtSearch" value='<?php echo $_REQUEST["i"]; ?>' autocomplete="off" placeholder="Folio identificador del ahorrador" />
								<br><br>
								<input type="button" id="btnSearch" class='botonRojoChico' value="Buscar" onclick="doSearch()"/>
								<?php echo $kac->Render(); ?>	
							</div>
						</div>





					

					<br><br>

					<div id="imagenBanderin" style="width:100%; text-align:left; padding-left:10px;" class="oculta" >
						<img  src="../img/banderin.png" onclick="muestraOculta('pantalla'); muestraOculta('auxiliarDiseno');" style="cursor: pointer; width: 40px; margin-left: 20px; margin-bottom: -35px;" />
					</div>

					<div class="tablaCentrada bordePantalla oculta" id="auxiliarDiseno">
					</div>

					<div class="tablaCentrada bordePantalla" id="pantalla" style="margin-bottom:25px;">
					</div>
					<br>
					<div class="menuSeccionesLaterales" id="menuSeccionesLaterales">
						<div class="itemMenuLateral menuDocumentosIdentidad" onclick="muestraSeccionMenu('divDocumentosIdentidad')"><span>Documentos de identidad</span></div>
						<!-- <div class="itemMenuLateral menuRepresentanteLegal" onclick="muestraSeccionMenu('divRepresentanteLegal')"><span>Representante legal</span></div> -->
						<div class="itemMenuLateral menuMenorEdad" onclick="muestraSeccionMenu('divMenorDeEdad')"><span>Menor de edad</span></div>
						<div class="itemMenuLateral menuAlbaceaHeredero" onclick="muestraSeccionMenu('divRepresentanteAlbaceaBeneficiario')"><span>Representante, albacea, heredero o beneficiario</span></div>
						<div class="itemMenuLateral menuFormatoIdentidad" onclick="muestraSeccionMenu('divFormatosIdentidad')"><span>Formatos de identidad</span></div>
						<div class="itemMenuLateral menuDocumentosValor" onclick="muestraSeccionMenu('divDocumentosValor')"><span>Documentos de valor</span></div>
						<div class="itemMenuLateral menuDocumentosComprobatorios" onclick="muestraSeccionMenu('divDocumentosComprobatorios')"><span>Documentos comprobatorios</span></div>
					</div>
					<div class="tablaCentrada bordePantalla seccionDerecha" id="pantallaDinamica" style="margin-bottom: 20px;">
					</div>
					
				</div>
				<!-- tab documentos -->




				<!-- tab sociedades -->
				<div style="display:<?php echo $estiloSociedades; ?>;">
					<div class="tablaCentrada">
						<span class="titulos">Sociedades</span>
						<br>
						Elige un convenio
						<br><br>
						<select name="convenios" id="convenios">
							<?php
								$convenios=dameTodosConvenios(3);
								foreach($convenios as $indice => $convenio)
								{
									echo "<option value='".$convenio["idconvenio"]."'>".$convenio["nombre"]." - $ ".separarMiles($convenio["montoTotalConvenio"])." - ".convierteTimeStampCorto($convenio["fechaFirma"])."</option>";
								}
							?>
						</select>
						<br><br>
						<input type="button" value="Cargar sociedades" class="botonRojoChico" onclick="cargaSociedadesConvenio();">
						<br><br>
						<div class="tablaCentrada bordePantalla" id="listaSociedades">
						</div>
					</div>
				</div>
				<!-- tab sociedades -->






				<!-- tab aclaraciones -->
				<div style="display:<?php echo $estiloAclaraciones; ?>;">
					<div class="tablaCentrada">
						<span class="titulos">Aclaraciones</span>
						<br><br>

						

					</div>
				</div>
				<!-- tab aclaraciones -->








				<!-- tab reembolsos -->
				<div style="display:<?php echo $estiloRembolsos; ?>;">
					<div class="tablaCentrada">
						<span class="titulos">Reembolsos</span>
						<br><br>



					</div>
				</div>
				<!-- tab reembolsos -->







				<div id="cargando">
					<img id="imagenCargando" src="<?php echo RUTA; ?>img/cargando.gif" />
				</div>

				<div id="draggable" class="oculta">
				</div>


		</div>
		<div style="clear:both;"></div>		
	</body>
</html>