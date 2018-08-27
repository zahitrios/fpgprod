var itemsCount=1;

function doSearch()
{
	var _text = document.getElementById("txtSearch").value;
	if(_text.length!=14)
		alert ("El folio identificador debe ser de 14 digitos");
	else
	{
		cargaInformacion(_text,1,"pantalla");
	}
}

function close_autocomplete()
{
	kac.close();
	document.getElementById("txtSearch").focus();
}

function cambiaColorAhorrador(elemento)
{
    elementos=document.getElementsByClassName("itemListaAhorradores");
    
    for (i = 0; i < elementos.length; i++)    
        elementos[i].style.color = "#fc6160";
    

    elemento.style.color="#666666";
}		

function muestraSeccionMenu(divParaMostrar)
{
    cerrarTodasSeccionesMenu();
     $("#"+divParaMostrar).show(1000);
}

function cerrarTodasSeccionesMenu()
{
    var divsSecciones = ["divDocumentosIdentidad","divMenorDeEdad", "divRepresentanteAlbaceaBeneficiario", "divFormatosIdentidad", "divDocumentosValor", "divDocumentosComprobatorios"];

    divsSecciones.forEach(function(divSeccion) 
    {  
        if(document.getElementById(divSeccion).style.display=="block")
        {
            $("#"+divSeccion).hide(1000);
        }
    });
}


function eliminaVerificaciones(folioIdentificador)
{
    console.log("functions.php?i="+folioIdentificador+"&a=eliminaTodasVerificaciones");

    //Cargo la pantalla de datos inicial
    $.ajax({url: "functions.php?i="+folioIdentificador+"&a=eliminaTodasVerificaciones", success: function(result)
    {   
        alert (result);
        location.reload();
    }});
}


function validaPoderActosDominio(elemento)
{
    var valorElemento =$("input:radio[name="+elemento.name+"]:checked").val();

    if(elemento.name=="originalCartaActosDominio")    
        nombreElemento2="originalPoderNotarialActosDominio";
    
    else if(elemento.name=="originalPoderNotarialActosDominio")    
        nombreElemento2="originalCartaActosDominio";

    var valorElemento2=$("input:radio[name="+nombreElemento2+"]:checked").val();

    if(valorElemento==1 && valorElemento2==1)
    {
        alert ("Solo puede elegir una opcion entre carta poder y poder notarial para actos de dominio");
        //Pongo en 0 el elemento 2
        radios=document.querySelectorAll("[name="+nombreElemento2+"]");
        for (var j = 0; j < radios.length; j++)
        {
            if (radios[j].value === "0")
            {
                radios[j].checked = true;
                break;
            }
        }
    }
}

function muestraAclaracionAhorrador(folioIdentificador)
{
    document.getElementById("cargando").style.display="block";  
    document.getElementById("menuSeccionesLaterales").style.display="none";  
    
    //Cargo la pantalla de datos inicial
     $.ajax({url: "functions.php?i="+folioIdentificador+"&p=1&a=muestraPantalla", success: function(result)
    {   
        document.getElementById("pantalla").innerHTML=result;
        document.getElementById("pantalla").style.display="block";
        document.getElementById("cargando").style.display="none";
        document.getElementById("imagenBanderin").style.display="block";       
    }});

     console.log("functions.php?i="+folioIdentificador+"&a=muestraAclaracionAhorrador");
    //Cargo los datos de la aclaracion
    $.ajax({url: "functions.php?i="+folioIdentificador+"&a=muestraAclaracionAhorrador", success: function(result)
    {   
        document.getElementById("pantallaDinamica").innerHTML=result;
        document.getElementById("pantallaDinamica").style.display="block";
        document.getElementById("cargando").style.display="none";
    }});
}



function muestraVerificacionAhorrador()
{
     document.getElementById("cargando").style.display="block";  
    
    //Cargo la pantalla de datos inicial
     $.ajax({url: "functions.php?i="+folioIdentificador+"&p=1&a=muestraPantalla", success: function(result)
    {   
        document.getElementById("pantalla").innerHTML=result;
        document.getElementById("pantalla").style.display="block";
        document.getElementById("cargando").style.display="none";
        document.getElementById("imagenBanderin").style.display="block";       
    }});

     //Cargo los datos de la verificacion
}

