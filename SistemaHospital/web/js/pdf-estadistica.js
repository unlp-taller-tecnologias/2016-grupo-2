function demoFromHTML() {
    var logo = new Image();
    logo.src = '../../../rr.png';
    logo.onload = function () {

        var desde = document.getElementById("form_fechaIni").value;
        var hasta = document.getElementById("form_fechaFin").value;
        var cantidadservicios = document.getElementById("cantidadservicios").value;
        var pdf = new jsPDF('l', 'pt', 'letter');


        pdf.addImage(logo, 'PNG', 40, 20, 50, 50);
        pdf.text(100, 55, 'Hospital Rodolfo Rossi - Sistema Gestión de Quirófano');
        pdf.text(40, 90, 'Operaciones Realizadas desde: ' + desde + ' hasta: ' + hasta);

        var columns = ["Servicio", "Cirugias Programadas", "Cirugias por Guardia", "Cirugias con Anestesia", "Total"];

        var rows = new Array();

        for (var i = 1; i < cantidadservicios; i++) {
            var servicio = document.getElementById("servicio[" + i + "]").innerText;
            var programadas = document.getElementById("programadas[" + i + "]").innerText;
            var guardia = document.getElementById("guardia[" + i + "]").innerText;
            var anestesia = document.getElementById("anestesia[" + i + "]").innerText;
            var total = document.getElementById("total[" + i + "]").innerText;

            var aux = [servicio, programadas, guardia, anestesia, total];
            rows.push(aux);
        }

        pdf.autoTable(columns, rows, {
            theme: 'striped',
            startY: 110,
        });
        pdf.save('Hospital Rodolfo Rossi - Sistema de Gestión de Quirófano.pdf');
    }
}
