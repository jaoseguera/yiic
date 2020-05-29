(function($){
    $.fn.validationEngineLanguage = function(){
		
    };
    $.validationEngineLanguage = {
		
        newLang: function(){
            $.validationEngineLanguage.allRules = {
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "ninguna",
                    "alertText": "* Este campo es requerido",
                    "alertTextCheckboxMultiple": "* Por favor seleccione una opción",
                    "alertTextCheckboxe": "* Esta casilla de verificación es obligatoria.",
                    "alertTextDateRange": "* Ambos campos de rango de fechas son obligatorios"
                },
                "requiredInFunction": { 
                    "func": function(field, rules, i, options){
                        return (field.val() == "test") ? true : false;
                    },
                    "alertText": "* El campo debe ser igual a prueba"
                },
                "dateRange": {
                    "regex": "ninguna",
                    "alertText": "* Invalido ",
                    "alertText2": "Rango de fechas"
                },
                "dateTimeRange": {
                    "regex": "ninguna",
                    "alertText": "* Invalido ",
                    "alertText2": "Fecha hora rango"
                },
                "minSize": {
                    "regex": "ninguna",
                    "alertText": "* Minimo ",
                    "alertText2": " caracteres permitidos"
                },
                "maxSize": {
                    "regex": "ninguna",
                    "alertText": "* Maximo ",
                    "alertText2": " caracteres permitidos"
                },
				"groupRequired": {
                    "regex": "ninguna",
                    "alertText": "* Debes rellenar uno de los siguientes campos"
                },
                "min": {
                    "regex": "ninguna",
                    "alertText": "* El valor mínimo es "
                },
                "max": {
                    "regex": "ninguna",
                    "alertText": "* El valor maximo es "
                },
                "past": {
                    "regex": "ninguna",
                    "alertText": "* Fecha anterior a "
                },
                "future": {
                    "regex": "ninguna",
                    "alertText": "* Fecha pasada "
                },	
                "maxCheckbox": {
                    "regex": "ninguna",
                    "alertText": "* Maximum ",
                    "alertText2": " options allowed"
                },
                "minCheckbox": {
                    "regex": "ninguna",
                    "alertText": "* Por favor selecione ",
                    "alertText2": " opciones"
                },
                "equals": {
                    "regex": "ninguna",
                    "alertText": "* Los campos no concuerdan"
                },
				"notequals": {
                    "regex": "ninguna",
                    "alertText": "* El rol predeterminado no se acepta"
                },
                "creditCard": {
                    "regex": "ninguna",
                    "alertText": "* Número de tarjeta de crédito no válido"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/,
                    "alertText": "* Número de télefono no válido"
                },
                "email": {
                    // HTML5 compatible email regex ( http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#    e-mail-state-%28type=email%29 )
                    "regex": /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/,
                    "alertText": "* Dirección de correo electrónico no válido"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* no es un entero válido"
                },
				
				"zip": {
                    // "regex": /^\d{5}(-\d{4})?$/,
                    "regex": /(^\d{6}$)|(^\d{5}(-\d{4}$))/,
                    "alertText": "* No es un código postal válido"
                },
				"salesorder": {
                    "regex": /^\d{4}$/,
                    "alertText": "* Organización de ventas no válida"
                },
					"password": {
                    "regex": /^(?=.*\d)(?=.*[a-zA-Z]).{6,}$/,
                    "alertText": "* La contraseña debe contener al menos 6-8 dígitos con caracteres alfanuméricos."
                },
				"customer": {
                    "regex": /^\d{1,10}$/,
                    "alertText": "* Número de cliente no válido"
                },
					"divi": {
                    "regex": /^\d{2}$/,
                    "alertText": "* División inválida"
                },
				"rel_code": {
                    "regex": /^\d{2}$/,
                    "alertText": "* Código de lanzamiento no válido"
                },
					"dis": {
                    "regex": /^\d{2}$/,
                    "alertText": "* Canal de distribución no válido"
                },
					"pg": {
                    "regex": /^\d{4}$/,
                    "alertText": "* Grupo de compra no válido"
                },
					"ven": {
                    "regex": /^\d{1,10}$/,
                    "alertText": "* Número de vendedor no válido"
                },
					"pla": {
                    "regex": /^\d{2,4}$/,
                    "alertText": "* Planta inválida"
                },

	                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^[\-\+]?(([0-9]+)([\.,]([0-9]+))?|([\.,]([0-9]+))?)$/,
                    "alertText": "* Número decimal no válido"
                },
                "date": {
                    "regex": /^(0[1-9]|1[012])[/](0[1-9]|[12][0-9]|3[01])[/](19|20)\d\d$/,
                    "alertText": "* Fecha inválida, debe estar en formato MM / DD / YYYY"
                },
                "ipv4": {
                    "regex": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Dirección IP inválida"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* URL inválida"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Solo numeros"
                },
                "onlyLetterSp": {
                    "regex": /^[a-zA-Z\ \']+$/,
                    "alertText": "* Solo letras "
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z]+$/,
                    "alertText": "* No se permiten caracteres especiales"
                },
                // --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertText": "* Este usuario ya está tomado",
                    "alertTextLoad": "* Validando, por favor espere"
                },
				"ajaxUserCallPhp": {
                    "url": "phpajax/ajaxValidateFieldUser.php",
                    // you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Este nombre de usuario está disponible",
                    "alertText": "* Este usuario ya está tomado",
                    "alertTextLoad": "* Validando, por favor espere"
                },
                "ajaxNameCall": {
                    // remote json service location
                    "url": "ajaxValidateFieldName",
                    // error
                    "alertText": "* Este usuario ya está tomado",
                    // if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Este usuario ya está tomado",
                    // speaks by itself
                    "alertTextLoad": "* Validando, por favor espere"
                },
				 "ajaxNameCallPhp": {
	                    // remote json service location
	                    "url": "phpajax/ajaxValidateFieldName.php",
	                    // error
	                    "alertText": "* Este usuario ya está tomado",
	                    // speaks by itself
	                    "alertTextLoad": "* Validando, por favor espere"
	                },
                "validate2fields": {
                    "alertText": "* Por favor ingrese HELLO"
                },
	            //tls warning:homegrown not fielded 
                "dateFormat":{
                    "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(?:(?:0?[1-9]|1[0-2])(\/|-)(?:0?[1-9]|1\d|2[0-8]))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^(0?2(\/|-)29)(\/|-)(?:(?:0[48]00|[13579][26]00|[2468][048]00)|(?:\d\d)?(?:0[48]|[2468][048]|[13579][26]))$/,
                    "alertText": "* Fecha invalida"
                },
                //tls warning:homegrown not fielded 
				"dateTimeFormat": {
	                "regex": /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1}$|^(?:(?:(?:0?[13578]|1[02])(\/|-)31)|(?:(?:0?[1,3-9]|1[0-2])(\/|-)(?:29|30)))(\/|-)(?:[1-9]\d\d\d|\d[1-9]\d\d|\d\d[1-9]\d|\d\d\d[1-9])$|^((1[012]|0?[1-9]){1}\/(0?[1-9]|[12][0-9]|3[01]){1}\/\d{2,4}\s+(1[012]|0?[1-9]){1}:(0?[1-5]|[0-6][0-9]){1}:(0?[0-6]|[0-6][0-9]){1}\s+(am|pm|AM|PM){1})$/,
                    "alertText": "* Fecha No Válida o Formato De Fecha",
                    "alertText2": "Formato esperado: ",
                    "alertText3": "mm/dd/yyyy hh:mm:ss AM|PM or ", 
                    "alertText4": "yyyy-mm-dd hh:mm:ss AM|PM"
	            }
            };
            
        }
    };

    $.validationEngineLanguage.newLang();
    
})(jQuery);