function cargaInformacion(folioIdentificador,pantalla,div)
{

	document.getElementById("cargando").style.display="block";	
	
    //Cargo la pantalla
	 $.ajax({url: "functions.php?i="+folioIdentificador+"&p="+pantalla+"&a=muestraPantalla", success: function(result)
    {   
        document.getElementById(div).innerHTML=result;
        document.getElementById(div).style.display="block";
        document.getElementById("cargando").style.display="none";
        document.getElementById("imagenBanderin").style.display="block";
        document.getElementById("menuSeccionesLaterales").style.display="block";

        if(pantalla==1)
			cargaInformacion(folioIdentificador,2,"pantallaDinamica");

        if(pantalla==2)
            muestraCalendario();
    }});
    
}



function cargaSociedadesConvenio()
{
	var idconvenio=document.getElementById("convenios").value;
	var cadenaHTML="";
	var campos="";
	var cadena="";

	document.getElementById("cargando").style.display="block";
	
	//Cargo la pantalla
	 $.ajax({url: "functions.php?i="+idconvenio+"&a=cargaSociedades", success: function(result)
    {   
    	var sociedades=result.split("|");
    	sociedades.forEach(function(sociedad) 
    	{
    		campos=sociedad.split("-");
    		console.log(campos);
    		cadena = campos[2]+"<br>";
    		var readonly="";    		

    		cadena+= '<div style="text-align:left; margin:0 auto; padding-left:15px;">';

    		if(campos[3]>0)
    		{
    			if(campos[3]==1)
                {
    				cadena+='<input type="radio" name="'+campos[1]+'" value="1" checked>&nbsp;Concurso mercantil<br>';
                    cadena+= '<input type="radio" name="'+campos[1]+'" value="2">&nbsp;Quiebra<br>';
                }
    			else if(campos[3]==2)
                {
    				cadena+='<input type="radio" name="'+campos[1]+'" value="1" >&nbsp;Concurso mercantil<br>';
                    cadena+= '<input type="radio" name="'+campos[1]+'" value="2" checked>&nbsp;Quiebra<br>';
                }
    		}
    		else
    		{
    			cadena+='<input type="radio" name="'+campos[1]+'" value="1">&nbsp;Concurso mercantil<br>';    		
    			cadena+= '<input type="radio" name="'+campos[1]+'" value="2">&nbsp;Quiebra<br>'; 
    		}

    		cadena+= '</div>';
    		cadena+= '<br><br>';
    		//if(campos[3]<=0)
    			cadena+= '<input type="button" value="Guardar" class="botonRojoChico" onclick="guardaStatusCaja(\''+campos[1]+'\',\''+idconvenio+'\');">';
    		
		    cadenaHTML=cadenaHTML+cadena;
		});

        document.getElementById("listaSociedades").innerHTML=cadenaHTML;
        document.getElementById("listaSociedades").style.display="block";
        document.getElementById("cargando").style.display="none";
        
    }});
}


function guardaStatusCaja(nombreRadio,idconvenio)
{
	var statusSeleccionado=$('input[name="'+nombreRadio+'"]:checked').val();
	//Guardo el valor
	$.ajax({url: "functions.php?a=guardaStatusCaja&ic="+idconvenio+"&nc="+nombreRadio+"&v="+statusSeleccionado, success: function(result)
    {   
    	if(result==1)
    	{
    		alert("El status de la sociedad fue guardado exitosamente");
    		cargaSociedadesConvenio();
    	}
    	else
    		alert("Ocurrio un error al guardar el status de la sociedad");
    }});	
}


function evaluaMenorDeEdad(elemento)
{
	var valorMenorEdad=$('input[name="menorDeEdad"]:checked').val();

    if(valorMenorEdad==1)
    {
        document.getElementById("divSiEsMenorDeEdad").style.display='block';
        document.getElementById("divNoEsMenorDeEdad").style.display='none';

        document.getElementById("originalDocumentoTutela").required="true";
        document.getElementById("originalDocumentoAdopcion").required="true";
        document.getElementById("copiaCertificadaActaMenorEdad").required="true";
    }
    else
    {
        document.getElementById("divSiEsMenorDeEdad").style.display='none';
        document.getElementById("divNoEsMenorDeEdad").style.display='block';

        document.getElementById("originalDocumentoTutela").required="";
        document.getElementById("originalDocumentoAdopcion").required="";
        document.getElementById("copiaCertificadaActaMenorEdad").required="";
    }
}


