<?php

	//para pruebas 28052100000131

	session_start();
	include_once ("../conf/functions.php");
	validarSession();
	ob_start();

	$_SESSION["language_select"] = "es";
	$pantalla=$_REQUEST["p"];
	
	
	$idusuarios=dameIdUserMd5($_SESSION["i"]); 		
	if(usuarioTieneModulo($idusuarios,20)===false)//Valido que el usuario tenga el modulo de convenios
	{
		echo "SU USUARIO NO PUEDE REALIZAR ESTA ACCION";
		die;
	}


	switch($_REQUEST["a"])
	{
		case "cargaSociedades":
			cargaSociedades();
		break;

		case "muestraPantalla":
			muestraPantalla();
		break;

		case "guardaStatusCaja":
			guardaStatusCaja();
		break;

		case "muestraDocumentosAceptados":
			muestraDocumentosAceptados();
		break;

		case "muestraPrimeraDocCompro":
			muestraPrimeraDocCompro();
		break;

		case "muestraSegundaDocCompro":
			muestraSegundaDocCompro();
		break;

		case "validaDocumentoVerificacion":
			validaDocumentoVerificacion();
		break;

		case "dameContenedores":
			dameContenedores();
		break;

		case "dameAhorradoresContenedor":
			dameAhorradoresContenedor();
		break;

		case "guardaPrimeraVerificacion":
			guardaVerificacion(1);
		break;

		case "guardaSegundaVerificacion":
			guardaVerificacion(2);
		break;

		case "guardaVerificacionFinal":
			guardaVerificacion(3);
		break;

		case "evaluaAclaracion":
			evaluaAclaracion();
		break;

		case "muestraAclaracionAhorrador":
			muestraAclaracionAhorrador();
		break;

		case "buscaLogVerificacion":
			buscaLogVerificacion();
		break;

		case "eliminaPrimeraVerificacion":
			eliminaVerificaciones(1);
		break;

		case "eliminaSegundaVerificacion":
			eliminaVerificaciones(2);
		break;

		case "eliminaTerceraVerificacion":
			eliminaVerificaciones(3);
		break;

		case "eliminaTodasVerificaciones":
			eliminaVerificaciones(1);
			eliminaVerificaciones(2);
			eliminaVerificaciones(3);
		break;

	}



	function eliminaVerificaciones($tipo)
	{
		global $_REQUEST;

		$idAhorrador=dameIdAhorrador($_REQUEST["i"]);

		if($tipo==1)
		{
			$tabla="primeraVerificacion";
			$tablaDocumentos="documentosComprobatorios";
			$campoId="idcamposVerificacion";
			$campoId2="primeraVerificacion_idcamposVerificacion";
			$leyenda="LA PRIMERA VERIFICACIÓN HA SIDO ELIMINADA";
		}
		else if($tipo==2)
		{
			$tabla="segundaVerificacion";
			$tablaDocumentos="documentosComprobatoriosSegundaVerificacion";
			$campoId="idsegundaVerificacion";
			$campoId2="segundaVerificacion_idsegundaVerificacion";
			$leyenda="LA SEGUNDA VERIFICACIÓN HA SIDO ELIMINADA";
		}
		else if($tipo==3)
		{
			$tabla="verificacionFinal";
			$tablaDocumentos="documentosComprobatoriosVerificacionFinal";
			$campoId="idverificacionFinal";
			$campoId2="verificacionFinal_idverificacionFinal";
			$leyenda="LA VERIFICACIÓN FINAL HA SIDO ELIMINADA";
		}


		$sql="SELECT ".$campoId." FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."'";
		$res=mysql_query($sql);
		if(!$res)
			echo "Ocurrio un error:<br>".$sql."<br>".mysql_error()."<br>";
		$fil=mysql_fetch_assoc($res);
		$idTabla=$fil[$campoId];


		//BORRO LOS DOCUMENTOS COMPROBATORIOS
		$sqlDocs="DELETE FROM ".$tablaDocumentos." WHERE ".$campoId2."='".$idTabla."'";
		$resDocs=mysql_query($sqlDocs);
		if(!$resDocs)
			echo "Ocurrio un error:<br>".$sqlDocs."<br>".mysql_error()."<br>";

		if($tipo==3)
		{
			//BORRO DE AHORRADORES VERIFICADOS
			$sqlVer="DELETE FROM ahorradoresVerificados WHERE ahorrador_idahorrador='".$idAhorrador."'";
			$resVer=mysql_query($sqlVer);
			if(!$resVer)
				echo "Ocurrio un error:<br>".$sqlVer."<br>".mysql_error()."<br>";

			//BORRO DE ACLARACIONES
			$sqlAcl="DELETE FROM aclaraciones WHERE ahorrador_idahorrador='".$idAhorrador."'";
			$resAcl=mysql_query($sqlAcl);
			if(!$resAcl)
				echo "Ocurrio un error:<br>".$sqlAcl."<br>".mysql_error()."<br>";
		}

		//BORRO DE LA TABLA PRINCIPAL
		$sql="DELETE FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."'";
		$res=mysql_query($sql);
		if(!$res)
			echo "Ocurrio un error:<br>".$sql."<br>".mysql_error()."<br>";

		echo $leyenda."\n";


	}


	function muestraAclaracionAhorrador()
	{
		global $_REQUEST;

		$idAhorrador=dameIdAhorrador($_REQUEST["i"]);

		$sql="SELECT * FROM aclaraciones WHERE ahorrador_idahorrador='".$idAhorrador."'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)>0)
		{
			echo "<span class='titulosRojos'>AHORRADOR EN ACLARACIÓN</span><br><br> <div> <ul style='text-align: left;'> ";

			while($fil=mysql_fetch_assoc($res))
			{
				echo "<li>".$fil["razon"]."</li>";
			}
			echo "</ul></div>";
		}
		else
		{
			echo "EL AHORRADOR NO ESTÁ EN ACLARACION<br><br>";
		}
	}

	function guardaVerificacion($revision)
	{
		global $_REQUEST;

		$idAhorrador=dameIdAhorrador($_REQUEST["folioIdentificadorPantalla"]);
		$nombreAhorrador= dameNombreAhorrador($_REQUEST["folioIdentificadorPantalla"]);

		if($revision==1)
		{
			$tabla="primeraVerificacion";
			$tablaDocumentos="documentosComprobatorios";
			$idDocumentosComprobatorios="primeraVerificacion_idcamposVerificacion";
			$leyenda="PRIMERA";
			$idActividad="14";
		}

		else if ($revision==2)
		{
			$tabla="segundaVerificacion";
			$tablaDocumentos="documentosComprobatoriosSegundaVerificacion";
			$idDocumentosComprobatorios="segundaVerificacion_idsegundaVerificacion";
			$leyenda="SEGUNDA";
			$idActividad="15";
		}

		else if ($revision==3)
		{
			$tabla="verificacionFinal";
			$tablaDocumentos="documentosComprobatoriosVerificacionFinal";
			$idDocumentosComprobatorios="verificacionFinal_idverificacionFinal";
			$leyenda="FINAL";
			$idActividad="16";
		}


		if($_REQUEST["tipoPersona"]=="fisica")
			$tipoPersona=1;
		if($_REQUEST["tipoPersona"]=="moral")
			$tipoPersona=2;


		if($_REQUEST["tipoPersonaRepresentante"]=="fisica")
			$tipoPersonaRepresentante=1;
		if($_REQUEST["tipoPersonaRepresentante"]=="moral")
			$tipoPersonaRepresentante=2;

		$partes=explode("-",$_REQUEST["datepicker"]);
		$fechaComprobanteDomicilio=$partes[2]."-".$partes[1]."-".$partes[0];

		$partes=explode("-",$_REQUEST["datepicker2"]);
		$fechaFormato=$partes[2]."-".$partes[1]."-".$partes[0];

		$partes=explode("-",$_REQUEST["datepicker3"]);
		$fechaComprobanteDomicilioRepresentanteMoral=$partes[2]."-".$partes[1]."-".$partes[0];
		


		$camposTabla=Array(
			"ahorrador_idahorrador",
			"tipoPersona",
			"casoAtipico",
			"formato8",
			"documentoAcrediteSocio",
			"formato7",
			"fallecido",
			"copiaSimpleIdentificacion",
			"menorEdad",
			"comprobanteEdad",
			"comprobanteDomicilio",
			"ahorradorExtranjero",
			"copiaIdentificacionAhorradorExtranjero",
			"fechaComprobanteDomicilio",

			"originalEstadoTutela",
			"originalAdopcionMenor",
			"copiaCertificadaActaMenorEdad",

			"representanteLegal",
			"tipoPersonaRepresentante",
			"tipoRepresentantePersonaFisica",
			"originalCartaPoderActosDominio",
			"originalPoderNotarialActosDominio",
			"copiaSimpleIdentificacionRepresentanteLegal",
			"copiaActaConstitutivaSociedad",
			"originalActosDominioNotarioPublico",
			"copiaSimpleIdentificacionRepresentanteLegalMoral",
			"comprobanteEdadRepresentanteLegalMoral",
			"comprobanteDomicilioRepresentanteLegalMoral",
			"fechaComprobanteDomicilioRepresentanteMoral",

			"albaceaDecimo",
			"copiaActaDefunsionAhorrador",
			"copiaAcrediteAlbacea",
			"copiaIdentificacionAlbacea",
			"copiaAceptacionCargoAlbacea",

			"herederosDecimoPrimero",
			"copiaActaNacimientoRepresentado",
			"copiaActaNacimientoRepresentadoMenorEdad",
			"copiaIdentificacionHerederos",
			"copiaTestamento",

			"beneficiarioDecimoSegundo",
			"copiaActaDefuncionAhorrador",
			"copiaActaNacimientoBeneficiarios",
			"copiaIdentificacionVigenteBeneficiarios",
			"contratoOriginalBeneficiarios",

			"solicitudAhorradorAnversoReverso",
			"fechaFormato",
			"declaracionISR",
			"manifestacionObligacionesFiscales",
			"cumple5AniosFiscales",
			"etiquetaExpedienteFormato4",

			"originalDenunciaPenal",
			"transmisionTitularidad",
			"sentenciaConcursoMercantil",
			"sentenciaQuiebra",			

			"certificadoNoAdeudo",
			"cartaLiberacionGarantias",
			"finiquitoPago",
			"montoContratoSesionDerechos",
			"saldo70Ahorro",
			"documentos",
			"documentosNoPresentados",
		);


		$valoresTabla=Array(
			"'".$idAhorrador."'",
			"'".$tipoPersona."'",
			"'".$_REQUEST["casoAtipico"]."'",
			"'".$_REQUEST["formato8"]."'",
			"'".$_REQUEST["credencialSocio"]."'",
			"'".$_REQUEST["formato7"]."'",
			"'".$_REQUEST["fallecido"]."'",
			"'".$_REQUEST["copiaSimpleIdentificacion"]."'",
			"'".$_REQUEST["menorDeEdad"]."'",
			"'".$_REQUEST["comprobanteDeEdad"]."'",
			"'".$_REQUEST["comprobanteDomicilio"]."'",
			"'".$_REQUEST["ahorradorExtranjero"]."'",
			"'".$_REQUEST["copiaIdentificacionAhorradorExtr    anjero"]."'",
			"'".$fechaComprobanteDomicilio."'",

			"'".$_REQUEST["originalDocumentoTutela"]."'",
			"'".$_REQUEST["originalDocumentoAdopcion"]."'",
			"'".$_REQUEST["copiaCertificadaActaMenorEdad"]."'",

			"'".$_REQUEST["representanteLegal"]."'",
			"'".$tipoPersonaRepresentante."'",
			"'".$_REQUEST["tipoRepresentantePersonaFisica"]."'",
			"'".$_REQUEST["originalCartaActosDominio"]."'",
			"'".$_REQUEST["originalPoderNotarialActosDominio"]."'",
			"'".$_REQUEST["copiaSimpleIdentificacionRepresentante"]."'",
			"'".$_REQUEST["copiaCertificadaActaConstitutivaSociedad"]."'",
			"'".$_REQUEST["originalActosDominioNotarioPublico"]."'",
			"'".$_REQUEST["copiaSimpleIdentificacionRepresentanteLegalMoral"]."'",
			"'".$_REQUEST["comprobanteEdadRepresentanteLegalMoral"]."'",
			"'".$_REQUEST["comprobanteDomicilioRepresentanteLegalMoral"]."'",
			"'".$fechaComprobanteDomicilioRepresentanteMoral."'",

			
			"'".$_REQUEST["albaceaDecimo"]."'",
			"'".$_REQUEST["copiaCertificadaActaDefuncion"]."'",
			"'".$_REQUEST["copiaCertificadaDocumentoAcreditaAlbacea"]."'",
			"'".$_REQUEST["copiaSimpleIdentificacionAlbacea"]."'",
			"'".$_REQUEST["copiaCertificadaDocumentoJudicialCargoAlbacea"]."'",

			"'".$_REQUEST["herederoDecimoPrimero"]."'",
			"'".$_REQUEST["copiaCertificadaActaDefuncionHeredero"]."'",
			"'".$_REQUEST["copiaCertificadaActaNacimientoHeredero"]."'",
			"'".$_REQUEST["copiaSimpleIdentificacionHeredero"]."'",
			"'".$_REQUEST["copiaCertificadaEscrituraTestamentoHeredero"]."'",


			"'".$_REQUEST["beneficiarioDecimoSegundo"]."'",
			"'".$_REQUEST["copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo"]."'",
			"'".$_REQUEST["copiaCertificadaTodosDocumentos"]."'",
			"'".$_REQUEST["copiaSimpleTodosBeneficiarios"]."'",
			"'".$_REQUEST["contratoOriginalBeneficiario"]."'",

			"'".$_REQUEST["solicitudAhorrador"]."'",
			"'".$fechaFormato."'",
			"'".$_REQUEST["declaracionAnualCincoAnios"]."'", 
			"'".$_REQUEST["manifestacionObligacionesFiscales"]."'", 
			"'".$_REQUEST["cumple5AniosFiscales"]."'", 
			"'".$_REQUEST["etiquetaSobreIndividual"]."'", 

			"'".$_REQUEST["originalDenunciaPenal"]."'",
			"'".$_REQUEST["transmisionTitularidadCreditos"]."'",
			"'".$_REQUEST["sentenciaConcursoMercantil"]."'",
			"'".$_REQUEST["sentenciaQuiebra"]."'",

			"'".$_REQUEST["certificadoNoAdeudo"]."'",
			"'".$_REQUEST["cartaNoResponsabilidadLiberacionGarantias"]."'",
			"'".$_REQUEST["valorFiniquitoPago"]."'",
			"'".$_REQUEST["ContratoSesionDerechos"]."'",
			"'".$_REQUEST["salto70Ahorro"]."'",
			"'".$_REQUEST["numeroDocumentosValor"]."'",
			"'".$_REQUEST["documentosNoPresentados"]."'"
		);

		$sql="INSERT INTO ".$tabla." ";

		//TODOS LOS CAMPOS
		$sql.="(".implode(",", $camposTabla).")"; 

		$sql.=" VALUES ";

		//TODOS LOS VALORES
		$sql.="(".implode(",", $valoresTabla).")"; 
	

		$res=mysql_query($sql);
		$idAux=mysql_insert_id();
		if($res)
		{
			echo "LA ".$leyenda." VERIFICACIÓN DEL AHORRADOR ".strtoupper($nombreAhorrador)." HA SIDO GUARDADA CON ÉXITO";
			guardaLog(dameIdUserMd5($_SESSION["i"]),$idActividad,$tabla,$idAux);

			//GUARDO LOS DOCUMENTOS COMPROBATORIOS
			foreach($_REQUEST["numeroDocumento"] as $indice)
			{				
				$sqlDocs="INSERT INTO ".$tablaDocumentos." 
						(
							".$idDocumentosComprobatorios.",
							numero,
							tipoSaldo,
							folio,
							documento,
							monto,
							aclaracion,
							motivo
						) 
						VALUES 
						(
							'".$idAux."',
							'".$_REQUEST["numeroDocumento"][$indice]."',
							'".$_REQUEST["tipoDocumento"][$indice]."',
							'".$_REQUEST["folio"][$indice]."',
							'".$_REQUEST["documento"][$indice]."',
							'".$_REQUEST["monto"][$indice]."',
							'".$_REQUEST["aclaracion_"][$indice]."',
							'".$_REQUEST["motivoAclaracion"][$indice]."' 
						)";
				$resDocs=mysql_query($sqlDocs);

				if(!$resDocs)
					echo "OCURRIÓ UN ERROR AL GUARDAR EL DOCUMENTO ".$_REQUEST["numeroDocumento"][$indice]."<br><br>".$sqlDocs."<br><br>".mysql_error();
			}

			
		}
		else
		{
			echo "OCURRIÓ UN ERROR AL GUARDAR LA ".$leyenda." VERIFICACIÓN DEL AHORRADOR ".strtoupper($nombreAhorrador)."<br><br>".$sql."<br><br>".mysql_error();
		}

	}


	function evaluaAclaracion()
	{
		global $_REQUEST;

		$folioIdentificador=$_REQUEST["folio"];
		$idahorrador=dameIdAhorrador($folioIdentificador);

		$razones=Array();

		//LA VERIFICACION
		//$sqlVF="SELECT * FROM primeraVerificacion WHERE ahorrador_idahorrador='".$idahorrador."'";
		$sqlVF="SELECT * FROM verificacionFinal WHERE ahorrador_idahorrador='".$idahorrador."'";
		$resVF=mysql_query($sqlVF);
		$filVF=mysql_fetch_assoc($resVF);


		//SI ES CASO ATÍPIO DEBE TENER FORMATO 8
		if($filVF["casoAtipico"]==1 && ($filVF["formato8"]==0 ||$filVF["formato8"]==""))
			$razones[]="SE SELECCIONÓ COMO CASO ATÍPICO PERO NO SE INCLUYÓ EL FORMATO 8";


		//SI NO HAY CREDENCIAL DE SOCIO DEBE TENER FORMATO 7
		if($filVF["documentoAcrediteSocio"]==1 && ($filVF["formato7"]==0 ||$filVF["formato7"]==""))
			$razones[]="FALTÓ EL DOCUMENTO O CREDENCIAL QUE LO ACREDITE COMO SOCIO Y NO SE INCLUYÓ EL FORMATO 7";



		//MARCO NO FALLECIDO (ESTA VIVO)
		if($filVF["fallecido"]==0)
		{
			//FALTA COPIA SIMPLE IDENTIFICACION DEL AHORRADOR
			if($filVF["copiaSimpleIdentificacion"]==0 || $filVF["copiaSimpleIdentificacion"]=="")
				$razones[]="FALTÓ LA COPIA SIMPLE DE LA IDENTIFICACIÓN DEL AHORRADOR";

			//FALTA COMPROBANTE EDAD AHORRADOR
			if($filVF["comprobanteEdad"]==0 || $filVF["comprobanteEdad"]=="")
				$razones[]="FALTÓ COMPROBANTE DE EDAD";

			//FALTA COMPROBANTE DE DOMICILIO
			if($filVF["comprobanteDomicilio"]==0 || $filVF["comprobanteDomicilio"]=="")
				$razones[]="FALTÓ COMPROBANTE DE DOMICILIO";

			//SI NO HAY CREDENCIAL DE SOCIO DEBE TENER FORMATO 7
			if($filVF["ahorradorExtranjero"]==1 && ($filVF["copiaIdentificacionAhorradorExtranjero"]==0 ||$filVF["copiaIdentificacionAhorradorExtranjero"]==""))
				$razones[]="ES AHORRADOR EXTRANJERO Y LA COPIA SIMPLE DE LA IDENTIFICACIÓN DE AHORRADOR EXTRANJERO";

			//FALTO FECHA DE COMPROBANTE DE DOMICILIO
			if($filVF["fechaComprobanteDomicilio"]=="")
				$razones[]="FALTÓ LA FECHA DEL COMPROBANTE DE DOMICILIO";
		}




		//ES MENOR DE EDAD
		if($filVF["menorEdad"]==1)
		{
			//ORIGINAL DEL DOCUMENTO JUDICIAL QUE ACREDITE EL ESTADO DE INTERDICCIÓN Y LA TUTELA
			if($filVF["originalEstadoTutela"]==0 || $filVF["originalEstadoTutela"]=="")
				$razones[]="ES MENOR DE EDAD Y FALTÓ EL ORIGINAL DEL DOCUMENTO JUDICIAL QUE ACREDITE EL ESTADO DE INTERDICCIÓN Y LA TUTELA";

			//ORIGINAL DEL DOCUMENTO JUDICIAL QUE ACREDITE LA ADOPCIÓN DEL MENOR
			if($filVF["originalAdopcionMenor"]==0 || $filVF["originalAdopcionMenor"]=="")
				$razones[]="ES MENOR DE EDAD Y FALTÓ EL OORIGINAL DEL DOCUMENTO JUDICIAL QUE ACREDITE LA ADOPCIÓN DEL MENOR";

			//COPIA CERTIFICADA DEL ACTA DE NACIMIENTO DEL MENOR DE EDAD
			if($filVF["copiaCertificadaActaMenorEdad"]==0 || $filVF["copiaCertificadaActaMenorEdad"]=="")
				$razones[]="ES MENOR DE EDAD Y FALTÓ COPIA CERTIFICADA DEL ACTA DE NACIMIENTO DEL MENOR DE EDAD";
		}


		//TIENE REPRESENTANTE LEGAL
		if($filVF["representanteLegal"]==1)
		{
			if($filVF["tipoPersonaRepresentante"]=="")
				$razones[]="EXISTE REPRESENTANTE LEGAL PERO NO SE ESPECIFICÓ EL TIPO DE PERSONA DEL REPRESENTANTE (FÍSICA O MORAL)";


			if($filVF["tipoPersonaRepresentante"]=="1") //PERSONA FÍSICA
			{				
				if($filVF["tipoRepresentantePersonaFisica"]=="" || $filVF["tipoRepresentantePersonaFisica"]==0)
					$razones[]="EXISTE REPRESENTANTE (PERSONA FÍSICA) LEGAL PERO NO SE INCLUYÓ EL TIPO DE PERSONA FÍSICA DEL REPRESENTANTE LEGAL (PERSONA COMÚN O PERSONA AUTORIZADA)";
				
				if($filVF["originalCartaPoderActosDominio"]=="" || $filVF["originalCartaPoderActosDominio"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA FÍSICA) PERO NO SE INCLUYÓ ORIGINAL CARTA PODER PARA ACTOS DE DOMINIO";

				if($filVF["originalPoderNotarialActosDominio"]=="" || $filVF["originalPoderNotarialActosDominio"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA FÍSICA) PERO NO SE INCLUYÓ ORIGINAL PODER NOTARIAL PARA ACTOS DE DOMINIO";

				if($filVF["copiaSimpleIdentificacionRepresentanteLegal"]=="" || $filVF["copiaSimpleIdentificacionRepresentanteLegal"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA FÍSICA) PERO NO SE INCLUYÓCOPIA SIMPLE DE IDENTIFICACIÓN OFICIAL VIGENTE CON FOTOGRAFÍA Y FIRMA";
			}

			if($filVF["tipoPersonaRepresentante"]=="2") //PERSONA MORAL
			{
				if($filVF["copiaActaConstitutivaSociedad"]=="" || $filVF["originalPoderNotarialActosDominio"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA MORAL) PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL ACTA CONSTITUTIVA DE LA SOCIEDAD, DE SUS ESTATUTOS CON SUS ÚLTIMAS MODIFICACIONES";

				if($filVF["originalActosDominioNotarioPublico"]=="" || $filVF["originalActosDominioNotarioPublico"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA MORAL) PERO NO SE INCLUYÓ ORIGINAL DEL PODER PARA ACTOS DE DOMINIO DEL REPRESENTANTE LEGAL CERTIFICADO ANTE NOTARIO PÚBLICO EN EL QUE SE LE FACULTE";

				if($filVF["copiaSimpleIdentificacionRepresentanteLegalMoral"]=="" || $filVF["copiaSimpleIdentificacionRepresentanteLegalMoral"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA MORAL) PERO NO SE INCLUYÓ COPIA SIMPLE DE IDENTIFICACIÓN DEL REPRESENTANTE LEGAL";

				if($filVF["comprobanteDomicilioRepresentanteLegalMoral"]=="" || $filVF["comprobanteDomicilioRepresentanteLegalMoral"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA MORAL) PERO NO SE INCLUYÓ COMPROBANTE DE DOMICILIO DEL REPRESENTANTE LEGAL";

				if($filVF["fechaComprobanteDomicilioRepresentanteMoral"]=="" || $filVF["fechaComprobanteDomicilioRepresentanteMoral"]==0)
					$razones[]="EXISTE REPRESENTANTE LEGAL (PERSONA MORAL) PERO NO SE INCLUYÓ LA FECHA COMPROBANTE DE DOMICILIO DEL REPRESENTANTE LEGAL";
			}
		}

		//TIENE ALBACEA DECIMO
		if($filVF["albaceaDecimo"]==1)
		{
			if($filVF["copiaActaDefunsionAhorrador"]=="" || $filVF["originalActosDominioNotarioPublico"]==0)
				$razones[]="EXISTE ALBACEA PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL ACTA DE DEFUNCIÓN DEL AHORRADOR	";

			if($filVF["copiaAcrediteAlbacea"]=="" || $filVF["copiaAcrediteAlbacea"]==0)
				$razones[]="EXISTE ALBACEA PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL DOCUMENTO JUDICIAL QUE ACREDITE SU CARGO DE ALBACEA";

			if($filVF["copiaIdentificacionAlbacea"]=="" || $filVF["copiaIdentificacionAlbacea"]==0)
				$razones[]="EXISTE ALBACEA PERO NO SE INCLUYÓ COPIA SIMPLE DE IDENTIFICACIÓN OFICIAL VIGENTE CON FOTOGRAFÍA Y FIRMA DEL ALBACEA";

			if($filVF["copiaAceptacionCargoAlbacea"]=="" || $filVF["copiaAceptacionCargoAlbacea"]==0)
				$razones[]="EXISTE ALBACEA PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL DOCUMENTO JUDICIAL DONDE SE ACREDITE SU ACEPTACIÓN Y CARGO DE ALBACEA";
		}


		//TIENE HEREDEROS (DÉCIMO PRIMERO)
		if($filVF["herederosDecimoPrimero"]==1)
		{
			if($filVF["copiaActaNacimientoRepresentado"]=="" || $filVF["copiaActaNacimientoRepresentado"]==0)
				$razones[]="EXISTE HEREDERO (DÉCIMO PRIMERO) PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL ACTA DE DEFUNCIÓN DEL AHORRADOR";

			if($filVF["copiaIdentificacionHerederos"]=="" || $filVF["copiaIdentificacionHerederos"]==0)
				$razones[]="EXISTE HEREDERO (DÉCIMO PRIMERO) PERO NO SE INCLUYÓ COPIA SIMPLE DE IDENTIFICACIÓN OFICIAL VIGENTE CON FOTOGRAFÍA Y FIRMA DEL (LOS) HEREDERO(S)";

			if($filVF["copiaTestamento"]=="" || $filVF["copiaTestamento"]==0)
				$razones[]="EXISTE HEREDERO (DÉCIMO PRIMERO) PERO NO SE INCLUYÓ COPIA CERTIFICADA DE LA ESCRITURA DEL TESTAMENTO O EN CASO DE RESOLUCIÓN JUDICIAL, COPIA CERTIFICADA DE LA SENTENCIA EN QUE CONSTE SU PROTOCOLIZACIÓN, LA PARTICIPACIÓN Y ADJUDICACIÓN DE LOS BIENES HEREDADOS";
		}

		//TIENE BENEFICIARIO (DÉCIMO SEGUNDO)
		if($filVF["beneficiarioDecimoSegundo"]==1)
		{
			if($filVF["copiaActaDefuncionAhorrador"]=="" || $filVF["copiaActaDefuncionAhorrador"]==0)
				$razones[]="EXISTE BENEFICIARIO (DÉCIMO SEGUNDO) PERO NO SE INCLUYÓ COPIA CERTIFICADA DEL ACTA DE DEFUNCIÓN DEL AHORRADOR";

			if($filVF["copiaActaNacimientoBeneficiarios"]=="" || $filVF["copiaActaNacimientoBeneficiarios"]==0)
				$razones[]="EXISTE BENEFICIARIO (DÉCIMO SEGUNDO) PERO NO SE INCLUYÓ DEL(LOS) BENEFICIARIO(S), COPIA CERTIFICADA DE SU ACTA DE NACIMIENTO";

			if($filVF["copiaIdentificacionVigenteBeneficiarios"]=="" || $filVF["copiaIdentificacionVigenteBeneficiarios"]==0)
				$razones[]="EXISTE BENEFICIARIO (DÉCIMO SEGUNDO) PERO NO SE INCLUYÓ COPIA SIMPLE DE IDENTIFICACIÓN OFICIAL VIGENTE CON FOTOGRAFÍA Y FIRMA DEL (OS) BENEFICIARIO(S)";

			if($filVF["contratoOriginalBeneficiarios"]=="" || $filVF["contratoOriginalBeneficiarios"]==0)
				$razones[]="EXISTE BENEFICIARIO (DÉCIMO SEGUNDO) PERO NO SE INCLUYÓ CONTRATO ORIGINAL CELEBRADO CON LA SOCIEDAD DE QUE SE TRATE, EN QUE SE DESIGNA(N) AL (OS) BENEFICIARIO(S)";
		}

		//FORMATOS DE IDENTIDAD
		if($filVF["solicitudAhorradorAnversoReverso"]==0 || $filVF["solicitudAhorradorAnversoReverso"]=="")
			$razones[]="NO SE INCLUYÓ SOLICITUD DEL AHORRADOR (ANVERSO Y REVERSO)";

		if($filVF["fechaFormato"]=="")
			$razones[]="NO SE INDICÓ LA FECHA DEL FORMATO (SOLICITUD DEL AHORRADOR)";

		if($filVF["declaracionISR"]==0 || $filVF["declaracionISR"]=="")
			$razones[]="NO SE INCLUYÓ DECLARACIÓN ISR ANUAL CORRESPONDIENTE A CADA UNO DE LOS AÑOS EN QUE FUE AHORRADOR DE LA SOCIEDAD";

		if($filVF["manifestacionObligacionesFiscales"]==0 || $filVF["manifestacionObligacionesFiscales"]=="")
			$razones[]="NO SE INCLUYÓ MANIFESTACIÓN DE CUMPLIMIENTO DE OBLIGACIONES FISCALES";

		if($filVF["cumple5AniosFiscales"]==0 || $filVF["cumple5AniosFiscales"]=="")
			$razones[]="ENTRE LA DECLARACIÓN ISR Y LA MANIFESTACIÓN DE OBLIGACIONES FISCALES NO SE CUBREN LOS ÚLTIMOS 5 AÑOS";

		if($filVF["etiquetaExpedienteFormato4"]==0 || $filVF["etiquetaExpedienteFormato4"]=="")
			$razones[]="NO SE INCLUYÓ ETIQUETA DE SOBRE DE EXPEDIENTE INDIVIDUAL DE AHORRADOR (FORMATO 4)";

		//FORMATOS DE IDENTIDAD

		// documentos de valor 
		$saldo=dameSaldoTotalAhorrador($folioIdentificador);
		$suma=$filVF["documentos"]+$filVF["documentosNoPresentados"];
		echo " ".$saldo." ".$suma."<br>";
		if($suma!=$saldo)
			$razones[]="LOS DOCUMENTOS ENTREGADOS Y LOS NO ENTREGADOS SUMAN $ ".separarMiles($suma)." Y EL SALDO NETO DEL AHORRADOR ES $ ".separarMiles($saldo);


		

		if(count($razones)>0)
		{
			echo "EL AHORRADOR HA SIDO PUESTO EN ACLARACION POR LOS SIGUIENTES MOTIVOS: \n\n";
			foreach($razones as $indice => $razon)
			{
				echo $razon."\n";
				$sqlAcl="INSERT INTO aclaraciones (ahorrador_idahorrador,verificacionFinal_idverificacionFinal,razon) VALUES ('".$idahorrador."','".$filVF["idverificacionFinal"]."','".$razon."')";
				$resAcl=mysql_query($sqlAcl);
			}

		}
		else
		{
			echo "EL AHORRADOR FUE VERIFICADO CORRECTAMENTE, NO PRESENTÓ MOTIVOS PARA ACLARACIÓN";
			$sqlAcl="INSERT INTO ahorradoresVerificados (ahorrador_idahorrador,verificacionFinal_idverificacionFinal) VALUES ('".$idahorrador."','".$filVF["idverificacionFinal"]."')";
			$resAcl=mysql_query($sqlAcl);
		}

	}


	function dameAhorradoresContenedor()
	{
		global $_REQUEST;

		$idContenedor=$_REQUEST["i"];

		$sql="SELECT * FROM registrosContenadores WHERE contenedoresTemporales_idcontenedoresTemporales='".$idContenedor."' ORDER BY numero ASC";
		$res=mysql_query($sql);
		while($fil=mysql_fetch_assoc($res))
		{
			
			//SE ESTA EN ACLARACION
			if(ahorradorEnAclaracion(dameIdAhorrador($fil["folioIdentificador"])))
			{
				echo "<span class='itemListaAhorradores' onclick='cambiaColorAhorrador(this); muestraAclaracionAhorrador(\"".$fil["folioIdentificador"]."\");'>";
					echo $fil["numero"].".- ".$fil["folioIdentificador"]." - ".$fil["nombreAhorrador"];
				echo "</span>";

				echo " <img src='../img/aclaracion.png' class='inspectorIcono' title='Aclaración' onclick='buscaLogVerificacion(3,\"".$fil["folioIdentificador"]."\");'>";
			}
			else if(ahorradorVerificado(dameIdAhorrador($fil["folioIdentificador"]))) //ESTA VERIFICADO
			{
				echo "<span class='itemListaAhorradores' onclick='cambiaColorAhorrador(this); muestraVerificacionAhorrador(\"".$fil["folioIdentificador"]."\");'>";
					echo $fil["numero"].".- ".$fil["folioIdentificador"]." - ".$fil["nombreAhorrador"];
				echo "</span>";


				echo " <img src='../img/verificado.png' class='inspectorIcono'>";
			}
			else //ESTA EN PROCESO DE VERIFICACION
			{
				echo "<span class='itemListaAhorradores' onclick='cambiaColorAhorrador(this); cargaAhorradorDeLista(\"".$fil["folioIdentificador"]."\");'>";
					echo $fil["numero"].".- ".$fil["folioIdentificador"]." - ".$fil["nombreAhorrador"];
				echo "</span>";

				if(!seHizoPrimeraVerificacion(dameIdAhorrador($fil["folioIdentificador"])))
				{	
					
				}

				if(seHizoPrimeraVerificacion(dameIdAhorrador($fil["folioIdentificador"])) )
				{	
					//echo "se hizo primera verificacion";
			        echo "<img src='../img/inspector.png' class='inspectorIcono' title='Primera Verficación' onclick='buscaLogVerificacion(1,\"".$fil["folioIdentificador"]."\");'>";
				}


				if(seHizoSegundaVerificacion(dameIdAhorrador($fil["folioIdentificador"])))
				{	
					echo " <img src='../img/inspector.png' class='inspectorIcono' title='Segunda Verficación' onclick='buscaLogVerificacion(2,\"".$fil["folioIdentificador"]."\");'>";
					if(!coincidenVerificaciones($fil["folioIdentificador"]))
					{
						echo " <img src='../img/noCoinciden.png' class='inspectorIcono' title='No Coinciden Verificaciones'>";
					}
				}
			}

			echo " <img src='../img/clean.png' class='inspectorIcono' title='Limpiar verificaciones' onclick='if (confirm(\"¿Desea eliminar las verificaciones?\")) eliminaVerificaciones(\"".$fil["folioIdentificador"]."\");'>";

			

			echo "<div style='clear:both;'></div>";
			echo "<br>";

			
		}
	}


	function coincidenVerificaciones($folioIdentificador)
	{

		$idahorrador=dameIdAhorrador($folioIdentificador);

		$sql1="SELECT tipoPersona, casoAtipico, formato8, documentoAcrediteSocio, formato7, fallecido, copiaSimpleIdentificacion, menorEdad, comprobanteEdad, comprobanteDomicilio, ahorradorExtranjero, copiaIdentificacionAhorradorExtranjero, fechaComprobanteDomicilio, originalEstadoTutela, originalAdopcionMenor, copiaCertificadaActaMenorEdad, representanteLegal, tipoPersonaRepresentante, originalCartaPoderActosDominio, originalPoderNotarialActosDominio, copiaSimpleIdentificacionRepresentanteLegal, copiaActaConstitutivaSociedad, originalActosDominioNotarioPublico, copiaSimpleIdentificacionRepresentanteLegalMoral, comprobanteEdadRepresentanteLegalMoral, comprobanteDomicilioRepresentanteLegalMoral, fechaComprobanteDomicilioRepresentanteMoral, albaceaDecimo, copiaActaDefunsionAhorrador, copiaAcrediteAlbacea, copiaIdentificacionAlbacea, copiaAceptacionCargoAlbacea, herederosDecimoPrimero, copiaActaNacimientoRepresentado, copiaActaNacimientoRepresentadoMenorEdad, copiaIdentificacionHerederos, copiaTestamento, beneficiarioDecimoSegundo, copiaActaDefuncionAhorrador, copiaActaNacimientoBeneficiarios, copiaIdentificacionVigenteBeneficiarios, contratoOriginalBeneficiarios, solicitudAhorradorAnversoReverso, fechaFormato, declaracionISR, manifestacionObligacionesFiscales, cumple5AniosFiscales, etiquetaExpedienteFormato4, originalDenunciaPenal, transmisionTitularidad, sentenciaConcursoMercantil, sentenciaQuiebra, certificadoNoAdeudo, cartaLiberacionGarantias, finiquitoPago, montoContratoSesionDerechos, saldo70Ahorro, documentos, documentosNoPresentados FROM primeraVerificacion WHERE ahorrador_idahorrador='".$idahorrador."'";
		$res1=mysql_query($sql1);
		$fil1=mysql_fetch_assoc($res1);

		$sql2="SELECT tipoPersona, casoAtipico, formato8, documentoAcrediteSocio, formato7, fallecido, copiaSimpleIdentificacion, menorEdad, comprobanteEdad, comprobanteDomicilio, ahorradorExtranjero, copiaIdentificacionAhorradorExtranjero, fechaComprobanteDomicilio, originalEstadoTutela, originalAdopcionMenor, copiaCertificadaActaMenorEdad, representanteLegal, tipoPersonaRepresentante, originalCartaPoderActosDominio, originalPoderNotarialActosDominio, copiaSimpleIdentificacionRepresentanteLegal, copiaActaConstitutivaSociedad, originalActosDominioNotarioPublico, copiaSimpleIdentificacionRepresentanteLegalMoral, comprobanteEdadRepresentanteLegalMoral, comprobanteDomicilioRepresentanteLegalMoral, fechaComprobanteDomicilioRepresentanteMoral, albaceaDecimo, copiaActaDefunsionAhorrador, copiaAcrediteAlbacea, copiaIdentificacionAlbacea, copiaAceptacionCargoAlbacea, herederosDecimoPrimero, copiaActaNacimientoRepresentado, copiaActaNacimientoRepresentadoMenorEdad, copiaIdentificacionHerederos, copiaTestamento, beneficiarioDecimoSegundo, copiaActaDefuncionAhorrador, copiaActaNacimientoBeneficiarios, copiaIdentificacionVigenteBeneficiarios, contratoOriginalBeneficiarios, solicitudAhorradorAnversoReverso, fechaFormato, declaracionISR, manifestacionObligacionesFiscales, cumple5AniosFiscales, etiquetaExpedienteFormato4, originalDenunciaPenal, transmisionTitularidad, sentenciaConcursoMercantil, sentenciaQuiebra, certificadoNoAdeudo, cartaLiberacionGarantias, finiquitoPago, montoContratoSesionDerechos, saldo70Ahorro, documentos, documentosNoPresentados FROM segundaVerificacion WHERE ahorrador_idahorrador='".$idahorrador."'";
		$res2=mysql_query($sql2);		
		$fil2=mysql_fetch_assoc($res2);

		foreach($fil1 as $campo => $valor)
		{
			if($fil2[$campo]!=$valor)
				return false;
		}

		$sqlSV="SELECT idsegundaVerificacion FROM segundaVerificacion WHERE ahorrador_idahorrador='".$idahorrador."'";
		$resSV=mysql_query($sqlSV);
		$filSV=mysql_fetch_assoc($resSV);
		$idsegundaVerificacion=$filSV["idsegundaVerificacion"];


		//COMPARO LOS DOCUMENTOS COMPROBATORIOS
		$sqlPV="SELECT idcamposVerificacion FROM primeraVerificacion WHERE ahorrador_idahorrador='".$idahorrador."'";
		$resPV=mysql_query($sqlPV);
		$filPV=mysql_fetch_assoc($resPV);
		$idcamposVerificacion=$filPV["idcamposVerificacion"];

		$sqlDocsP="SELECT * FROM documentosComprobatorios WHERE primeraVerificacion_idcamposVerificacion='".$idcamposVerificacion."'";
		$resDocsP=mysql_query($sqlDocsP);
		while($filDocsP=mysql_fetch_assoc($resDocsP))
		{
			//BUSCO ESTE DOCUMENTO EN LA SEGUNDA VERIFICACION
			$sqlDocsS="SELECT COUNT(*) AS total FROM documentosComprobatoriosSegundaVerificacion WHERE segundaVerificacion_idsegundaVerificacion='".$idsegundaVerificacion."' AND numero='".$filDocsP["numero"]."' AND tipoSaldo='".$filDocsP["tipoSaldo"]."' AND folio='".$filDocsP["folio"]."' AND documento='".$filDocsP["documento"]."' AND monto='".$filDocsP["monto"]."' AND aclaracion='".$filDocsP["aclaracion"]."'";
			$resDocsS=mysql_query($sqlDocsS);
			$filDocsS=mysql_fetch_assoc($resDocsS);
			if($filDocsS["total"]<=0)
				return false;
		}
		//COMPARO LOS DOCUMENTOS COMPROBATORIOS

		return true;
	}

	function dameVerificacion($verificacion,$idahorrador)
	{

		if($verificacion==1)
			$tabla="primeraVerificacion";
		if($verificacion==2)
			$tabla="segundaVerificacion";

		$sql="SELECT * FROM ".$tabla." WHERE ahorrador_idahorrador='".$idahorrador."'";
		$res=mysql_query($sql);
		$fil=mysql_fetch_assoc($res);
		$regresa=$fil;

		return $regresa;
	}



	function dameContenedores()
	{
		global $_REQUEST;

		$idConvenio=$_REQUEST["i"];

		$sql="SELECT * FROM contenedoresTemporales WHERE convenio_idconvenio='".$idConvenio."' AND statusContenedores_idstatusContenedores='3'";
		$res=mysql_query($sql);
		while($fil=mysql_fetch_assoc($res))
		{
			//Obtengo cuantos registros traía el contenedor
			$sql2="SELECT COUNT(*) AS total FROM registrosContenadores WHERE contenedoresTemporales_idcontenedoresTemporales='".$fil["idcontenedoresTemporales"]."'";
			$res2=mysql_query($sql2);
			$fil2=mysql_fetch_assoc($res2);
			$totalRegistros=$fil2["total"];

			$fil[]=$totalRegistros;
			$regresa[]=implode("#",$fil);
		}
		$regresa=implode("|",$regresa);

		echo $regresa;
	}


	function validaDocumentoVerificacion()
	{
		global $_REQUEST;

		$tablasSaldos=array("ps"=>"ahorradorParteSocial","ca"=>"ahorradorCuentasAhorro","ci"=>"ahorradorCuentasInversion","dg"=>"ahorradorDepositosGarantia","cnc"=>"ahorradorChequesNoCobrados","od"=>"ahorradorOtrosDepositos","pc"=>"ahorradorPrestamosCargo");
	    $leyendasTablasSaldos=array("ps"=>"parte social","ca"=>"cuentas de ahorro","ci"=>"cuentas de inversión","dg"=>"depósitos en garantía","cnc"=>"cheques no cobrados","od"=>"otros depósitos","pc"=>"préstamos a cargo");
	    $errores=array();

		$folioIdentificador=$_REQUEST["i"];
		$idAhorrador=dameIdAhorrador($folioIdentificador);
		
		$registro=$_REQUEST["d"];
		$registro=explode(",",$registro); //["numero","tipoSaldo","folio","nombreDocumento","monto"]
		$tipoSaldo=$registro[1];
		$tabla=$tablasSaldos[$tipoSaldo];

		//Valido primero que tenga ese tipo de saldo
		$sql="SELECT * FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."'";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)<=0)
		{
			$errores[]="<span class='error'>El ahorrador no cuenta con saldo en <strong>".$leyendasTablasSaldos[$tipoSaldo]."</strong> y esta indicado en el documento número <strong>".$registro[0]."</strong></span>";
		}
		else
		{
			//Valido que el folio exista
			$sqlFolio="SELECT * FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."' AND folio='".$registro[2]."'";
			$resFolio=mysql_query($sqlFolio);
			if(mysql_num_rows($resFolio)<=0)
			{
				$errores[]="<span class='error'>El folio <strong>".$registro[2]."</strong> indicado en el documento número <strong>".$registro[0]."</strong> no aparece en los registros del ahorrador </span>";
			}
			else
			{
				//Valido el tipo de documento
				$sqlTipoDocumento="SELECT * FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."' AND folio='".$registro[2]."' AND UPPER(tipoDocumento)=UPPER('".$registro[3]."')";
				$resTipoDocumento=mysql_query($sqlTipoDocumento);
				if(mysql_num_rows($resTipoDocumento)<=0)
				{
					$errores[]="<span class='error'>El documento <strong>".$registro[3]."</strong> indicado en el documento número <strong>".$registro[0]."</strong> no coincide con los registros del ahorrador</span>";
				}
				else
				{
					//Valido el monto
					$sqlTipoDocumento="SELECT * FROM ".$tabla." WHERE ahorrador_idahorrador='".$idAhorrador."' AND folio='".$registro[2]."' AND UPPER(tipoDocumento)=UPPER('".$registro[3]."') AND importe='".$registro[4]."'";
					$resTipoDocumento=mysql_query($sqlTipoDocumento);
					if(mysql_num_rows($resTipoDocumento)<=0)
					{
						$errores[]="<span class='error'>El monto <strong>".$registro[4]."</strong> indicado en el documento número <strong>".$registro[0]."</strong> no coincide con el monto del ahorrador registrado</span>";
					}
				}

			}
		}

		if(count($errores)<=0)
			$errores[]="<span class='exito'>El documento número <strong>".$registro[0]."</strong> coincide completamente con los registros del ahorrador </span>";

		$errores=implode("|",$errores);


		echo $errores;
	}


	function muestraDocumentosAceptados()
	{
		global $_REQUEST;		
		$idconvenio=$_REQUEST["i"];

		$options = dameIdDocumentosIdentidad($idconvenio);
		echo "<ul>";
			foreach($options as $key => $opt)		
				echo "<li>".$opt[1]." - ".$opt[2]."</li>";
		echo "</ul>";
		
	}
	function muestraPrimeraDocCompro()
	{
		global $_REQUEST;		
		$idverificacion=$_REQUEST["i"];
		$idverificaciondos=$_REQUEST["y"];

		$sql="select * from documentosComprobatorios
		INNER JOIN primeraVerificacion
     	ON 	documentosComprobatorios.primeraVerificacion_idcamposVerificacion=primeraVerificacion.idcamposVerificacion  where 
     	primeraVerificacion_idcamposVerificacion=".$idverificacion." ";

     	

     	$res=mysql_query($sql);
		#$fil=mysql_fetch_assoc($res);
		echo '<p style="text-align:center;"><span class="titulosRojos">DOCUMENTOS COMPROBATORIOS</span><br>
					<strong>Primera Verficación </strong></p>';
		echo 
		"
		<table style='font-weight: bold; width:100%;'>
		<tr>
									<td style='border: 1px solid;'>No.</td>
									<td style='border: 1px solid;'>Tipo de saldo</td>
									<td style='border: 1px solid;'>Folio</td>
									<td style='border: 1px solid;' >Documento</td>
									<td  style='border: 1px solid;'>Monto</td>
									<td style='border: 1px solid;' >Aclaración</td>
									<td style='border: 1px solid;'>Motivo</td>			
		</tr>
		
		";

		while ($fil=mysql_fetch_assoc($res)) 
		{
				echo "<tr>";
				echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['numero']."</strong> </td>";
				echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['tipoSaldo']."</strong> </td>";
				echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['folio']."</strong> </td>";
				echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['documento']."</strong> </td>";
				echo "<td style='border: 2px solid #da4141;'><strong>".$fil['monto']."</strong> </td>";
				echo "<td style='border: 2px solid #da4141;'> <strong>"; echo $fil['aclaracion']=="1" ? " Si" : " No"; echo "</strong> </td>"; 
				echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['motivo']."</strong> </td>";
				echo "</tr>";
		}

	 echo " </table>";


	 muestraSegundaDocCompro($idverificaciondos);


		
	}
	function muestraSegundaDocCompro($id)
	{
			global $_REQUEST;		
			$idverificacion=$id;
			$sql="select * from documentosComprobatoriosSegundaVerificacion
			INNER JOIN segundaVerificacion
	     	ON 	documentosComprobatoriosSegundaVerificacion.segundaVerificacion_idsegundaVerificacion=segundaVerificacion.idsegundaVerificacion where 
	     	segundaVerificacion_idsegundaVerificacion=".$idverificacion." ";

	     	

	     	$res=mysql_query($sql);
			#$fil=mysql_fetch_assoc($res);
			echo '<p style="text-align:center;"><span class="titulosRojos">DOCUMENTOS COMPROBATORIOS</span><br>
					<strong>Segunda Verficación </strong></p>';
			echo 
			"
			<table style='font-weight: bold; width:100%;'>
			<tr>
										<td style='border: 1px solid;'>No.</td>
										<td style='border: 1px solid;'>Tipo de saldo</td>
										<td style='border: 1px solid;'>Folio</td>
										<td style='border: 1px solid;' >Documento</td>
										<td  style='border: 1px solid;'>Monto</td>
										<td style='border: 1px solid;' >Aclaración</td>
										<td style='border: 1px solid;'>Motivo</td>			
			</tr>
			
			";

			while ($fil=mysql_fetch_assoc($res)) 
			{
					echo "<tr>";
					echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['numero']."</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['tipoSaldo']."</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['folio']."</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['documento']."</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'><strong>".$fil['monto']."</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'> <strong>"; echo $fil['aclaracion']=="1" ? " Si" : " No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #da4141;'> <strong>".$fil['motivo']."</strong> </td>";
					echo "</tr>";
			}

		 echo " </table>";

		
	}

	function buscaLogVerificacion()
	{
		global $_REQUEST;		
		$id=$_REQUEST["i"];
		$va=$_REQUEST["y"];
		#echo "buscando quien hizo la verificacion ".$id." ".$va;
		if ($id==1) {

			echo '<p style="text-align:center;"><span class="titulosRojos">Primera Verificación</span><br>
					</p>';
	
			$sql2="select idAhorrador from ahorrador where  folioIdentificador  like '$va' ";
			#echo $sql2;
			$res2=mysql_query($sql2);
			$fil2=mysql_fetch_assoc($res2);

			$sql="select * from  log inner join primeraVerificacion
			 on  log.id=primeraVerificacion.idcamposVerificacion where tabla like 'primeraVerificacion' and ahorrador_idahorrador=".$fil2['idAhorrador']." limit 1";
			 
			$res=mysql_query($sql);
			$fil=mysql_fetch_assoc($res);

			$sqlLog="SELECT 
						usuarios.nombre AS usuario, 
						actividades.nombre AS actividad,
						log.fecha as fecha 
						FROM log 
						INNER JOIN actividades ON idactividades=actividades_idactividades 
						INNER JOIN usuarios ON idusuarios=usuarios_idusuarios 
						where log.idlog=".$fil['idlog']."
						ORDER BY fecha DESC, idlog DESC";
			#echo $sqlLog;
			$reslog=mysql_query($sqlLog);
			$filLog=mysql_fetch_assoc($reslog);
			echo "<table style='width:100%;'>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'>Usuario </th>
					<th style='border: 2px solid #da4141;'>Fecha</th>
					<th style='border: 2px solid #da4141;' >Actividad</th>
				  </tr>";
			echo "<tr>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['usuario']."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".convierteTimeStampCorto($filLog['fecha'])."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['actividad']."</td>

				</tr>";
			echo "</table>";

			/// tabla nueva detalle de la verificacion 
			echo"<br><br><table style='width:100%;'>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE IDENTIDAD</span></th> </tr>
				<tr>
					<th style='border: 2px solid #da4141;'>	Tipo de Persona</th>
					<th style='border: 2px solid #da4141;'>Caso Atípico</th>
					<th style='border: 2px solid #da4141;' >Documento o credencial que lo acredite como socio</th>
					<th style='border: 2px solid #da4141;' >Fallecido</th>
					<th style='border: 2px solid #da4141;' >Fecha de comprobante de domicilio</th>


				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['tipoPersona']=="1" ? "Fisica" : "Moral"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['casoAtipico']=="1" ? "Si" : "No"; 
					if($fil['casoAtipico']==1){
					 echo "<br> Cédula de Caso Atípico (Formato 8): ";
					 echo $fil['formato8']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}
					 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentoAcrediteSocio']=="1" ? "Si" : "No";
					if($fil['documentoAcrediteSocio']==1){
					 echo "<br> Formato 7: ";
					 echo $fil['formato7']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}

				 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['fallecido']=="1" ? "Si" : "No"; 
	 				if($fil['fallecido']==1){ 
	 				 echo "<br>Copia simple Identificación: ";
					 echo $fil['copiaSimpleIdentificacion']=="1" ? "Si" : "No";
					 echo "<br> Menor de edad: ";
					 echo $fil['menorEdad']=="1" ? "Si" : "No";
					 echo "<br> Comprobante de Edad: ";
					 echo $fil['comprobanteEdad']==1 ? "Si":"No";
					 echo "<br> Comprobante de domicilio: ";
					 echo $fil['comprobanteDomicilio']==1 ? "Si":"No";
					 echo "<br>  Ahorrador Extranjero: ";
					 echo $fil['ahorradorExtranjero']==1 ? "Si":"No";
						 if($fil['ahorradorExtranjero']==1){
						 	 echo "<br>  Ahorrador Extranjero: ";
							 echo $fil['copiaIdentificacionAhorradorExtranjero']==1 ? "Si":"No"; 
						 }else{
						 	echo " ";
						 }
					}else{
						echo " ";
					}



			echo "</strong> </td>";
			echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaComprobanteDomicilio']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";

			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>Menor de Edad</span></th> </tr>";
			   if($fil["menorEdad"]==1){
			   	echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite el estado de interdicción y la tutela </th>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite la adopción del menor </th>
					<th style='border: 2px solid #da4141;' >Copia certificada del acta de nacimiento del menor de edad </th>

					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalEstadoTutela']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalAdopcionMenor']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['copiaCertificadaActaMenorEdad']=="1" ? "Si" : "No"; echo "</strong> </td>";



				echo  "</tr>";
			   }else{
			   	 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
			   }


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>REPRESENTANTE, ALBACEA, HEREDERO O BENEFICIARIO</span></th> </tr>";
				if($fil['representanteLegal']==1){
			echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Representante legal </th>
					<th style='border: 2px solid #da4141;' >Albacea (décimo</th>
					<th style='border: 2px solid #da4141;' >Herederos (décimo primero) </th>
					<th style='border: 2px solid #da4141;' >Beneficiario (décimo segundo) </th>


					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['representanteLegal']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['albaceaDecimo']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['herederosDecimoPrimero']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['beneficiarioDecimoSegundo']=="1" ? "Si" : "No"; echo "</strong> </td>";




				echo  "</tr>";

				}else{

				 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
				
				}


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>FORMATOS DE IDENTIDAD</span></th> </tr>";

			echo "<tr>
					
					<th style='border: 2px solid #da4141;'>Solicitud del ahorrador</th>
					<th style='border: 2px solid #da4141;' >Fecha del formato</th>
					<th style='border: 2px solid #da4141;' >Declaración ISR</th>
					<th style='border: 2px solid #da4141;' colspan='2'>Manifestación de cumplimiento de obligaciones fiscales</th>

				  </tr>";
			echo "<tr>";
				
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['solicitudAhorradorAnversoReverso']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaFormato']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['declaracionISR']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['manifestacionObligacionesFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'  colspan='3'>Entre la declaración ISR y la manifestación de obligaciones fiscales se cubren los últimos 5 años </th>
					<th style='border: 2px solid #da4141;'  colspan='2'>Etiqueta de Sobre de Expediente Individual de Ahorrador (Formato 4)</th>
				  </tr>";
			echo "<tr>";
			
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='3'> <strong>"; echo $fil['cumple5AniosFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['etiquetaExpedienteFormato4']=="1" ? "Si" : "No"; echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE VALOR</span></th> </tr>";

			echo "<tr>
					<th style='border: 2px solid #da4141;'>Finiquito de pago</th>
					<th style='border: 2px solid #da4141;'>Entregando físicamente documentos por </th>
					<th style='border: 2px solid #da4141;' >Documentos no presentados (formato 7) 	</th>
					<th style='border: 2px solid #da4141;' >El 70% del saldo neto de ahorro o el monto máximo a pagar </th>
					<th style='border: 2px solid #da4141;' >Contrato de cesión de derechos del ahorrador</th>
				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo  separarMiles($fil['finiquitoPago']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentos']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentosNoPresentados']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'>  <strong>"; echo separarMiles($fil['saldo70Ahorro']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' > <strong>"; echo separarMiles($fil['montoContratoSesionDerechos']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";

			echo "</table>";


			//detalle de la verificacion  documentos comrpobatorios
			$sqldetalle="select * from documentosComprobatorios
			INNER JOIN primeraVerificacion
	     	ON 	documentosComprobatorios.primeraVerificacion_idcamposVerificacion=primeraVerificacion.idcamposVerificacion  where 
	     	primeraVerificacion_idcamposVerificacion=".$fil['idcamposVerificacion']." ";

     		$resdetalle=mysql_query($sqldetalle);

			echo '<p style="text-align:center;"><span class="titulosRojos">DOCUMENTOS COMPROBATORIOS</span><br>
					<strong>Primera Verficación </strong></p>';
			echo "<table style='font-weight:bold; width:100%;'>";
			echo '<tr>
									<th style="border: 2px solid #da4141;">No.</th>
									<th style="border: 2px solid #da4141;">Tipo de saldo</th>
									<th style="border: 2px solid #da4141;">Folio</th>
									<th style="border: 2px solid #da4141;">Documento</th>
									<th style="border: 2px solid #da4141;">Monto</th>
									<th style="border: 2px solid #da4141;">Aclaración</th>
									<th style="border: 2px solid #da4141;">Motivo</th>			
				</tr> ';
			while ($fildetalle=mysql_fetch_assoc($resdetalle)) 
			{
					echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['numero']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['tipoSaldo']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['folio']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['documento']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'><strong>".$fildetalle['monto']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fildetalle['aclaracion']=="1" ? " Si" : " No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['motivo']."</strong> </td>";
					echo "</tr>";
			}

			echo "</table>";


		
		}elseif($id==2)
		{
			echo '<p style="text-align:center;"><span class="titulosRojos">Segunda Verificación</span><br>
					</p>';
	
			$sql2="select idAhorrador from ahorrador where  folioIdentificador  like '$va' ";
			#echo $sql2;
			$res2=mysql_query($sql2);
			$fil2=mysql_fetch_assoc($res2);

			$sql="select * from  log inner join segundaVerificacion
			 on  log.id=segundaVerificacion.idsegundaVerificacion where tabla like 'segundaVerificacion' and ahorrador_idahorrador=".$fil2['idAhorrador']." limit 1";
			 #echo "<br>".$sql;
			$res=mysql_query($sql);
			$fil=mysql_fetch_assoc($res);

			$sqlLog="SELECT 
						usuarios.nombre AS usuario, 
						actividades.nombre AS actividad,
						log.fecha as fecha 
						FROM log 
						INNER JOIN actividades ON idactividades=actividades_idactividades 
						INNER JOIN usuarios ON idusuarios=usuarios_idusuarios 
						where log.idlog=".$fil['idlog']."
						ORDER BY fecha DESC, idlog DESC";
				#echo $sqlLog;
			$reslog=mysql_query($sqlLog);
			$filLog=mysql_fetch_assoc($reslog);
			echo "<table style='width:100%;'>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'>Usuario </th>
					<th style='border: 2px solid #da4141;'>Fecha</th>
					<th style='border: 2px solid #da4141;' >Actividad</th>
				  </tr>";
			echo "
				<tr>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['usuario']."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".convierteTimeStampCorto($filLog['fecha'])."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['actividad']."</td>
				</tr>";
			echo "</table>";

					/// tabla nueva detalle de la verificacion 
			echo"<br><br><table style='width:100%;'>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE IDENTIDAD</span></th> </tr>
				<tr>
					<th style='border: 2px solid #da4141;'>	Tipo de Persona</th>
					<th style='border: 2px solid #da4141;'>Caso Atípico</th>
					<th style='border: 2px solid #da4141;' >Documento o credencial que lo acredite como socio</th>
					<th style='border: 2px solid #da4141;' >Fallecido</th>
					<th style='border: 2px solid #da4141;' >Fecha de comprobante de domicilio</th>


				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['tipoPersona']=="1" ? "Fisica" : "Moral"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['casoAtipico']=="1" ? "Si" : "No"; 
					if($fil['casoAtipico']==1){
					 echo "<br> Cédula de Caso Atípico (Formato 8): ";
					 echo $fil['formato8']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}
					 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentoAcrediteSocio']=="1" ? "Si" : "No";
					if($fil['documentoAcrediteSocio']==1){
					 echo "<br> Formato 7: ";
					 echo $fil['formato7']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}

				 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['fallecido']=="1" ? "Si" : "No"; 
	 				if($fil['fallecido']==1){ 
	 				 echo "<br>Copia simple Identificación: ";
					 echo $fil['copiaSimpleIdentificacion']=="1" ? "Si" : "No";
					 echo "<br> Menor de edad: ";
					 echo $fil['menorEdad']=="1" ? "Si" : "No";
					 echo "<br> Comprobante de Edad: ";
					 echo $fil['comprobanteEdad']==1 ? "Si":"No";
					 echo "<br> Comprobante de domicilio: ";
					 echo $fil['comprobanteDomicilio']==1 ? "Si":"No";
					 echo "<br>  Ahorrador Extranjero: ";
					 echo $fil['ahorradorExtranjero']==1 ? "Si":"No";
						 if($fil['ahorradorExtranjero']==1){
						 	 echo "<br>  Ahorrador Extranjero: ";
							 echo $fil['copiaIdentificacionAhorradorExtranjero']==1 ? "Si":"No"; 
						 }else{
						 	echo " ";
						 }
					}else{
						echo " ";
					}



			echo "</strong> </td>";
			echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaComprobanteDomicilio']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";

			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>Menor de Edad</span></th> </tr>";
			   if($fil["menorEdad"]==1){
			   	echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite el estado de interdicción y la tutela </th>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite la adopción del menor </th>
					<th style='border: 2px solid #da4141;' >Copia certificada del acta de nacimiento del menor de edad </th>

					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalEstadoTutela']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalAdopcionMenor']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['copiaCertificadaActaMenorEdad']=="1" ? "Si" : "No"; echo "</strong> </td>";



				echo  "</tr>";
			   }else{
			   	 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
			   }


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>REPRESENTANTE, ALBACEA, HEREDERO O BENEFICIARIO</span></th> </tr>";
				if($fil['representanteLegal']==1){
			echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Representante legal </th>
					<th style='border: 2px solid #da4141;' >Albacea (décimo</th>
					<th style='border: 2px solid #da4141;' >Herederos (décimo primero) </th>
					<th style='border: 2px solid #da4141;' >Beneficiario (décimo segundo) </th>


					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['representanteLegal']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['albaceaDecimo']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['herederosDecimoPrimero']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['beneficiarioDecimoSegundo']=="1" ? "Si" : "No"; echo "</strong> </td>";




				echo  "</tr>";

				}else{

				 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
				
				}


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>FORMATOS DE IDENTIDAD</span></th> </tr>";

			echo "<tr>
					
					<th style='border: 2px solid #da4141;'>Solicitud del ahorrador</th>
					<th style='border: 2px solid #da4141;' >Fecha del formato</th>
					<th style='border: 2px solid #da4141;' >Declaración ISR</th>
					<th style='border: 2px solid #da4141;' colspan='2'>Manifestación de cumplimiento de obligaciones fiscales</th>

				  </tr>";
			echo "<tr>";
				
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['solicitudAhorradorAnversoReverso']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaFormato']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['declaracionISR']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['manifestacionObligacionesFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'  colspan='3'>Entre la declaración ISR y la manifestación de obligaciones fiscales se cubren los últimos 5 años </th>
					<th style='border: 2px solid #da4141;'  colspan='2'>Etiqueta de Sobre de Expediente Individual de Ahorrador (Formato 4)</th>
				  </tr>";
			echo "<tr>";
			
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='3'> <strong>"; echo $fil['cumple5AniosFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['etiquetaExpedienteFormato4']=="1" ? "Si" : "No"; echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE VALOR</span></th> </tr>";

			echo "<tr>
					<th style='border: 2px solid #da4141;'>Finiquito de pago</th>
					<th style='border: 2px solid #da4141;'>Entregando físicamente documentos por </th>
					<th style='border: 2px solid #da4141;' >Documentos no presentados (formato 7) 	</th>
					<th style='border: 2px solid #da4141;' >El 70% del saldo neto de ahorro o el monto máximo a pagar </th>
					<th style='border: 2px solid #da4141;' >Contrato de cesión de derechos del ahorrador</th>
				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo  separarMiles($fil['finiquitoPago']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentos']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentosNoPresentados']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'>  <strong>"; echo separarMiles($fil['saldo70Ahorro']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' > <strong>"; echo separarMiles($fil['montoContratoSesionDerechos']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";

			echo "</table>";


			//detalle de la verificacion 
			$sqldetalle="select * from documentosComprobatoriosSegundaVerificacion
			INNER JOIN segundaVerificacion
	     	ON 	documentosComprobatoriosSegundaVerificacion.segundaVerificacion_idsegundaVerificacion=segundaVerificacion.idsegundaVerificacion where 
	     	segundaVerificacion_idsegundaVerificacion=".$fil['idsegundaVerificacion']." ";
	     	#echo $sqldetalle;

     		$resdetalle=mysql_query($sqldetalle);

			echo '<p style="text-align:center;"><span class="titulosRojos">DOCUMENTOS COMPROBATORIOS</span><br>
					<strong>Segunda  Verficación </strong></p>';
			echo "<table style='font-weight:bold; width:100%;'>";
			echo '<tr>
									<th style="border: 2px solid #da4141;">No.</th>
									<th style="border: 2px solid #da4141;">Tipo de saldo</th>
									<th style="border: 2px solid #da4141;">Folio</th>
									<th style="border: 2px solid #da4141;">Documento</th>
									<th style="border: 2px solid #da4141;">Monto</th>
									<th style="border: 2px solid #da4141;">Aclaración</th>
									<th style="border: 2px solid #da4141;">Motivo</th>			
				</tr>';
			while ($fildetalle=mysql_fetch_assoc($resdetalle)) 
			{
					echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['numero']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['tipoSaldo']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['folio']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['documento']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'><strong>".$fildetalle['monto']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fildetalle['aclaracion']=="1" ? " Si" : " No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['motivo']."</strong> </td>";
					echo "</tr>";
			}

			echo "</table>";
		}elseif ($id==3) {

			echo '<p style="text-align:center;"><span class="titulosRojos">Verificación Final</span><br>
					</p>';
	
			$sql2="select idAhorrador from ahorrador where  folioIdentificador  like '$va' ";
			
			$res2=mysql_query($sql2);
			$fil2=mysql_fetch_assoc($res2);

			$sql="select * from  log inner join verificacionFinal
			 on  log.id=verificacionFinal.idverificacionFinal where tabla like 'verificacionFinal' and ahorrador_idahorrador=".$fil2['idAhorrador']." limit 1";
			 
			$res=mysql_query($sql);
			$fil=mysql_fetch_assoc($res);

			$sqlLog="SELECT 
						usuarios.nombre AS usuario, 
						actividades.nombre AS actividad,
						log.fecha as fecha 
						FROM log 
						INNER JOIN actividades ON idactividades=actividades_idactividades 
						INNER JOIN usuarios ON idusuarios=usuarios_idusuarios 
						where log.idlog=".$fil['idlog']."
						ORDER BY fecha DESC, idlog DESC";
				
			$reslog=mysql_query($sqlLog);
			$filLog=mysql_fetch_assoc($reslog);
			echo "<table style='width:100%;'>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'>Usuario </th>
					<th style='border: 2px solid #da4141;'>Fecha</th>
					<th style='border: 2px solid #da4141;' >Actividad</th>
				  </tr>";
			echo "<tr>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['usuario']."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".convierteTimeStampCorto($filLog['fecha'])."</td>
				  <td style='border: 2px solid #030303; text-align: center;'>".$filLog['actividad']."</td>

				</tr>";
			echo "</table>";
			/// tabla nueva detalle de la verificacion 
			echo"<br><br><table style='width:100%;'>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE IDENTIDAD</span></th> </tr>
				<tr>
					<th style='border: 2px solid #da4141;'>	Tipo de Persona</th>
					<th style='border: 2px solid #da4141;'>Caso Atípico</th>
					<th style='border: 2px solid #da4141;' >Documento o credencial que lo acredite como socio</th>
					<th style='border: 2px solid #da4141;' >Fallecido</th>
					<th style='border: 2px solid #da4141;' >Fecha de comprobante de domicilio</th>


				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['tipoPersona']=="1" ? "Fisica" : "Moral"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['casoAtipico']=="1" ? "Si" : "No"; 
					if($fil['casoAtipico']==1){
					 echo "<br> Cédula de Caso Atípico (Formato 8): ";
					 echo $fil['formato8']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}
					 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentoAcrediteSocio']=="1" ? "Si" : "No";
					if($fil['documentoAcrediteSocio']==1){
					 echo "<br> Formato 7: ";
					 echo $fil['formato7']=="1" ? "Si" : "No";
					}
					else{
					 echo " "; 
					}

				 echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['fallecido']=="1" ? "Si" : "No"; 
	 				if($fil['fallecido']==1){ 
	 				 echo "<br>Copia simple Identificación: ";
					 echo $fil['copiaSimpleIdentificacion']=="1" ? "Si" : "No";
					 echo "<br> Menor de edad: ";
					 echo $fil['menorEdad']=="1" ? "Si" : "No";
					 echo "<br> Comprobante de Edad: ";
					 echo $fil['comprobanteEdad']==1 ? "Si":"No";
					 echo "<br> Comprobante de domicilio: ";
					 echo $fil['comprobanteDomicilio']==1 ? "Si":"No";
					 echo "<br>  Ahorrador Extranjero: ";
					 echo $fil['ahorradorExtranjero']==1 ? "Si":"No";
						 if($fil['ahorradorExtranjero']==1){
						 	 echo "<br>  Ahorrador Extranjero: ";
							 echo $fil['copiaIdentificacionAhorradorExtranjero']==1 ? "Si":"No"; 
						 }else{
						 	echo " ";
						 }
					}else{
						echo " ";
					}



			echo "</strong> </td>";
			echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaComprobanteDomicilio']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";

			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>Menor de Edad</span></th> </tr>";
			   if($fil["menorEdad"]==1){
			   	echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite el estado de interdicción y la tutela </th>
					<th style='border: 2px solid #da4141;' colspan='2'>Original del documento judicial que acredite la adopción del menor </th>
					<th style='border: 2px solid #da4141;' >Copia certificada del acta de nacimiento del menor de edad </th>

					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalEstadoTutela']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['originalAdopcionMenor']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['copiaCertificadaActaMenorEdad']=="1" ? "Si" : "No"; echo "</strong> </td>";



				echo  "</tr>";
			   }else{
			   	 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
			   }


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>REPRESENTANTE, ALBACEA, HEREDERO O BENEFICIARIO</span></th> </tr>";
				if($fil['representanteLegal']==1){
			echo "
			   	<tr>
					<th style='border: 2px solid #da4141;' colspan='2'>Representante legal </th>
					<th style='border: 2px solid #da4141;' >Albacea (décimo</th>
					<th style='border: 2px solid #da4141;' >Herederos (décimo primero) </th>
					<th style='border: 2px solid #da4141;' >Beneficiario (décimo segundo) </th>


					 </tr>";
				echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['representanteLegal']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['albaceaDecimo']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['herederosDecimoPrimero']=="1" ? "Si" : "No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['beneficiarioDecimoSegundo']=="1" ? "Si" : "No"; echo "</strong> </td>";




				echo  "</tr>";

				}else{

				 echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span></th></tr>";
				
				}


			echo "</tr>  <tr> <td colspan='5'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>FORMATOS DE IDENTIDAD</span></th> </tr>";

			echo "<tr>
					
					<th style='border: 2px solid #da4141;'>Solicitud del ahorrador</th>
					<th style='border: 2px solid #da4141;' >Fecha del formato</th>
					<th style='border: 2px solid #da4141;' >Declaración ISR</th>
					<th style='border: 2px solid #da4141;' colspan='2'>Manifestación de cumplimiento de obligaciones fiscales</th>

				  </tr>";
			echo "<tr>";
				
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['solicitudAhorradorAnversoReverso']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo convierteTimeStampCorto($fil['fechaFormato']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['declaracionISR']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['manifestacionObligacionesFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
			echo "<tr>
					<th style='border: 2px solid #da4141;'  colspan='3'>Entre la declaración ISR y la manifestación de obligaciones fiscales se cubren los últimos 5 años </th>
					<th style='border: 2px solid #da4141;'  colspan='2'>Etiqueta de Sobre de Expediente Individual de Ahorrador (Formato 4)</th>
				  </tr>";
			echo "<tr>";
			
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='3'> <strong>"; echo $fil['cumple5AniosFiscales']=="1" ? "Si" : "No"; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' colspan='2'> <strong>"; echo $fil['etiquetaExpedienteFormato4']=="1" ? "Si" : "No"; echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";
			echo "<tr> <th  style='border: 2px solid #da4141;' colspan='5'><span class='titulosRojos'>DOCUMENTOS DE VALOR</span></th> </tr>";

			echo "<tr>
					<th style='border: 2px solid #da4141;'>Finiquito de pago</th>
					<th style='border: 2px solid #da4141;'>Entregando físicamente documentos por </th>
					<th style='border: 2px solid #da4141;' >Documentos no presentados (formato 7) 	</th>
					<th style='border: 2px solid #da4141;' >El 70% del saldo neto de ahorro o el monto máximo a pagar </th>
					<th style='border: 2px solid #da4141;' >Contrato de cesión de derechos del ahorrador</th>
				  </tr>";
			echo "<tr>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo  separarMiles($fil['finiquitoPago']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentos']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fil['documentosNoPresentados']; echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;'>  <strong>"; echo separarMiles($fil['saldo70Ahorro']); echo "</strong> </td>";
				echo "<td style='border: 2px solid #030303; text-align: center;' > <strong>"; echo separarMiles($fil['montoContratoSesionDerechos']); echo "</strong> </td>";

			echo "</tr>  <tr> <td colspan='4'>&nbsp; </td></tr>";

			echo "</table>";






			//detalle de la verificacion 
			$sqldetalle="select * from documentosComprobatoriosVerificacionFinal
			INNER JOIN verificacionFinal
	     	ON 	documentosComprobatoriosVerificacionFinal.iddocumentosComprobatoriosVerificacionFinal=verificacionFinal.idverificacionFinal where 
	     	verificacionFinal.idverificacionFinal=".$fil['idverificacionFinal']." ";
	     	#echo $sqldetalle;

     		$resdetalle=mysql_query($sqldetalle);

			echo '<p style="text-align:center;"><span class="titulosRojos">DOCUMENTOS COMPROBATORIOS</span><br>
					<strong>Verficación Final </strong></p>';
			echo "<table style='font-weight:bold; width:100%;'>";
			echo '<tr>
									<th style="border: 2px solid #da4141;">No.</th>
									<th style="border: 2px solid #da4141;">Tipo de saldo</th>
									<th style="border: 2px solid #da4141;">Folio</th>
									<th style="border: 2px solid #da4141;">Documento</th>
									<th style="border: 2px solid #da4141;">Monto</th>
									<th style="border: 2px solid #da4141;">Aclaración</th>
									<th style="border: 2px solid #da4141;">Motivo</th>			
				</tr>';
			while ($fildetalle=mysql_fetch_assoc($resdetalle)) 
			{
					echo "<tr>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['numero']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['tipoSaldo']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['folio']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['documento']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'><strong>".$fildetalle['monto']."</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>"; echo $fildetalle['aclaracion']=="1" ? " Si" : " No"; echo "</strong> </td>";
					echo "<td style='border: 2px solid #030303; text-align: center;'> <strong>".$fildetalle['motivo']."</strong> </td>";
					echo "</tr>";
			}

			echo "</table>";
			
		}
		

	}

	function muestraPantalla()
	{
		global $_REQUEST;		
		$pantalla=$_REQUEST["p"];

		$folioIdentificador=$_REQUEST["i"];
		$idahorrador=dameIdAhorrador($folioIdentificador);

		



		switch ($pantalla) 
		{
			case "1":
				muestraPantallaUno(); //Datos generales del ahorrador
			break;

			case "2":
				muestraPantallaDos(); //Documentos
			break;

			// case "3":
			// 	muestraPantallaTres(); //Documentos de representante legal
			// break;

			// case "4":
			// 	muestraPantallaCuatro(); //Documentos de menor de edad
			// break;


			// case "5":
			// 	muestraPantallaCinco(); //Documentos de Albacea/Heredero/Beneficiario
			// break;
		}
	}


	function muestraPantallaUno()//Datos generales del ahorrador
	{
		global $_REQUEST;
		$folioIdentificador=$_REQUEST["i"];

		$sql="SELECT 
				* 
				FROM 
				ahorrador INNER JOIN convenio_has_ahorrador ON ahorrador_idahorrador=idahorrador 
				INNER JOIN convenio ON convenio_idconvenio=idconvenio 
				WHERE folioIdentificador='".$folioIdentificador."'";
		$res=mysql_query($sql);
		$fil=mysql_fetch_assoc($res);
		// foreach($fil as $k => $v)
		// 	echo $k." -> ".$v."<br>";

		if(!ahorradorMinistrado($fil["folioIdentificador"]))
		{
			echo "EL AHORRADOR <strong>".$fil["nombre"]."</strong> NO HA SIDO MINISTRADO";
			die;
		}
		
		//VALIDO PRIMERO SI ESTA MINISTRADO Y VENÍA EN UN CONTENEDOR
		$sqlContAho="SELECT * FROM registrosContenadores INNER JOIN contenedoresTemporales ON idcontenedoresTemporales=contenedoresTemporales_idcontenedoresTemporales WHERE folioIdentificador='".$folioIdentificador."' AND statusContenedores_idstatusContenedores=3";
		//echo $sql."<br>";
		$resContAho=mysql_query($sqlContAho);
		if(mysql_num_rows($resContAho)<=0)
		{
			echo "EL AHORRADOR <strong>".$fil["nombre"]."</strong> NO HA SIDO ENVIADO EN ALGÚN CONTENEDOR";
			die;
		}
		//VALIDO PRIMERO SI ESTA MINISTRADO Y VENÍA EN UN CONTENEDOR

		
		//TOMO EL CONTENEDOR EN DONDE VENÍA EL AHORRADOR
			$filContAho=mysql_fetch_assoc($resContAho);
			$contenedorAhorrador=$filContAho["contenedorNo"];
		//TOMO EL CONTENEDOR EN DONDE VENÍA EL AHORRADOR



		$claveSociedad=ltrim(substr($fil["folioIdentificador"],2,3),"0");
		$montoMaximo=$fil["montoMaximo"];

		$saldoPendiente=round(dameSaldoParaMinistrarAhorrador($fil["folioIdentificador"]),2);
		$saldoMinistrado=round($montoMaximo-$saldoPendiente,2);
		$registroMinistraciones=dameRegistroMinistraciones($fil["folioIdentificador"]);

		?>
		<br>

		<div style="color:#FFFFFF; width: 60%; height: 27px; background-color: #FF6666; margin: 0 auto; margin-top: -25px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 10px; padding-top: 4px;"> 
			<?php echo $fil["nombre"]." - <strong>".$folioIdentificador."</strong>"; ?>
		</div>

		<table class="tablaPantallas">

			<tr style="font-weight: bold;">
				<td>Contenedor No.</td>
				<td>Fecha de subida del contenedor</td>
				<td>Oficio</td>
				<td>Fecha de oficio del contenedor</td>
			</tr>
			<tr>
				<td><?php echo $contenedorAhorrador; ?></td>
				<td><?php echo convierteTimeStampCorto($filContAho["fecha"]); ?></td>
				<td><?php echo filContAho["oficio"]; ?></td>
				<td><?php echo convierteTimeStampCorto($filContAho["fechaOficio"]); ?></td>
			</tr>
		</table>
		<br><br>


		<table class="tablaPantallas">
			<tr style="font-weight: bold;">
				<td>Estado</td>
				<td>Convenio</td>
				<td>Sociedad</td>
				<td>Nombre ahorrador</td>
			</tr>
			<tr>
				<td><?php echo dameNombreEstadoConvenio($fil["idconvenio"]); ?></td>
				<td><?php echo convierteTimeStampCorto($fil["fechaFirma"])." - $ ".separarMiles($fil["montoTotalConvenio"]); ?></td>
				<td><?php echo dameNombreSociedad($claveSociedad); ?></td>
				<td><?php echo $fil["nombre"]; ?></td>
			</tr>
			<tr class="sinBorde"><td colspan="4">&nbsp;</td></tr>
			<tr style="font-weight: bold;">
				<td>Saldo neto al 100%</td>
				<td>Saldo neto al 70%</td>
				<td>Monto máximo de pago</td>
				<td>Total ministrado</td>
			</tr>
			<tr>
				<td><?php echo "$ ".separarMiles($fil["montoAl100"]); ?></td>
				<td><?php echo "$ ".separarMiles($fil["montoAl70"]); ?></td>
				<td><?php echo "$ ".separarMiles($fil["montoMaximo"]); ?></td>
				<td><?php echo "$ ".separarMiles($saldoMinistrado); ?></td>
				
			</tr>
		</table>

		<br><br>

		<table class="tablaPantallas">
			<tr style="font-weight: bold;">
				<td>Parte social</td>
				<td>Cuentas de ahorro</td>
				<td>Cuentas de inversión</td>
				<td>Depósitos en garantía</td>
				<td>Cheques no cobrados</td>
				<td>Otros depósitos</td>
				<td>Préstamos a cargo</td>				
			</tr>
			<tr>
				<td>$ <?php echo separarMiles($fil["sps"]);?></td>
				<td>$ <?php echo separarMiles($fil["sca"]);?></td>
				<td>$ <?php echo separarMiles($fil["sci"]);?></td>
				<td>$ <?php echo separarMiles($fil["sdg"]);?></td>
				<td>$ <?php echo separarMiles($fil["scnc"]);?></td>
				<td>$ <?php echo separarMiles($fil["sod"]);?></td>
				<td>$ <?php echo separarMiles($fil["spc"]);?></td>
			</tr>

			<tr class="sinBorde"><td colspan="7">&nbsp;</td></tr>

			<tr>
				<td colspan="7" style="font-weight: bold;">
					Representante legal o Albacea o Heredero o Beneficiario (Formato 3)
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<?php 
						echo $registroMinistraciones["representanteAlbacea"]!="" ? $registroMinistraciones["representanteAlbacea"] : " --- "; 
					?>
				</td>
			</tr>

			<tr class="sinBorde"><td colspan="7">&nbsp;</td></tr>

			<tr>
				<td colspan="7" style="font-weight: bold;">
					<?php 
						echo "Publicado en el DOF el ".convierteTimeStamp($fil["fechaDOF"]); 
						echo "<input type='hidden' id='fechaPublicadoDOF' value='".$fil["fechaDOF"]."' >"; 
					?>
				</td>
			</tr>
			<tr>
				<td colspan="7">
					<a href="<?php echo "../convDofFiles/".$fil["pdfDOF"];?>" class="enlaces" target="blank">
						<img src="../img/fileIcon.png" width="50px"/>
						<br>
						DESCARGAR
					</a>
				</td>
			</tr>


		</table>
		<?php
	}



	function muestraPantallaDos() //Documentos de identidad
	{
		global $_REQUEST;

		$folioIdentificador=$_REQUEST["i"];
		$idahorrador=dameIdAhorrador($folioIdentificador);
		$registroMinistraciones=dameRegistroMinistraciones($folioIdentificador);
		$convenio=dameConvenioAhorrador($folioIdentificador);
		$sociedad=dameSociedadAhorrador($folioIdentificador);
		$sql="SELECT 
				* 
				FROM 
				ahorrador INNER JOIN convenio_has_ahorrador ON ahorrador_idahorrador=idahorrador 
				INNER JOIN convenio ON convenio_idconvenio=idconvenio 
				WHERE folioIdentificador='".$folioIdentificador."'";
		$res=mysql_query($sql);
		$ahorrador=mysql_fetch_assoc($res);

		if(!ahorradorMinistrado($folioIdentificador))
		{			
			die;
		}
		
		//VALIDO PRIMERO SI ESTA MINISTRADO Y VENÍA EN UN CONTENEDOR
		$sql="SELECT * FROM registrosContenadores INNER JOIN contenedoresTemporales ON idcontenedoresTemporales=contenedoresTemporales_idcontenedoresTemporales WHERE folioIdentificador='".$folioIdentificador."' AND statusContenedores_idstatusContenedores=3";
		$res=mysql_query($sql);
		if(mysql_num_rows($res)<=0)
		{
			die;
		}




		?>	
		<form id="formularioInformacionParcial" >
		<!-- <form id="formularioInformacionParcial" action="functions.php" method="get"> -->
				<div style="color:#FFFFFF; width: 60%; height: 27px; background-color: #FF6666; margin: 0 auto; margin-top: -42px; border-top-left-radius: 10px; border-top-right-radius: 10px; border-bottom: 10px; padding-top: 4px;"> 
					<?php
						if(!seHizoPrimeraVerificacion($idahorrador))
						{
							echo "PRIMERA VERIFICACIÓN";
						}
						else if(!seHizoSegundaVerificacion($idahorrador))
						{
							echo "SEGUNDA VERIFICACIÓN";
						}
						else if(seHizoSegundaVerificacion($idahorrador))
						{				
							$primera=dameVerificacion(1,$idahorrador);
							$segunda=dameVerificacion(2,$idahorrador);

							if(!coincidenVerificaciones($folioIdentificador))	
							{						
								echo "LAS VERIFICACIONES REALIZADAS NO COINCIDEN";
							}
							else
							{
								echo "AMBAS VERIFICACIONES COINCIDEN";
							}
							
						}
					?>
				</div>

				<div id="divDocumentosIdentidad" style="display:block;">
							<span class='titulosRojos'>DOCUMENTOS DE IDENTIDAD</span>
							<br><br>
							<span class="enlaces" onclick="muestraDraggable(1,'<?php echo $convenio["idconvenio"]; ?>');">
								<img src="../img/showIcon.png" width="40px; margin-top:3px", style="cursor:pointer;" />
								<br>
								MOSTRAR LISTA DE DOCUMENTOS ACEPTADOS
							</span>
							<br><br>


							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Tipo de persona (ahorrador)
									</td>
									<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
										<select name="tipoPersona" required>
												<option value=""></option>
												<option value="fisica">Física</option>
												<option value="moral">Moral</option>
										</select>										
									</td>
									<?php
								 
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["tipoPersona"]=="1" ? " Física" : " Moral "; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["tipoPersona"]=="1" ? " Física" : " Moral ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>

							</table>
							
							









							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Caso atípico
									</td>
									<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
										<input type="radio" required="true" id="casoAtipico" name="casoAtipico" value="1" onclick="evaluaYMuestra(this,'divDocumentoFormato8','','formato8');" >Si<br>
										<input type="radio" required="true" id="casoAtipico" name="casoAtipico" value="0" onclick="evaluaYMuestra(this,'divDocumentoFormato8','','formato8');">No
									</td>
									<?php
									
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["casoAtipico"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["casoAtipico"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
							<div id="divDocumentoFormato8" class="oculta subelemento">
								<table class="tablaPantallas sinBorde ">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Cédula de Caso Atípico (Formato 8)
										</td>
										<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
											<input type="radio" id="formato8" name="formato8" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="formato8"  name="formato8" value="0" >No
										</td>
									<?php
									
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["formato8"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["formato8"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>										

									</tr>
								</table>
							</div>
							



							<br><br>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Documento o credencial que lo acredite como socio
									</td>
									<td align="left"  <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
										<!-- <select name="credencialSocio" required="true" onchange="" ="evaluaYMuestra(this,'divDocumentoFormato7','inversa','formato7');">
											<option value=''>---</option>
											<option value='1'>SI</option>
											<option value='0'>NO</option>
										</select> -->
										<input type="radio" required id="credencialSocio" name="credencialSocio" value="1" onclick="evaluaYMuestra(this,'divDocumentoFormato7','inversa','formato7');">Si<br>
										<input type="radio" required id="credencialSocio" name="credencialSocio" value="0" onclick="evaluaYMuestra(this,'divDocumentoFormato7','inversa','formato7');">No
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["documentoAcrediteSocio"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["documentoAcrediteSocio"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
							<div id="divDocumentoFormato7" class="oculta subelemento">
								<table class="tablaPantallas sinBorde ">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Formato 7
										</td>
										<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?> >
											<input type="radio" id="formato7" name="formato7" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="formato7"  name="formato7" value="0" >No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["formato7"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["formato7"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>										
									</tr>
								</table>
							</div>




							<br><br>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Fallecido
									</td>
									<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
										<input type="radio" required id="fallecido" name="fallecido" value="1" onclick="evaluaYMuestra(this,'divNoFallecido','inversa','copiaSimpleIdentificacion,comprobanteDeEdad,menorDeEdad,comprobanteDomicilio,ahorradorExtranjero');">Si<br>
										<input type="radio" required id="fallecido" name="fallecido" value="0" onclick="evaluaYMuestra(this,'divNoFallecido','inversa','copiaSimpleIdentificacion,comprobanteDeEdad,menorDeEdad,comprobanteDomicilio,ahorradorExtranjero');">No
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["fallecido"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["fallecido"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>										
								</tr>
							</table>
							<div id="divNoFallecido" class="oculta subelemento">
								<table class="tablaPantallas sinBorde ">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Copia simple Identificación (verificar sello)
										</td>
										<td align="left">
											<input type="radio" id="copiaSimpleIdentificacion" name="copiaSimpleIdentificacion" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="copiaSimpleIdentificacion"  name="copiaSimpleIdentificacion" value="0" >No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["copiaSimpleIdentificacion"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["copiaSimpleIdentificacion"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>																	
									</tr>
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Menor de edad
										</td>
										<td align="left">
											<input type="radio" id="menorDeEdad"  name="menorDeEdad" value="1"  onclick="evaluaMenorDeEdad(this);">Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="menorDeEdad"  name="menorDeEdad" value="0"  onclick="evaluaMenorDeEdad(this);">No
										</td>
										<?php
											
											if(seHizoSegundaVerificacion($idahorrador))
											{
												?>	
												<td align="left">
													Primera verificación: 
													<strong>
														<?php 
															echo $primera["menorEdad"]=="1" ? " Si" : " No"; 
														?>
													</strong>
												</td>
												<td align="left">
													Segunda verificación: 
													<strong>
														<?php echo $segunda["menorEdad"]=="1" ? " Si" : " No ";  ?>													
													</strong>
												</td>												
												<?php
											}
										?>											
									</tr>
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Comprobante de Edad (verificar sello)
										</td>
										<td align="left">
											<input type="radio" id="comprobanteDeEdad" name="comprobanteDeEdad" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="comprobanteDeEdad"  name="comprobanteDeEdad" value="0" >No
										</td>
										<?php
											
											if(seHizoSegundaVerificacion($idahorrador))
											{
												?>	
												<td align="left">
													Primera verificación: 
													<strong>
														<?php 
															echo $primera["comprobanteEdad"]=="1" ? " Si" : " No"; 
														?>
													</strong>
												</td>
												<td align="left">
													Segunda verificación: 
													<strong>
														<?php echo $segunda["comprobanteEdad"]=="1" ? " Si" : " No ";  ?>													
													</strong>
												</td>												
												<?php
											}
										?>	
									</tr>
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Comprobante de domicilio (verificar sello)
										</td>
										<td align="left">
											<input type="radio" id="comprobanteDomicilio" name="comprobanteDomicilio" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="comprobanteDomicilio"  name="comprobanteDomicilio" value="0" >No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["comprobanteDomicilio"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["comprobanteDomicilio"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>	
									</tr>
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Ahorrador Extranjero
										</td>
										<td align="left">
											<input type="radio" id="ahorradorExtranjero" name="ahorradorExtranjero" value="1" onclick="evaluaYMuestra(this,'divCopiaSimpleIdentificacionExtranjero','','copiaIdentificacionAhorradorExtranjero');" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="ahorradorExtranjero" name="ahorradorExtranjero" value="0" onclick="evaluaYMuestra(this,'divCopiaSimpleIdentificacionExtranjero','','copiaIdentificacionAhorradorExtranjero');">No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["ahorradorExtranjero"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["ahorradorExtranjero"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>	
									</tr>	
								</table>								
							</div>
							<div id="divCopiaSimpleIdentificacionExtranjero" class="oculta subelemento">
								<table class="tablaPantallas sinBorde ">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Copia simple de identificación de ahorrador extranjero (verificar sello)
										</td>
										<td align="left">
											<input type="radio" id="copiaIdentificacionAhorradorExtranjero" name="copiaIdentificacionAhorradorExtranjero" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
											<input type="radio" id="copiaIdentificacionAhorradorExtranjero" name="copiaIdentificacionAhorradorExtranjero" value="0" >No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["copiaIdentificacionAhorradorExtranjero"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["copiaIdentificacionAhorradorExtranjero"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>	
									</tr>					
								</table>
							</div>


							<br><br>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:35%; padding-right:10px;">
										Fecha de comprobante de domicilio
									</td>
									<td align="left">
										<input type="text" name="datepicker" id="datepicker" readonly />
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo convierteTimeStampCorto($primera["fechaComprobanteDomicilio"]); 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo convierteTimeStampCorto($segunda["fechaComprobanteDomicilio"]);  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
				</div>

				






				<div id="divMenorDeEdad" class="oculta">
						<span class='titulosRojos'>MENOR DE EDAD</span>
						<br><br>


						<div id="divSiEsMenorDeEdad" class="oculta">							
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Original del documento judicial que acredite el estado de interdicción y la tutela
									</td>
									<td align="left">
										<input type="radio"  id="originalDocumentoTutela"  name="originalDocumentoTutela" value="1" >Si<br>
										<input type="radio"  id="originalDocumentoTutela"  name="originalDocumentoTutela" value="0" >No
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["originalEstadoTutela"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["originalEstadoTutela"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Original del documento judicial que acredite la adopción del menor
									</td>
									<td align="left">
										<input type="radio" id="originalDocumentoAdopcion"  name="originalDocumentoAdopcion" value="1" >Si<br>
										<input type="radio" id="originalDocumentoAdopcion"  name="originalDocumentoAdopcion" value="0" >No
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["originalAdopcionMenor"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["originalAdopcionMenor"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Copia certificada del acta de nacimiento del menor de edad
									</td>
									<td align="left">
										<input type="radio" id="copiaCertificadaActaMenorEdad"  name="copiaCertificadaActaMenorEdad" value="1" >Si<br>
										<input type="radio" id="copiaCertificadaActaMenorEdad"  name="copiaCertificadaActaMenorEdad" value="0" >No
									</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["copiaCertificadaActaMenorEdad"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["copiaCertificadaActaMenorEdad"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
								</tr>
							</table>
						</div>


						<div id="divNoEsMenorDeEdad">
							<span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span>
						</div>
				</div>












				<div id="divRepresentanteAlbaceaBeneficiario" class="oculta">
						<span class='titulosRojos'>REPRESENTANTE, ALBACEA, HEREDERO O BENEFICIARIO</span>
						<br><br>
						<?php
							if($registroMinistraciones["representanteAlbacea"]=="") //No tenía albacea o beneficiario
							{
								echo "<span class='textoAvisoOpcional'>ESTA SECCIÓN NO APLICA PARA ESTE AHORRADOR</span>";
							}
							else
							{
								?>
								
								<table class="tablaPantallas sinBorde separadorTabla">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Representante legal
										</td>
										<td align="left">
											<input type="radio" required="true" id="representanteLegal"  name="representanteLegal" value="1" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divPersonaFisica','','tipoPersonaRepresentante'); ">Si<br>
											<input type="radio" required="true" id="representanteLegal"  name="representanteLegal" value="0" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divPersonaFisica','','tipoPersonaRepresentante');">No
										</td>
									<?php
										
										if(seHizoSegundaVerificacion($idahorrador))
										{
											?>	
											<td align="left">
												Primera verificación: 
												<strong>
													<?php 
														echo $primera["representanteLegal"]=="1" ? " Si" : " No"; 
													?>
												</strong>
											</td>
											<td align="left">
												Segunda verificación: 
												<strong>
													<?php echo $segunda["representanteLegal"]=="1" ? " Si" : " No ";  ?>													
												</strong>
											</td>												
											<?php
										}
									?>
									</tr>
								</table>
								<div id="divPersonaFisica" class="oculta subelemento">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Tipo de persona(representante): 
											</td>
											<td align="left">
												<select id="tipoPersonaRepresentante" name="tipoPersonaRepresentante" onchange="evaluaTipoPersonaRepresentante(this);">
													<option value=""></option>
													<option value="fisica">Física</option>
													<option value="moral">Moral</option>
												</select>
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["tipoPersonaRepresentante"]=="1" ? " Física" : " Moral"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["tipoPersonaRepresentante"]=="2" ? " Física" : " Moral ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
									</table>									
								</div>

								<div id="divPersonaFisicaDetalle" class="oculta subelemento2">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Tipo de representante
											</td>
											<td align="left">
												<select id="tipoRepresentantePersonaFisica" name="tipoRepresentantePersonaFisica" >
													<option value=""></option>
													<option value="representanteComun">Representante común</option>
													<option value="personaAutorizada">Persona autorizada</option>
												</select>
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
															if($primera["tipoRepresentantePersonaFisica"] === NULL)
															{
																echo "--";
															}else{
																echo $primera["tipoRepresentantePersonaFisica"]; 
															}
																 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php 
															if($segunda["tipoRepresentantePersonaFisica"] === NULL)
															{
																echo "--";
															}else{
																echo $segunda["tipoRepresentantePersonaFisica"]; 
															}
																



														    ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>

										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Original carta poder para actos de dominio: 
											</td>
											<td align="left">
												<input type="radio" id="originalCartaActosDominio"  name="originalCartaActosDominio" value="1" onclick="validaPoderActosDominio(this);" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="originalCartaActosDominio"  name="originalCartaActosDominio" value="0" onclick="validaPoderActosDominio(this);">No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["originalCartaPoderActosDominio"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["originalCartaPoderActosDominio"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Original poder notarial para actos de dominio: 
											</td>
											<td align="left">
												<input type="radio" id="originalPoderNotarialActosDominio"  name="originalPoderNotarialActosDominio" value="1" onclick="validaPoderActosDominio(this);">Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="originalPoderNotarialActosDominio"  name="originalPoderNotarialActosDominio" value="0" onclick="validaPoderActosDominio(this);">No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["originalPoderNotarialActosDominio"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["originalPoderNotarialActosDominio"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia simple de Identificación oficial vigente con fotografía y firma:
											</td>
											<td align="left">
												<input type="radio" id="copiaSimpleIdentificacionRepresentante"  name="copiaSimpleIdentificacionRepresentante" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaSimpleIdentificacionRepresentante"  name="copiaSimpleIdentificacionRepresentante" value="0" >No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["copiaSimpleIdentificacionRepresentanteLegal"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["copiaSimpleIdentificacionRepresentanteLegal"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
									</table>									
								</div>
								<div id="divPersonaMoralDetalle" class="oculta subelemento2">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del Acta constitutiva de la Sociedad, de sus estatutos con sus últimas modificaciones:
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaActaConstitutivaSociedad"  name="copiaCertificadaActaConstitutivaSociedad" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaActaConstitutivaSociedad"  name="copiaCertificadaActaConstitutivaSociedad" value="0" >No
											</td>
											<?php
												
													if(seHizoSegundaVerificacion($idahorrador)) {
													?> <td align="left"> Primera verificación: <strong>
													<?php echo $primera["copiaActaConstitutivaSociedad"]=="1" ? " Si" : " No"; ?>
													</strong> </td>                                                     <td
													align="left"> Segunda verificación: <strong>
													<?php echo $segunda["copiaActaConstitutivaSociedad"]=="1" ? " Si" : " No ";
													?> </strong>                                                     </td> <?php
													} ?>                                         </tr> <tr>
													<td valign="top" align="right" style="width:40%; padding-right:10px;">
													Original del Poder para actos de dominio del Representante Legal certificado
													ante Notario Público en el que se le faculte </td>
													<td align="left"> <input type="radio" id="originalActosDominioNotarioPublico"
													name="originalActosDominioNotarioPublico" value="1"
													>Si&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio"
													id="originalActosDominioNotarioPublico"
													name="originalActosDominioNotarioPublico" value="0" >No </td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["originalActosDominioNotarioPublico"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["originalActosDominioNotarioPublico"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>

										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia simple de identificación
											</td>
											<td align="left">
												<input type="radio" id="copiaSimpleIdentificacionRepresentanteLegalMoral"  name="copiaSimpleIdentificacionRepresentanteLegalMoral" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaSimpleIdentificacionRepresentanteLegalMoral"  name="copiaSimpleIdentificacionRepresentanteLegalMoral" value="0" >No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["copiaSimpleIdentificacionRepresentanteLegalMoral"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["copiaSimpleIdentificacionRepresentanteLegalMoral"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Comprobante de edad (Si aplica)
											</td>
											<td align="left">
												<input type="radio" id="comprobanteEdadRepresentanteLegalMoral"  name="comprobanteEdadRepresentanteLegalMoral" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="comprobanteEdadRepresentanteLegalMoral"  name="comprobanteEdadRepresentanteLegalMoral" value="0" >No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["comprobanteEdadRepresentanteLegalMoral"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["comprobanteEdadRepresentanteLegalMoral"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Comprobante de domicilio (Verificar sello)
											</td>
											<td align="left">
												<input type="radio" id="comprobanteDomicilioRepresentanteLegalMoral"  name="comprobanteDomicilioRepresentanteLegalMoral" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="comprobanteDomicilioRepresentanteLegalMoral"  name="comprobanteDomicilioRepresentanteLegalMoral" value="0" >No
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["comprobanteDomicilioRepresentanteLegalMoral"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["comprobanteDomicilioRepresentanteLegalMoral"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Fecha comprobante de domicilio
											</td>
											<td align="left">
												<input type="text" name="datepicker3" id="datepicker3" readonly/>
											</td>
											<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo convierteTimeStampCorto($primera["fechaComprobanteDomicilioRepresentanteMoral"]); 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo convierteTimeStampCorto($segunda["fechaComprobanteDomicilioRepresentanteMoral"]);  ?>													
														</strong>
													</td>												
													<?php
												}
											?>

										</tr>
									</table>
								</div>










								<table class="tablaPantallas sinBorde separadorTabla">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Albacea (décimo)
										</td>
										<td align="left">
											<input type="radio" required="true" id="albaceaDecimo"  name="albaceaDecimo" value="1" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divAlbaceaDecimo','','copiaCertificadaActaDefuncion,copiaCertificadaDocumentoAcreditaAlbacea,copiaSimpleIdentificacionAlbacea,copiaCertificadaDiscernimientoAlbacea'); ">Si<br>
											<input type="radio" required="true" id="albaceaDecimo"  name="albaceaDecimo" value="0" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divAlbaceaDecimo','','copiaCertificadaActaDefuncion,copiaCertificadaDocumentoAcreditaAlbacea,copiaSimpleIdentificacionAlbacea,copiaCertificadaDiscernimientoAlbacea');">No
										</td>
										<?php
												
												if(seHizoSegundaVerificacion($idahorrador))
												{
													?>	
													<td align="left">
														Primera verificación: 
														<strong>
															<?php 
																echo $primera["albaceaDecimo"]=="1" ? " Si" : " No"; 
															?>
														</strong>
													</td>
													<td align="left">
														Segunda verificación: 
														<strong>
															<?php echo $segunda["albaceaDecimo"]=="1" ? " Si" : " No ";  ?>													
														</strong>
													</td>												
													<?php
												}
										?>
									</tr>
								</table>
								<div id="divAlbaceaDecimo" class="oculta subelemento">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del Acta de Defunción del Ahorrador
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaActaDefuncion"  name="copiaCertificadaActaDefuncion" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaActaDefuncion"  name="copiaCertificadaActaDefuncion" value="0" >No
											</td>
											<?php
													
													if(seHizoSegundaVerificacion($idahorrador))
													{
														?>	
														<td align="left">
															Primera verificación: 
															<strong>
																<?php 
																	echo $primera["copiaActaDefunsionAhorrador"]=="1" ? " Si" : " No"; 
																?>
															</strong>
														</td>
														<td align="left">
															Segunda verificación: 
															<strong>
																<?php echo $segunda["copiaActaDefunsionAhorrador"]=="1" ? " Si" : " No ";  ?>													
															</strong>
														</td>												
														<?php
													}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del documento judicial que acredite su cargo de Albacea
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaDocumentoAcreditaAlbacea"  name="copiaCertificadaDocumentoAcreditaAlbacea" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaDocumentoAcreditaAlbacea"  name="copiaCertificadaDocumentoAcreditaAlbacea" value="0" >No
											</td>
											<?php
													
													if(seHizoSegundaVerificacion($idahorrador))
													{
														?>	
														<td align="left">
															Primera verificación: 
															<strong>
																<?php 
																	echo $primera["copiaAcrediteAlbacea"]=="1" ? " Si" : " No"; 
																?>
															</strong>
														</td>
														<td align="left">
															Segunda verificación: 
															<strong>
																<?php echo $segunda["copiaAcrediteAlbacea"]=="1" ? " Si" : " No ";  ?>													
															</strong>
														</td>												
														<?php
													}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia simple de Identificación oficial vigente con fotografía y firma del Albacea
											</td>
											<td align="left">
												<input type="radio" id="copiaSimpleIdentificacionAlbacea"  name="copiaSimpleIdentificacionAlbacea" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaSimpleIdentificacionAlbacea"  name="copiaSimpleIdentificacionAlbacea" value="0" >No
											</td>
											<?php
													
													if(seHizoSegundaVerificacion($idahorrador))
													{
														?>	
														<td align="left">
															Primera verificación: 
															<strong>
																<?php 
																	echo $primera["copiaIdentificacionAlbacea"]=="1" ? " Si" : " No"; 
																?>
															</strong>
														</td>
														<td align="left">
															Segunda verificación: 
															<strong>
																<?php echo $segunda["copiaIdentificacionAlbacea"]=="1" ? " Si" : " No ";  ?>													
															</strong>
														</td>												
														<?php
													}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												 Copia certificada del documento judicial donde se acredite su aceptación y cargo de Albacea
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaDocumentoJudicialCargoAlbacea"  name="copiaCertificadaDocumentoJudicialCargoAlbacea" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaDocumentoJudicialCargoAlbacea"  name="copiaCertificadaDocumentoJudicialCargoAlbacea" value="0" >No
											</td>
											<?php
													
													if(seHizoSegundaVerificacion($idahorrador))
													{
														?>	
														<td align="left">
															Primera verificación: 
															<strong>
																<?php 
																	echo $primera["copiaAceptacionCargoAlbacea"]=="1" ? " Si" : " No"; 
																?>
															</strong>
														</td>
														<td align="left">
															Segunda verificación: 
															<strong>
																<?php echo $segunda["copiaAceptacionCargoAlbacea"]=="1" ? " Si" : " No ";  ?>													
															</strong>
														</td>												
														<?php
													}
											?>
										</tr>
									</table>
								</div>








								<table class="tablaPantallas sinBorde separadorTabla">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Herederos (décimo primero)
										</td>
										<td align="left">
											<input type="radio" required="true" id="herederoDecimoPrimero"  name="herederoDecimoPrimero" value="1" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divHerederoDecimoPrimero','','copiaCertificadaActaDefuncionHeredero,copiaCertificadaActaNacimientoHeredero,copiaSimpleIdentificacionHeredero,copiaCertificadaEscrituraTestamentoHeredero');">Si<br>
											<input type="radio" required="true" id="herederoDecimoPrimero"  name="herederoDecimoPrimero" value="0" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divHerederoDecimoPrimero','','copiaCertificadaActaDefuncionHeredero,copiaCertificadaActaNacimientoHeredero,copiaSimpleIdentificacionHeredero,copiaCertificadaEscrituraTestamentoHeredero');">No
										</td>
										<?php
													
													if(seHizoSegundaVerificacion($idahorrador))
													{
														?>	
														<td align="left">
															Primera verificación: 
															<strong>
																<?php 
																	echo $primera["herederosDecimoPrimero"]=="1" ? " Si" : " No"; 
																?>
															</strong>
														</td>
														<td align="left">
															Segunda verificación: 
															<strong>
																<?php echo $segunda["herederosDecimoPrimero"]=="1" ? " Si" : " No ";  ?>													
															</strong>
														</td>												
														<?php
													}
										?>
									</tr>
								</table>
								<div id="divHerederoDecimoPrimero" class="oculta subelemento">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del Acta de Defunción del Ahorrador
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaActaDefuncionHeredero"  name="copiaCertificadaActaDefuncionHeredero" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaActaDefuncionHeredero"  name="copiaCertificadaActaDefuncionHeredero" value="0" >No
											</td>
											<?php
														
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
															<td align="left">
																Primera verificación: 
																<strong>
																	<?php 
																		echo $primera["copiaActaNacimientoRepresentado"]=="1" ? " Si" : " No"; 
																	?>
																</strong>
															</td>
															<td align="left">
																Segunda verificación: 
																<strong>
																	<?php echo $segunda["copiaActaNacimientoRepresentado"]=="1" ? " Si" : " No ";  ?>													
																</strong>
															</td>												
											<?php
												}
											?>

										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del Acta de Nacimiento de su representado si es menor de edad o del documento judicial que acredite el estado de interdicción y la tutela
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaActaNacimientoHeredero"  name="copiaCertificadaActaNacimientoHeredero" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaActaNacimientoHeredero"  name="copiaCertificadaActaNacimientoHeredero" value="0" >No
											</td>
											<?php
														
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
															<td align="left">
																Primera verificación: 
																<strong>
																	<?php 
																		echo $primera["copiaActaNacimientoRepresentado"]=="1" ? " Si" : " No"; 
																	?>
																</strong>
															</td>
															<td align="left">
																Segunda verificación: 
																<strong>
																	<?php echo $segunda["copiaActaNacimientoRepresentado"]=="1" ? " Si" : " No ";  ?>													
																</strong>
															</td>												
											<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia simple de Identificación oficial vigente con fotografía y firma del (los) Heredero(s)
											</td>
											<td align="left">
												<input type="radio" id="copiaSimpleIdentificacionHeredero"  name="copiaSimpleIdentificacionHeredero" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaSimpleIdentificacionHeredero"  name="copiaSimpleIdentificacionHeredero" value="0" >No
											</td>
											<?php
														
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
															<td align="left">
																Primera verificación: 
																<strong>
																	<?php 
																		echo $primera["copiaIdentificacionHerederos"]=="1" ? " Si" : " No"; 
																	?>
																</strong>
															</td>
															<td align="left">
																Segunda verificación: 
																<strong>
																	<?php echo $segunda["copiaIdentificacionHerederos"]=="1" ? " Si" : " No ";  ?>													
																</strong>
															</td>												
											<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												 Copia certificada de la escritura del testamento o en caso de resolución judicial, copia certificada de la sentencia en que conste su protocolización, la participación y adjudicación de los bienes heredados
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaEscrituraTestamentoHeredero"  name="copiaCertificadaEscrituraTestamentoHeredero" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaEscrituraTestamentoHeredero"  name="copiaCertificadaEscrituraTestamentoHeredero" value="0" >No
											</td>
											<?php
														
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
															<td align="left">
																Primera verificación: 
																<strong>
																	<?php 
																		echo $primera["copiaTestamento"]=="1" ? " Si" : " No"; 
																	?>
																</strong>
															</td>
															<td align="left">
																Segunda verificación: 
																<strong>
																	<?php echo $segunda["copiaTestamento"]=="1" ? " Si" : " No ";  ?>													
																</strong>
															</td>												
											<?php
												}
											?>
										</tr>
									</table>
								</div>





								<table class="tablaPantallas sinBorde separadorTabla">
									<tr>
										<td valign="top" align="right" style="width:40%; padding-right:10px;">
											Beneficiario (décimo segundo)
										</td>
										<td align="left">
											<input type="radio" required="true" id="beneficiarioDecimoSegundo"  name="beneficiarioDecimoSegundo" value="1" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divBeneficiarioDecimoSegundo','','copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo,copiaCertificadaTodosDocumentos,copiaSimpleTodosBeneficiarios,contratoOriginalBeneficiario');">Si<br>
											<input type="radio" required="true" id="beneficiarioDecimoSegundo"  name="beneficiarioDecimoSegundo" value="0" onclick="evaluaAlbaceaBeneficiario(this,event); evaluaYMuestra(this,'divBeneficiarioDecimoSegundo','','');">No
										</td>
										<?php
														
											if(seHizoSegundaVerificacion($idahorrador))
											{
										?>	
															<td align="left">
																Primera verificación: 
																<strong>
																	<?php 
																		echo $primera["beneficiarioDecimoSegundo"]=="1" ? " Si" : " No"; 
																	?>
																</strong>
															</td>
															<td align="left">
																Segunda verificación: 
																<strong>
																	<?php echo $segunda["beneficiarioDecimoSegundo"]=="1" ? " Si" : " No ";  ?>													
																</strong>
															</td>												
										<?php
											}
										?>	

									</tr>
								</table>
								<div id="divBeneficiarioDecimoSegundo" class="oculta subelemento">
									<table class="tablaPantallas sinBorde ">
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia certificada del Acta de Defunción del Ahorrador
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo"  name="copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo"  name="copiaCertificadaActaDefuncionBeneficiarioDecimoSegundo" value="0" >No
											</td>
											<?php
															
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
																<td align="left">
																	Primera verificación: 
																	<strong>
																		<?php 
																			echo $primera["primeraVerificacion"]=="1" ? " Si" : " No"; 
																		?>
																	</strong>
																</td>
																<td align="left">
																	Segunda verificación: 
																	<strong>
																		<?php echo $segunda["primeraVerificacion"]=="1" ? " Si" : " No ";  ?>													
																	</strong>
																</td>												
											<?php
												}
											?>	
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Del(los) beneficiario(s), copia certificada de su Acta de Nacimiento
											</td>
											<td align="left">
												<input type="radio" id="copiaCertificadaTodosDocumentos"  name="copiaCertificadaTodosDocumentos" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaCertificadaTodosDocumentos"  name="copiaCertificadaTodosDocumentos" value="0" >No
											</td>
											<?php
															
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
																<td align="left">
																	Primera verificación: 
																	<strong>
																		<?php 
																			echo $primera["copiaActaNacimientoBeneficiarios"]=="1" ? " Si" : " No"; 
																		?>
																	</strong>
																</td>
																<td align="left">
																	Segunda verificación: 
																	<strong>
																		<?php echo $segunda["copiaActaNacimientoBeneficiarios"]=="1" ? " Si" : " No ";  ?>													
																	</strong>
																</td>												
											<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Copia simple de Identificación oficial vigente con fotografía y firma del (os) Beneficiario(s)
											</td>
											<td align="left">
												<input type="radio" id="copiaSimpleTodosBeneficiarios"  name="copiaSimpleTodosBeneficiarios" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="copiaSimpleTodosBeneficiarios"  name="copiaSimpleTodosBeneficiarios" value="0" >No
											</td>
											<?php
															
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
																<td align="left">
																	Primera verificación: 
																	<strong>
																		<?php 
																			echo $primera["copiaIdentificacionVigenteBeneficiarios"]=="1" ? " Si" : " No"; 
																		?>
																	</strong>
																</td>
																<td align="left">
																	Segunda verificación: 
																	<strong>
																		<?php echo $segunda["copiaIdentificacionVigenteBeneficiarios"]=="1" ? " Si" : " No ";  ?>													
																	</strong>
																</td>												
											<?php
												}
											?>
										</tr>
										<tr>
											<td valign="top" align="right" style="width:40%; padding-right:10px;">
												Contrato original celebrado con la Sociedad de que se trate, en que se designa(n) al (os) Beneficiario(s)
											</td>
											<td align="left">
												<input type="radio" id="contratoOriginalBeneficiario"  name="contratoOriginalBeneficiario" value="1" >Si&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="contratoOriginalBeneficiario"  name="contratoOriginalBeneficiario" value="0" >No
											</td>
											<?php
															
												if(seHizoSegundaVerificacion($idahorrador))
												{
											?>	
																<td align="left">
																	Primera verificación: 
																	<strong>
																		<?php 
																			echo $primera["contratoOriginalBeneficiarios"]=="1" ? " Si" : " No"; 
																		?>
																	</strong>
																</td>
																<td align="left">
																	Segunda verificación: 
																	<strong>
																		<?php echo $segunda["contratoOriginalBeneficiarios"]=="1" ? " Si" : " No ";  ?>													
																	</strong>
																</td>												
											<?php
												}
											?>
										</tr>
									</table>
								</div>
								
								<?php
							}
						?>						
				</div>






				<div id="divFormatosIdentidad" class="oculta">
					<span class='titulosRojos'>FORMATOS DE IDENTIDAD</span>
					<br><br>
												
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Solicitud del ahorrador (anverso y reverso)
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
								<input type="radio" required="true" id="solicitudAhorrador"  name="solicitudAhorrador" value="1" >Si<br>
								<input type="radio" required="true" id="solicitudAhorrador"  name="solicitudAhorrador" value="0" >No
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo $primera["solicitudAhorradorAnversoReverso"]=="1" ? " Si" : " No"; 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo $segunda["solicitudAhorradorAnversoReverso"]=="1" ? " Si" : " No ";  ?>												
										</strong>
										</td>												
								<?php
									}
								?>						
						</tr>
					</table>
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:30%; padding-right:10px;">
								Fecha del formato
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 20%;" '; ?>>
								<input type="text" name="datepicker2" id="datepicker2" readonly />
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo convierteTimeStampCorto($primera["fechaFormato"]); 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo convierteTimeStampCorto($segunda["fechaFormato"]);  ?>												
										</strong>
										</td>												
								<?php
									}
								?>	
						</tr>
					</table>						
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Declaración ISR anual correspondiente a cada uno de los años en que fue Ahorrador de la Sociedad
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
								<input type="radio" required="true" id="declaracionAnualCincoAnios"  name="declaracionAnualCincoAnios" value="1" >Si<br>
								<input type="radio" required="true" id="declaracionAnualCincoAnios"  name="declaracionAnualCincoAnios" value="0" >No
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo $primera["declaracionISR"]=="1" ? " Si" : " No"; 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo $segunda["declaracionISR"]=="1" ? " Si" : " No ";  ?>												
										</strong>
										</td>												
								<?php
									}
								?>	

						</tr>
					</table>
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Manifestación de cumplimiento de obligaciones fiscales
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
								<input type="radio" required="true" id="manifestacionObligacionesFiscales"  name="manifestacionObligacionesFiscales" value="1" >Si<br>
								<input type="radio" required="true" id="manifestacionObligacionesFiscales"  name="manifestacionObligacionesFiscales" value="0" >No
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo $primera["manifestacionObligacionesFiscales"]=="1" ? " Si" : " No"; 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo $segunda["manifestacionObligacionesFiscales"]=="1" ? " Si" : " No ";  ?>												
										</strong>
										</td>												
								<?php
									}
								?>

						</tr>
					</table>
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Entre la declaración ISR y la manifestación de obligaciones fiscales se cubren los últimos 5 años
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
								<input type="radio" required="true" id="cumple5AniosFiscales"  name="cumple5AniosFiscales" value="1" >Si<br>
								<input type="radio" required="true" id="cumple5AniosFiscales"  name="cumple5AniosFiscales" value="0" >No
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo $primera["cumple5AniosFiscales"]=="1" ? " Si" : " No"; 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo $segunda["cumple5AniosFiscales"]=="1" ? " Si" : " No ";  ?>												
										</strong>
										</td>												
								<?php
									}
								?>
						</tr>
					</table>
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Etiqueta de Sobre de Expediente Individual de Ahorrador (Formato 4)
							</td>
							<td align="left" <?php if(seHizoSegundaVerificacion($idahorrador)) echo 'style="width: 10%;" '; ?>>
								<input type="radio" required="true" id="etiquetaSobreIndividual"  name="etiquetaSobreIndividual" value="1">Si<br>
								<input type="radio" required="true" id="etiquetaSobreIndividual"  name="etiquetaSobreIndividual" value="0">No
							</td>
								<?php
															
									if(seHizoSegundaVerificacion($idahorrador))
									{
								?>	
										<td align="left">
											Primera verificación: 
											<strong>
											<?php 
												echo $primera["etiquetaExpedienteFormato4"]=="1" ? " Si" : " No"; 
											?>
											</strong>
										</td>
										<td align="left">
										Segunda verificación: 
										<strong>
											<?php echo $segunda["etiquetaExpedienteFormato4"]=="1" ? " Si" : " No ";  ?>												
										</strong>
										</td>												
								<?php
									}
								?>
						</tr>
					</table>
				</div>




				<div id="divDocumentosValor" class="oculta">
					<span class='titulosRojos'>DOCUMENTOS DE VALOR</span>

					<?php
						if($sociedad["idcatalogoStatusSociedades"]==1 || $sociedad["idcatalogoStatusSociedades"]==2) //Concurso mercantil o quiebra
						{
							?>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Original de denuncia penal
									</td>
									<td align="left">
										<input type="radio" required="true" id="originalDenunciaPenal"  name="originalDenunciaPenal" value="1" >Si<br>
										<input type="radio" required="true" id="originalDenunciaPenal"  name="originalDenunciaPenal" value="0" >No
									</td>
								</tr>
							</table>
							<?php
						}
						if($sociedad["idcatalogoStatusSociedades"]==1) //Concurso mercantil
						{
							?>							
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Transmisión de Titularidad de créditos (LCS-4/144)
									</td>
									<td align="left">
										<input type="radio" required="true" id="transmisionTitularidadCreditos"  name="transmisionTitularidadCreditos" value="1" >Si<br>
										<input type="radio" required="true" id="transmisionTitularidadCreditos"  name="transmisionTitularidadCreditos" value="0" >No
									</td>
								</tr>
							</table>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Sentencia de concurso mercantil
									</td>
									<td align="left">
										<input type="radio" required="true" id="sentenciaConcursoMercantil"  name="sentenciaConcursoMercantil" value="1" >Si<br>
										<input type="radio" required="true" id="sentenciaConcursoMercantil"  name="sentenciaConcursoMercantil" value="0" >No
									</td>
								</tr>
							</table>
							<?php
						}
						if($sociedad["idcatalogoStatusSociedades"]==2) //Quiebra
						{
							?>
							<table class="tablaPantallas sinBorde separadorTabla">
								<tr>
									<td valign="top" align="right" style="width:40%; padding-right:10px;">
										Sentencia de quiebra
									</td>
									<td align="left">
										<input type="radio" required="true" id="sentenciaQuiebra"  name="sentenciaQuiebra" value="1" >Si<br>
										<input type="radio" required="true" id="sentenciaQuiebra"  name="sentenciaQuiebra" value="0" >No
									</td>
								</tr>
							</table>							
							<?php
						}
					?>

					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Certificado de no adeudo
								<?php
									if($fil["spc"]>0)																		
										echo "<br><span style='font-weight:bold;'>$ ".separarMiles($fil["spc"])."</span>";
								?>
							</td>
							<td align="left">
								<?php
									if($fil["spc"]>0)
									{
										?>
										<input type="radio" required="true" id="certificadoNoAdeudo"  name="certificadoNoAdeudo" value="1" >Si<br>
										<input type="radio" required="true" id="certificadoNoAdeudo"  name="certificadoNoAdeudo" value="0" >No
										<?php
									}
									else
									{
										echo "<span style='font-weight:bold;'>AHORRADOR SIN PRÉSTAMOS</span>";
									}
								?>
								
							</td>
						</tr>
					</table>
					<table class="tablaPantallas sinBorde separadorTabla">
						<tr>
							<td valign="top" align="right" style="width:40%; padding-right:10px;">
								Carta de no responsabilidad por la no liberación de garantías
								<?php
									if($fil["sdg"]>0)																		
										echo "<br><span style='font-weight:bold;'>$ ".separarMiles($fil["sdg"])."</span>";
								?>
							</td>
							<td align="left">
								<?php
									if($fil["sdg"]>0)
									{
										?>
										<input type="radio" required="true" id="cartaNoResponsabilidadLiberacionGarantias"  name="cartaNoResponsabilidadLiberacionGarantias" value="1" >Si<br>
										<input type="radio" required="true" id="cartaNoResponsabilidadLiberacionGarantias"  name="cartaNoResponsabilidadLiberacionGarantias" value="0" >No
										<?php
									}
									else
									{
										echo "<span style='font-weight:bold;'>AHORRADOR SIN DEPÓSITOS EN GARANTÍA</span>";
									}
								?>
								
							</td>
						</tr>
					</table>

					<br>
					<table class="tablaCamposValor">
						
						<tr style="background-color:#e4e4e4;">
							<td align="right">Finiquito de pago</td>
							<td align="left">$<input type="number" step="0.01" name="valorFiniquitoPago" id="valorFiniquitoPago" required></td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<?php
							 if(seHizoSegundaVerificacion($idahorrador))
							{
						?>	
						<tr style="background-color:#e4e4e4;">
							<td align="right">Primera Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  $".$primera["finiquitoPago"]."</strong>"; ?> </td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<tr style="background-color:#e4e4e4;">
							<td align="right">Segunda Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  $".$segunda["finiquitoPago"]."</strong>"; ?> </td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<?php
						  }
						 ?>
						<?php 
						#aqui voy  $segunda["etiquetaExpedienteFormato4"] <?php echo "<strong>&nbsp;  $".$primera["finiquitoPago"]."</strong>"; 
						?>

						<tr>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="right">Entregando físicamente documentos por $</td>
							<td align="left"><input type="number"  name="numeroDocumentosValor" id="numeroDocumentosValor" step="0.01" required></td>							
						</tr>
						<?php
							 if(seHizoSegundaVerificacion($idahorrador))
							{
						?>	
						<tr>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="right">Primera Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  ".$primera["documentos"]."</strong>"; ?></td>							
						</tr>
						<tr>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
							<td align="right">Segunda Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  ".$segunda["documentos"]."</strong>"; ?></td>							
						</tr>	
						<?php
						}
						?>	

						<tr style="background-color:#e4e4e4;">
							<td align="right">&nbsp;</td>							
							<td align="right" colspan="2">Documentos no presentados (formato 7)</td>
							<td align="left" ">$<input type="number" step="0.01" name="documentosNoPresentados" id="documentosNoPresentados" required></td>						
						</tr>
						<tr style="background-color:#e4e4e4;">

						<?php
							 if(seHizoSegundaVerificacion($idahorrador))
							{
						?>
							<td align="right">&nbsp;</td>													
							<td align="right" colspan="2">Primera Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  ".$primera["documentosNoPresentados"]."</strong>"; ?></td>	
												
						</tr>
						<tr style="background-color:#e4e4e4;">
							<td align="right">&nbsp;</td>							
							<td align="right" colspan="2">Segunda Verficación:</td>
							<td align="left"><?php echo "<strong>&nbsp;  ".$segunda["documentosNoPresentados"]."</strong>"; ?></td>						
						</tr>
						<?php } ?>

						<tr>
							<td align="right">&nbsp;</td>							
							<td align="right" colspan="2"  >El 70% del saldo neto de ahorro o el monto máximo a pagar</td>
							<td align="left" style="padding: 2px;">$<input type="number" step="0.01" name="salto70Ahorro" id="salto70Ahorro" required></td>						
						</tr>
						<?php
							 if(seHizoSegundaVerificacion($idahorrador))
							{
						?>	
						<tr>
							<td align="right">&nbsp;</td>							
							<td align="right" colspan="2">Primera Verificación</td>
							<td align="left"><?php echo "<strong>&nbsp;  ".separarMiles($primera["saldo70Ahorro"])."</strong>"; ?></td>						
						</tr>
						<tr>
							<td align="right">&nbsp;</td>							
							<td align="right" colspan="2">Segunda Verificación</td>
							<td align="left"><?php echo "<strong>&nbsp;  ". separarMiles($segunda["saldo70Ahorro"])."</strong>"; ?></td>						
						</tr>
						<?php
						 }
						?>

						<tr style="background-color:#e4e4e4;">
							<td align="right">
								Contrato de cesión de derechos
								<?php 
									echo $registroMinistraciones["representanteAlbacea"]!="" ? " de la persona autorizada" : " del ahorrador "; 
								?>
							</td>
							<td align="left">$<input type="number" step="0.01" name="contratoSesionDerechos" id="contratoSesionDerechos" required></td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<?php
							 if(seHizoSegundaVerificacion($idahorrador))
							{
						?>	
						<tr style="background-color:#e4e4e4;">
							<td align="right">
								Primera Verificación
								<?php 
									#echo $registroMinistraciones["representanteAlbacea"]!="" ? " de la persona autorizada" : " del ahorrador "; 
								?>
							</td>
							<td align="left"><?php echo "<strong>&nbsp;  ". separarMiles($primera["montoContratoSesionDerechos"])."</strong>"; ?></td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>
						<tr style="background-color:#e4e4e4;">
							<td align="right">
								Segunda Verificación
								<?php 
									#echo $registroMinistraciones["representanteAlbacea"]!="" ? " de la persona autorizada" : " del ahorrador "; 
								?>
							</td>
							<td align="left"><?php echo "<strong>&nbsp;  ". separarMiles($segunda["montoContratoSesionDerechos"])."</strong>"; ?></td>
							<td align="right">&nbsp;</td>
							<td align="left">&nbsp;</td>
						</tr>

						<?php
						  } 
						 ?>


					</table>
					
					

				</div>






				<div id="divDocumentosComprobatorios" class="oculta">
						<span class='titulosRojos'>DOCUMENTOS COMPROBATORIOS</span>
						<br>
						<br>
						<?php
						if(seHizoSegundaVerificacion($idahorrador))
						{
						?>	
							<div style="height: 40px;">
								<span  style="float: left; width: 50%;" class="enlaces" onclick="muestraDraggable(2,'<?php echo $ahorrador["folioIdentificador"]; ?>');">
									<img src="../img/showIcon.png" width="40px; margin-top:3px", style="cursor:pointer;" />
									<br>
									MUESTRA SALDOS DEL AHORRADOR
								</span>
								<span  style="float: left; width: 50%;" class="enlaces" onclick="muestraPrimera(<?php echo $primera["idcamposVerificacion"]; ?>,<?php echo $segunda["idsegundaVerificacion"];?>);">
									<img src="../img/showIcon.png" width="40px; margin-top:3px", style="cursor:pointer;" />
									<br>
									VERIFICACIONES ANTERIORES
								</span>	
								<span  style="float: left; width: 30%; display: none;" class="enlaces" onclick="muestraSegunda(<?php echo $segunda["idsegundaVerificacion"]; ?>);">
									<img src="../img/showIcon.png" width="40px; margin-top:3px", style="cursor:pointer;" />
									<br>
									SEGUNDA VERIFICIACIÓN
								</span>													
							</div>
					<?php
					}else{
					?>
							<div>
								<span class="enlaces" onclick="muestraDraggable(2,'<?php echo $ahorrador["folioIdentificador"]; ?>');">
									<img src="../img/showIcon.png" width="40px; margin-top:3px", style="cursor:pointer;" />
									<br>
									MUESTRA SALDOS DEL AHORRADOR
								</span>							
							</div>
					<?php
					}
					?>
						<br>
						<br>


						<div>
							<table class="tablaPantallas sinBorde separadorTabla" style="z-index: 15;">
								<tr style="font-weight: bold;">
									<td  align="center" style="width:27px;">No.</td>
									<td  align="center" style="width:150px;">Tipo de saldo</td>
									<td  align="center" style="width:106px;">Folio</td>
									<td  align="center" style="width:136px;">Documento</td>
									<td  align="center" style="width:82px;">Monto</td>
									<td  align="center" style="width: 85px;">Aclaración</td>
									<td  align="center" style="width: 242px;">Motivo</td>
									<td style="width: 50px;"></td>
								</tr>
							</table>
							<table class="tablaPantallas sinBorde separadorTabla pedidoItem" style="z-index: 15;" id="itemOriginal">
								<tr>
									<td  align="center" style="width:27px;">
										<input type="text"  name="numeroDocumento[1]" size="4" class="input" value="1">
									</td>
									<td  align="center" style="width:150px;">
										<select name="tipoDocumento[1]" class="input">
											<option value=""></option>
											<option value="ps">Parte social</option>
											<option value="ca">Cuentas de ahorro</option>
											<option value="ci">Cuentas de inversión</option>
											<option value="dg">Depósitos en garantía</option>
											<option value="cnc">Cheques no cobrados</option>
											<option value="od">Otros depósitos</option>
											<option value="pc">Préstamos a cargo</option>										
										</select>
									</td>
									<td  align="center" style="width:106px;">
										<input type="text" required  name="folio[1]" size="12" class="input">
									</td>
									<td  align="center" style="width:136px;">
										<input type="text" required  name="documento[1]" class="input">
									</td>
									<td  align="center" style="width:82px;">
										$ <input type="number" step="0.01" required  name="monto[1]" style="width: 100px;" class="input">
									</td>
									<td  align="center" style="width: 85px;">
										<input type="radio" name="aclaracion_[1]" onclick="evaluaDocumentoAclaracion(this);" value="1" class="input">Si<br>
										<input type="radio" name="aclaracion_[1]" onclick="evaluaDocumentoAclaracion(this);" value="0" class="input">No
									</td>
									<td  align="center" style="width: 242px;">
										<textarea cols="34" rows="2" id="motivoAclaracion[1]" name="motivoAclaracion[1]" class="oculta input"></textarea>
									</td>
									<td  align="center" style="width: 50px;">								
										<img src="../img/cerrar.png"  onclick="borraItem(this);" disabled="true" class="borraItem" width="20px" />
									</td>
								</tr>
							</table>
						</div>

						<table class="tablaPantallas sinBorde separadorTabla" style="z-index: 15;">
							<tr style="font-weight: bold;">
								<td  align="left">
									<img src="../img/plus-icon.png" width="20px" onclick="agregaItem();"/>
								</td>
							</tr>
						</table>


						<table class="tablaPantallas sinBorde separadorTabla" style="z-index: 15;">
							<tr style="font-weight: bold;">
								<td  align="center">
									<input type='button' value='Verificar Documentos' class='botonSubElemento' onclick="verificaDocumentos();"/>
								</td>
							</tr>
						</table>
						
				</div>


				<br><br>
				<?php
					echo "<input type='hidden' id='folioIdentificadorPantalla' name='folioIdentificadorPantalla' value='".$folioIdentificador."' />";
					

					if(!seHizoPrimeraVerificacion($idahorrador)) //AUN NO ESTA ECHA LA PRIMERA VERIFICACION
					{
						echo "<input type='hidden' id='verificacionParaGuardar' name='verificacionParaGuardar' value='1' />";		
						echo "<input type='hidden' id='a' name='a' value='guardaPrimeraVerificacion' />";
						echo "<input type='button' id='botonSubmit' value='GUARDAR PRIMERA VERIFICACIÓN' class='botonRojo' onclick='hacerSubmitFormularioPrincipal();' />";
					}
					else if(!seHizoSegundaVerificacion($idahorrador))  //YA SE HIZO LA PRIMERA REVISIÓN
					{
						echo "<input type='hidden' id='verificacionParaGuardar' name='verificacionParaGuardar' value='2' />";		
						echo "<input type='hidden' id='a' name='a' value='guardaSegundaVerificacion' />";
						echo "<input type='button' id='botonSubmit' value='GUARDAR SEGUNDA VERIFICACIÓN' class='botonRojo' onclick='hacerSubmitFormularioPrincipal();'/>";						
					}
					else if(seHizoSegundaVerificacion($idahorrador))
					{
						echo "<input type='hidden' id='verificacionParaGuardar' name='verificacionParaGuardar' value='3' />";		
						echo "<input type='hidden' id='a' name='a' value='guardaVerificacionFinal' />";
						echo "<input type='button' id='botonSubmit' value='GUARDAR VERIFICACIÓN FINAL' class='botonRojo' onclick='hacerSubmitFormularioPrincipal();'/>";						
					}
				?>				
		</form>
		<?php
	}




	function cargaSociedades()
	{
		global $_REQUEST;

		$sql="SELECT 
				convenio_has_sociedad.convenio_idconvenio,  
				convenio_has_sociedad.sociedad_idsociedad,  				
				sociedad.nombre, 
				convenio_has_sociedad.catalogoStatusSociedades_idcatalogoStatusSociedades AS statusSociedad  
		 		FROM 
		 		convenio_has_sociedad INNER JOIN sociedad ON idsociedad=sociedad_idsociedad 
		 		WHERE convenio_idconvenio='".$_REQUEST["i"]."'";

		$res=mysql_query($sql);
		while($fil=mysql_fetch_assoc($res))
		{
			$sociedad=implode("-",$fil);
			$sociedades[]=$sociedad;
		}
		$sociedades=implode("|",$sociedades);
		echo $sociedades;
	}

	function guardaStatusCaja()
	{
		global $_REQUEST;

		$idConvenio=$_REQUEST["ic"];
		$sociedad=$_REQUEST["nc"];
		$statusElegido=$_REQUEST["v"];

		$sql="UPDATE convenio_has_sociedad SET catalogoStatusSociedades_idcatalogoStatusSociedades='".$statusElegido."' WHERE convenio_idconvenio='".$idConvenio."' AND sociedad_idsociedad='".$sociedad."'";
		if($res=mysql_query($sql))
		{
			guardaLog(dameIdUserMd5($_SESSION["i"]),13,"convenio_has_sociedad",$idConvenio,$sociedad,$statusElegido);
			echo 1;
		}
		else
			echo 0;
	}

	function dameRegistroMinistraciones($folioIdentificador)
	{
		$sql="SELECT * FROM registrosMinistraciones INNER JOIN ahorradoresMinistrados ON idregistrosMinistraciones=registrosMinistraciones_idregistrosMinistraciones INNER JOIN ahorrador ON ahorrador_idahorrador=idahorrador WHERE ahorrador.folioIdentificador='".$folioIdentificador."'";
		$res=mysql_query($sql);
		$fil=mysql_fetch_assoc($res);
		$regresa=$fil;
		return $regresa;

	}
	//para pruebas 28052100000131
?>