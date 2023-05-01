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
    return new Date(Number(strFecha.substring(6, 10)), Number(strFecha.substring(3, 5)) - 1, strFecha.substring(0, 2));
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
