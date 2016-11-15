$(document).ready(function () {

    function genericoAjax(url, funcion, parametros, combo) {
        $.ajax({
            type: 'POST',
            url: url,
            async: false,
            data: parametros,
            dataType: "text",
            success: function(data){funcion(data,combo)},
            error: function (jqXHR, textStatus, errorThrown) {
                alert("error ajax"+errorThrown)
            }
        });
    }

    //combo debe ser un objeto jquery referenciando a un select
    function genericoSelect(data, combo) {
        console.log("data: "+data+" data.d: "+data.d);
        if (data.d != null) {
            var dataSel = data.d;
            var dataSelJSON = $.parseJSON(dataSel);
            combo.empty();
            combo.append($('<option></option>').val('').text('Seleccionar...'));

            $(dataSelJSON).each(function () {
                option = $('<option></option>');
                option.text(this.nombre);
                option.attr('value', this.id);
                combo.append(option);
            });
        }
    }

    //combo debe ser un objeto jquery referenciando a la etiqueta contenedora
    function genericoHtml(data, combo) {
        console.log("data: "+data+" data.d: "+data.d);
        if (data != null) {
            var dataSel = data;
            combo.empty();
            combo.html(dataSel);
        }
    }

});