function evaluaYMuestra(elemento,divsParamostrar,modo,elementoRequired)
{
	var modo1="block";
	var modo2="none";
	var requerido1="true"
	var requerido2="";
    elementoRequired=elementoRequired+",";
    divsParamostrar=divsParamostrar+",";
    var elementosRequired=elementoRequired.split(",");
    var divsParamostrar=divsParamostrar.split(",");
    var valorElemento =$("input:radio[name="+elemento.name+"]:checked").val();

	if(modo=="inversa")
	{
		modo1="none";
		modo2="block";
		requerido1="";
		requerido2="true";
	}

	if(valorElemento==1 || valorElemento==true)
	{
		//document.getElementById(divParamostrar).style.display=modo1;
        divsParamostrar.forEach(function(element) 
        {
            try
            {
                document.getElementById(element).style.display=modo1;
            }
            catch(err)
            {
                console.log(element);
            }

        });

        elementosRequired.forEach(function(element) 
        {
            try
            {
                document.getElementById(element).required=requerido1;

            }
            catch(err)
            {
                console.log(element);
            }
        });
		
	}
	else
	{
		//document.getElementById(divParamostrar).style.display=modo2;
        divsParamostrar.forEach(function(element) 
        {
        	try
        	{
            	document.getElementById(element).style.display=modo2;
            }
            catch(err){}
        });
        elementosRequired.forEach(function(element) 
        {
            try
            {	
            	document.getElementById(element).required=requerido2;
            }
            catch(err){}
        });
	}
}


function muestraDraggable(tipo,parametroUno)
{
	var urlAux;

	document.getElementById("cargando").style.display="block";

    if(tipo==1) //Mostrar lista de documentos aceptados
    	urlAux="functions.php?a=muestraDocumentosAceptados&i="+parametroUno;

    else if(tipo==2)//Mostrar los saldos
        urlAux= "../ahrs/functions.php?a=muestraSaldosAhorrador&fI="+parametroUno;

    $.ajax({url: urlAux, success: function(result)
    { 
    	$( "#draggable" ).draggable();
    	document.getElementById("draggable").style.display="block";		
    	document.getElementById("draggable").innerHTML='<img id="botonCerrar" src="../img/cerrar.png" onclick="oculta(\'draggable\');">';
    	document.getElementById("draggable").innerHTML+=result;
    	document.getElementById("cargando").style.display="none";

    }});
}
function muestraPrimera(parametroUno,parametroDos)
{
    var urlAux;

    document.getElementById("cargando").style.display="block";

    /*if(tipo==1) //Mostrar lista de documentos aceptados
        urlAux="functions.php?a=muestraDocumentosAceptados&i="+parametroUno;

    else if(tipo==2)//Mostrar los saldos*/
        urlAux= "../verf/functions.php?a=muestraPrimeraDocCompro&i="+parametroUno+"&y="+parametroDos;
    console.log(urlAux);

    $.ajax({url: urlAux, success: function(result)
    { 
        $( "#draggable" ).draggable();
        document.getElementById("draggable").style.display="block";     
        document.getElementById("draggable").innerHTML='<img id="botonCerrar" src="../img/cerrar.png" onclick="oculta(\'draggable\');">';
        document.getElementById("draggable").innerHTML+=result;
        document.getElementById("cargando").style.display="none";

    }});
}
function muestraSegunda(parametroUno)
{
    var urlAux;

    document.getElementById("cargando").style.display="block";

    /*if(tipo==1) //Mostrar lista de documentos aceptados
        urlAux="functions.php?a=muestraDocumentosAceptados&i="+parametroUno;

    else if(tipo==2)//Mostrar los saldos*/
        urlAux= "../verf/functions.php?a=muestraSegundaDocCompro&i="+parametroUno;

    $.ajax({url: urlAux, success: function(result)
    { 
        $( "#draggable" ).draggable();
        document.getElementById("draggable").style.display="block";     
        document.getElementById("draggable").innerHTML='<img id="botonCerrar" src="../img/cerrar.png" onclick="oculta(\'draggable\');">';
        document.getElementById("draggable").innerHTML+=result;
        document.getElementById("cargando").style.display="none";

    }});
}

