$(function() {
    $(".chosen-select").chosen({
        no_results_text: "El paciente no existe. <a href=\"./app_dev.php/paciente/new\">Agregar Paciente</a>",
        placeholder_text_single: "Ingrese un valor.",
        max_shown_results: 2,
        search_contains: true,
    });
});