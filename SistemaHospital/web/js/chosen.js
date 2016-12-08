$(function() {
    $(".chosen-select").chosen({
        no_results_text:"No se encontraron resultados",
        placeholder_text_single: "Seleccione una opción",
        placeholder_text_multiple: "Seleccione una o más opciones",
        max_shown_results: 5,
        search_contains: true
    });

    var rol_path = $("#admin_rol_new_path").attr("data-path");
    $(".chosen-select-rol").chosen({
        no_results_text: "No se encontraron resultados. <a href='"+rol_path+"'>Agregar nuevo rol</a>.",
        placeholder_text_single: "Seleccione una opción",
        placeholder_text_multiple: "Seleccione una o más opciones",
        max_shown_results: 5,
        search_contains: true
    });

});