function buscaLogVerificacion(parametroUno,parametroDos)
{
    var urlAux;

    document.getElementById("cargando").style.display="block";

    /*if(tipo==1) //Mostrar lista de documentos aceptados
        urlAux="functions.php?a=muestraDocumentosAceptados&i="+parametroUno;

    else if(tipo==2)//Mostrar los saldos*/
        
   urlAux= "../verf/functions.php?a=buscaLogVerificacion&i="+parametroUno+"&y="+parametroDos;
    console.log(urlAux);

    $.ajax({url: urlAux, success: function(result)
    { 
        $( "#draggable" ).draggable();
        document.getElementById("draggable").style.display="block";     
        document.getElementById("draggable").innerHTML='<img id="botonCerrar" src="../img/cerrar.png" onclick="oculta(\'draggable\');">';
        document.getElementById("draggable").innerHTML+=result;
        document.getElementById("cargando").style.display="none";

    }});
}


function oculta(idelemento)
{
	document.getElementById(idelemento).style.display="none";
}


function muestraCalendario()
{
    var fechaPublicacion=document.getElementById("fechaPublicadoDOF").value;
    var partes=fechaPublicacion.split("-");
    partes[0]=parseInt(partes[0], 10);
    partes[1]=parseInt(partes[1], 10);
    partes[2]=parseInt(partes[2], 10);


    var fechaFinal=new Date(partes[0], partes[1]-1, partes[2]);    
    fechaFinal.setDate(fechaFinal.getDate() + 59);
    
    $("#datepicker").datepicker({
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        minDate: new Date(partes[0], partes[1]-3, partes[2]),
        //maxDate: new Date(partes[0], partes[1]+1, partes[2]),        
        maxDate:fechaFinal,        
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: false,
        dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]
    });

    $("#datepicker2").datepicker({
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        minDate: new Date(partes[0], partes[1]-1, partes[2]),
        //maxDate: new Date(partes[0], partes[1]+1, partes[2]),        
        maxDate:fechaFinal,        
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: false,
        dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]
    });


    $("#datepicker3").datepicker({
        monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Augosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
        monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        dayNamesMin: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"]
    });


}

function ocultaTodoRepresentanteLegal()
{
    //oculta todo
    divDetalleOcultar="divPersonaMoralDetalle";
    divDetalleOcultar2="divPersonaFisicaDetalle";

    divOcultar=document.getElementById(divDetalleOcultar);
    divOcultar2=document.getElementById(divDetalleOcultar2);

    divOcultar.style.display="none";
    divOcultar2.style.display="none";

    $(divOcultar).find('input:radio').each(function() 
    {
        $(this).attr("required", false);
    });
    $(divOcultar2).find('input:radio').each(function()
    {
        $(this).attr("required", false);
    });
}   

function evaluaTipoPersonaRepresentante(elemento)
{

    ocultaTodoRepresentanteLegal();

    if(elemento.value=="fisica" || elemento.value=="moral")
    {
        
        if(elemento.value=="fisica")
        {
            divDetalleMostrar="divPersonaFisicaDetalle";
            divDetalleOcultar="divPersonaMoralDetalle";
        }

        if(elemento.value=="moral")
        {
            divDetalleMostrar="divPersonaMoralDetalle";
            divDetalleOcultar="divPersonaFisicaDetalle";
        }

        divMostrar=document.getElementById(divDetalleMostrar);
        divOcultar=document.getElementById(divDetalleOcultar);

        divMostrar.style.display="block";
        divOcultar.style.display="none";

        $(divMostrar).find('input:radio').each(function() 
        {
            $(this).attr("required", true);
        });
        $(divOcultar).find('input:radio').each(function()
        {
            $(this).attr("required", false);
        });

    }
}


