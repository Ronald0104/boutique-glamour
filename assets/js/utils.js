(function ($) {
    $.fn.serializeFormJSON = function () {

        var o = {};
        var a = this.serializeArray();
        $.each(a, function () {
            if (o[this.name]) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    };
})(jQuery);

// Function Genérica
function zfill(number, width) {
	var numberOutput = Math.abs(number); /* Valor absoluto del número */
	var length = number.toString().length; /* Largo del número */
	var zero = "0"; /* String de cero */

	if (width <= length) {
		if (number < 0) {
			return ("-" + numberOutput.toString());
		} else {
			return numberOutput.toString();
		}
	} else {
		if (number < 0) {
			return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
		} else {
			return ((zero.repeat(width - length)) + numberOutput.toString());
		}
	}
}

function mostrarError(element, message) {
    element.html('<b>¡ERROR!</b> ' + message);
    element.show(1000);
}

function limpiarFormulario(form) {
    form[0].reset();
    // $('#form-user-add')[0].reset();
    var elements = form.find('.form-group > .col-sm-6');
    elements.removeClass('has-success');
}

var pathLoading = urlPath + '/assets/img/loading.gif';
function Call_Progress(e) {
    if (e == true) {
        $(".cls-loading").css({
            "width": "100%",
            "height": "100%",
            "background-color": "#fff",
            "position": "fixed",
            "top": "0px",
            "opacity": "0.5",
            "z-index": "101010",
            "display": "block"
        });
        $(".cls-loading").html("<div style='margin:auto;width:50px;margin-top:25%'><img src='" + pathLoading + "' style='width:30px' alt='' /></div>");
    } else {
        $(".cls-loading").css({
            "width": "0px",
            "height": "0px",
            "background": "#fff",
            "position": "fixed",
            "top": "0px",
            "opacity": "0.5",
            "z-index": "0",
            "display": "none"
        });
        $(".cls-loading").html("");
    }
}

function myPopup(myURL, title, myWidth, myHeight) {
    var left = (screen.width - myWidth) / 2;
    var top = (screen.height - myHeight) / 4;
    var myWindow = window.open(myURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + myWidth + ', height=' + myHeight + ', top=' + top + ', left=' + left);
}

Date.prototype.format = function () {
    return zfill(this.getDate(), 2) + '/' + zfill(this.getMonth() + 1, 2) + '/' + this.getFullYear();
}


const dateFormat = /^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}Z$/;
const dateFormat2 = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;

function reviver(key, value) {
    if (typeof value === "string" && dateFormat.test(value)) {
        return new Date(value);
    }
    else if (typeof value === "string" && dateFormat2.test(value)) {
        return new Date(value);
    }
    return value;
}

function fn_GetDate(strFecha) {
    // Obtener la hora 
    let fecha = new Date();
    let hh = fecha.getHours();
    let mm = fecha.getMinutes();
    let ss = fecha.getSeconds();
    return new Date(Number(strFecha.substring(6, 10)), Number(strFecha.substring(3, 5)) - 1, strFecha.substring(0, 2), hh, mm, ss);
}
function fn_GetDateLocal(strFecha) {
    // Obtener la hora 
    let fecha = new Date();
    let hh = fecha.getHours();
    let mm = fecha.getMinutes();
    let ss = fecha.getSeconds();
    let fechaNew = new Date(Number(strFecha.substring(6, 10)), Number(strFecha.substring(3, 5)) - 1, strFecha.substring(0, 2), hh, mm, ss);    
    return new Date(fechaNew.getTime() - (fechaNew.getTimezoneOffset() * 60000));    
}
function getDate(fecha) {
    if (fecha != undefined) {
        var dia = fecha.substr(0, 2);
        var mes = fecha.substr(3, 2);
        var ano = fecha.substr(6, 4);
        var f = dia + '-' + mes + '-' + ano;
        return new Date(f);
    }
    return fecha;
}

function isValidDate(d) {
    return d instanceof Date && !isNaN(d);
}

// Dar formato a una fecha
function getFormatDate(date) {
	let day = date.getDate();
	let month = date.getMonth();
	let year = date.getFullYear();

	let fechaFormat = zfill(day, 2) + "/" + zfill(month, 2) + "/" + year;
	return fechaFormat;
}

function getRandomArbitrary(min, max) {
    return Math.random() * (max - min) + min;
}

var language_espanol = {
    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};


function importarScript(nombre) {
    var s = document.createElement("script");
    s.src = nombre;
    document.querySelector("head").appendChild(s);
}

function fn_SoloNumeros(e) {
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
        //Usando la definición del DOM level 2, "return" NO funciona.
        e.preventDefault();
    }
}

function fn_Mayusculas(element) {
    if(element == undefined) return;
    $this = (this == window) ? $(element) : $(this);
    // Llamar con call
    // $this = $(this);
    setTimeout(() => { $this.val($this.val().toUpperCase());}, 30);
}