function hacerSubmitFormularioPrincipal()
{
    
    var parametros=$("#formularioInformacionParcial").serialize();
    var urlAux= "./functions.php?"+parametros;
   
    var banderaError=0;
    var erroresFormulario=new Array();

    $('#formularioInformacionParcial input, #formularioInformacionParcial select').each(function(index)
    {  
            var input = $(this);
            var requerido=input.prop('required');
            if(!requerido)
            {
                //console.log("No requerido");
            } 
            else 
            {
                //console.log("Si requerido");
                if(input.attr('type')=="radio") //ES UN RADIO
                {
                    var valorRadio=$('input[name='+input.attr('name')+']:checked', '#formularioInformacionParcial').val();
                    //console.log('Es radio - Name: ' + input.attr('name') + ' - Value: ' + valorRadio);
                    if (valorRadio==undefined || valorRadio=="")
                    {
                        banderaError=1;
                        erroresFormulario[erroresFormulario.length]="Debe seleccionar un valor para " + input.attr('name');
                    }
                }
                else if(input.val()=="") //ES UN SELECT VACIO
                {
                    //console.log('Es select - Name: ' + input.attr('name') + ' - Value: ' + input.val());
                    banderaError=1;
                    erroresFormulario[erroresFormulario.length]="Debe seleccionar un valor para " + input.attr('name');
                }
                if(input.attr('type')=="text" && input.val()=="" )//ES UN TEXT VACIO
                {
                    //console.log('Es text - Name: ' + input.attr('name') + ' Type - ' + input.attr('type') + ' - Value: ' + valorRadio);
                    banderaError=1;
                    erroresFormulario[erroresFormulario.length]="Debe ingresar un valor para " + input.attr('name');
                }

            }
        }
    );

    if(banderaError==1) //Hay error en el formulario
    {
        var erroresFormulario = erroresFormulario.filter(function(itm, i, a)
        {
            return i == erroresFormulario.indexOf(itm);
        });
        //console.log(erroresFormulario);
        alert ("Se detectaron los siguientes errores en el formulario: \n" + erroresFormulario.join("\n"));
    }
    else //Todo bien en el formulario
    {
        if(confirm("¿Esta seguro de que desea guardar esta revisión?"))
        {
            $.ajax({url: urlAux, success: function(result)
            { 
                document.getElementById("cargando").style.display="block";
                alert (result);
                document.getElementById("cargando").style.display="none";

               // disminuyeAumentaTamanoBuscador('tablaBusquedaPorContenedor');
                oculta("imagenBanderin");
                oculta("auxiliarDiseno");
                oculta("pantalla");
                oculta("menuSeccionesLaterales");
                oculta("pantallaDinamica");
                muestraAhorradoresContenedor(document.getElementById("idContenedorBuscador").value);

            }});

            if(document.getElementById("a").value=="guardaVerificacionFinal")
            {
                console.log("./functions.php?a=evaluaAclaracion&folio="+folioIdentificador);
                var folioIdentificador=document.getElementById("folioIdentificadorPantalla").value;
                $.ajax({url:"./functions.php?a=evaluaAclaracion&folio="+folioIdentificador, success: function(result)
                {
                    alert (result);
                }});
            }
        }
    }
}

function evaluaAlbaceaBeneficiario(elemento,event)
{
    // beneficiarioDecimoSegundo
    // herederoDecimoPrimero
    // albaceaDecimo
    //representanteLegal

    var valorElemento =$("input:radio[name="+elemento.name+"]:checked").val();
    var nombre=elemento.name;
   
    if(elemento.name=='representanteLegal' && valorElemento=="1")
    {
        aux1="albaceaDecimo";
        aux2="herederoDecimoPrimero";
        aux3="beneficiarioDecimoSegundo";
    }

    else if(elemento.name=='beneficiarioDecimoSegundo' && valorElemento=="1")
    {
        aux1="herederoDecimoPrimero";
        aux2="albaceaDecimo";
        aux3="representanteLegal";
    }
    else if(elemento.name=='herederoDecimoPrimero' && valorElemento=="1")
    {
        aux1="beneficiarioDecimoSegundo";
        aux2="albaceaDecimo";
        aux3="representanteLegal";
    }
    else if(elemento.name=='albaceaDecimo' && valorElemento=="1")
    {
        aux1="beneficiarioDecimoSegundo";
        aux2="herederoDecimoPrimero";
        aux3="representanteLegal";
    }
   
    valorElemento1=$("input:radio[name="+aux1+"]:checked").val();
    valorElemento2=$("input:radio[name="+aux2+"]:checked").val();
    valorElemento3=$("input:radio[name="+aux3+"]:checked").val();
   
    if(valorElemento=="1")
    {
        if(valorElemento1=="1" || valorElemento2=="1" || valorElemento3=="1" )
        {
            alert("Solo puede elegir Representante, Albacea, Heredero o Beneficiario");

            radios=document.querySelectorAll("[name="+nombre+"]");
            for (var j = 0; j < radios.length; j++)
            {
                if (radios[j].value === "0")
                {
                    radios[j].checked = true;
                    break;
                }
            }

            event.stopPropagation();            
            return false;
        }

        //Todos los que no eligió los pongo en 0
        radios=document.querySelectorAll("[name="+aux1+"]");
        for (var j = 0; j < radios.length; j++)
        {
            if (radios[j].value === "0")
            {
                radios[j].checked = true;
                break;
            }
        }
        radios=document.querySelectorAll("[name="+aux2+"]");
        for (var j = 0; j < radios.length; j++)
        {
            if (radios[j].value === "0")
            {
                radios[j].checked = true;
                break;
            }
        }
        radios=document.querySelectorAll("[name="+aux3+"]");
        for (var j = 0; j < radios.length; j++)
        {
            if (radios[j].value === "0")
            {
                radios[j].checked = true;
                break;
            }
        }
        //Todos los que no eligió los pongo en 0
    }


    //Dijo que no en el representante legal, tengo que ocultar subelemento y subelementos del represetante legal

    else if(elemento.name=='representanteLegal')
    {
        document.getElementById("tipoPersonaRepresentante").value="";
        ocultaTodoRepresentanteLegal();
    }
    //console.log("nombre: " + elemento.name);
}



function evaluaDocumentoAclaracion(elemento)
{
    var nombre=elemento.name;
    var partesNombre=nombre.split("_");

    var valorElemento =$('[name="'+partesNombre[0]+'_'+partesNombre[1]+'"]:checked').val();

    if(valorElemento==1)
    {
        document.getElementById("motivoAclaracion"+partesNombre[1]).style.display="block";
        document.getElementById("motivoAclaracion"+partesNombre[1]).required="true";
    }
    else
    {
        document.getElementById("motivoAclaracion"+partesNombre[1]).style.display="none";
        document.getElementById("motivoAclaracion"+partesNombre[1]).required="";
    }
}

function evaluaFallecido(elemento)
{
    var valorElemento =$("input:radio[name="+elemento.name+"]:checked").val();
    if(valorElemento==1)
    {

    }
}


function agregaItem()
{
    var original=document.getElementById("itemOriginal");
    var clon=original.cloneNode(true);

    var inputs=clon.getElementsByClassName("input");
    
    clon.id="";
    itemsCount++;

    for(i=0; i < inputs.length; i++)
    {
        if((inputs[i].name).indexOf("aclaracion_") == -1)
            inputs[i].value="";

        inputs[i].name=inputs[i].name.replace(/\[(.?)\]/g, "["+itemsCount+"]");
        inputs[i].id=inputs[i].name.replace(/\[(.?)\]/g, "["+itemsCount+"]");

        if((inputs[i].name).indexOf("numeroDocumento") > -1)
            inputs[i].value=itemsCount;
    }

    clon.querySelector(".borraItem").disabled=false;
    original.parentNode.appendChild(clon);

    reordenaNumeroDocumentos();
}

function borraItem(item)
{
    var cont=item.closest(".pedidoItem");
    cont.parentNode.removeChild(cont);
    itemsCount--;

    reordenaNumeroDocumentos();
}


function reordenaNumeroDocumentos()
{

    var valores=1;

    var inputs=document.getElementsByClassName("input");
    for(i=0; i < inputs.length; i++)
    {
        if((inputs[i].name).indexOf("numeroDocumento") > -1)
        {
           // console.log("name: " + inputs[i].name + " si "+ valores);
            inputs[i].value=valores;
            valores++;
        }
        // console.log("\n");

       
    }

}


function verificaDocumentos()
{
    document.getElementById("cargando").style.display="block";

    var inputs=document.getElementsByClassName("input");
    var resultadoConcatenado=new Array();
    var indiceResultadoConcatenado=0;
    var documentosVerificados=0;
    var indiceArray=-1;
    var indiceArray2=0;
    var arrayDocumentos=new Array();
    var folioIdentificador=document.getElementById("folioIdentificadorPantalla").value;

    for(i=0; i < inputs.length; i++)
    {
        if((inputs[i].name).indexOf("numeroDocumento") > -1)
        {
            indiceArray++;
            arrayDocumentos[indiceArray]=new Array();
            indiceArray2=0;
        }
        arrayDocumentos[indiceArray][indiceArray2]=inputs[i].value;
        indiceArray2++;
    }

    for(i=0; i < arrayDocumentos.length; i++)
    {
        arrayDocumentos[i].splice(5,3);
        //Cargo la pantalla
        $.ajax({url: "functions.php?a=validaDocumentoVerificacion&i="+folioIdentificador+"&d="+arrayDocumentos[i], success: function(result)
        {   
           resultadoConcatenado[indiceResultadoConcatenado]=result;
           indiceResultadoConcatenado++;
           documentosVerificados++;
        }});
    }


    handler=setInterval(function()
    { 
        if(documentosVerificados==itemsCount)
        {
            console.log(resultadoConcatenado);

            $( "#draggable" ).draggable();
            document.getElementById("draggable").style.display="block";     
            document.getElementById("draggable").innerHTML='<img id="botonCerrar" src="../img/cerrar.png" onclick="oculta(\'draggable\');">';
            document.getElementById("draggable").innerHTML+=resultadoConcatenado.join("<br>");
            document.getElementById("cargando").style.display="none";

            clearInterval(handler);
        }
    }, 1000);


   
    
}



function muestraBuscadorContenedor()
{

    if(document.getElementById("buscadorPorFolio").style.display=='block')
    {    
        $("#buscadorPorFolio").hide(1000);
        document.getElementById("buscadorPorFolio").style.display='none';
    }

    if(document.getElementById("buscadorPorContenedor").style.display=='none')    
    {
        $("#buscadorPorContenedor").show(1000);
        document.getElementById("buscadorPorContenedor").style.display='block';
    }
}


function muestraBuscadorFolio()
{
    if(document.getElementById("buscadorPorContenedor").style.display=='block')    
    {
        $("#buscadorPorContenedor").hide(1000);
        document.getElementById("buscadorPorContenedor").style.display='none';
    }

    if(document.getElementById("buscadorPorFolio").style.display=='none')    
    {
        $("#buscadorPorFolio").show(1000);
        document.getElementById("buscadorPorFolio").style.display='block';
    }
}


function cargaContenedoresDelConvenio(idConvenio)
{
    var contenedores;
    var elementosContenedor;
    var cadenaFinal;

    document.getElementById("cargando").style.display="block";
    document.getElementById("divSelectContenedores").innerHTML="";

    //Cargo los contenedores
    $.ajax({url: "functions.php?a=dameContenedores&i="+idConvenio, success: function(result)
    {   
        cadenaFinal="<select id='idContenedorBuscador' name='idContenedorBuscador' onchange='muestraAhorradoresContenedor(this.value);'>";
            cadenaFinal+="<option value='' >Seleccione un contenedor</option>";

            contenedores=result.split("|");
            contenedores.forEach(function(element)
            {            
                elementosContenedor=element.split("#");
                cadenaFinal+="<option value='"+elementosContenedor[0]+"' >Contenedor número "+elementosContenedor[3]+" - ("+elementosContenedor[9]+" ahorradores)</option>";
                //console.log(elementosContenedor);
            });

        cadenaFinal+="</select>";

        document.getElementById("cargando").style.display="none";
        document.getElementById("divSelectContenedores").innerHTML=cadenaFinal;
        //console.log(cadenaFinal);
    }});
}

function muestraAhorradoresContenedor(idContenedor)
{
    document.getElementById("cargando").style.display="block";

    //console.log(idContenedor);

     //Cargo los ahorradores
    $.ajax({url: "functions.php?a=dameAhorradoresContenedor&i="+idContenedor, success: function(result)
    {   
        document.getElementById("cargando").style.display="none";
        document.getElementById("divListaAhorradoresContenedores").innerHTML=result;
        //console.log(cadenaFinal);
    }});
}

function cargaAhorradorDeLista(folioIdentificador)
{    
    disminuyeAumentaTamanoBuscador("tablaBusquedaPorContenedor");
    document.getElementById("txtSearch").value=folioIdentificador;
    doSearch();
}

function disminuyeAumentaTamanoBuscador(elemento)
{
    var elemento=document.getElementById(elemento);

    if(elemento.style.height!="25px")
    {
        elemento.style.height="25px";
        elemento.style.overflow="hidden";
    }
    else
    {
        elemento.style.height="auto";
        elemento.style.overflow="auto";
    }
}

