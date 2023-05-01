$(document).ready(function() {

    $.ajax({
        type: "GET",
        url: "getHistoricalTableData",
        success: function(response) {
            $("#historicalTable").empty();
            employeesTable = $('#historicalTable').DataTable({
                autoWidth: false,
                data: response,
                columnDefs: [
                    { title: "Codigo", data: 'code', targets: 0 },
                    { title: "Nombre", data: 'fullname', targets: 1 },
                    { title: "Cedula", data: 'identification', targets: 2, defaultContent: "" },
                    { title: "Curso", data: 'course', targets: 3 },
                    {
                        title: "Constancia",
                        render: function(data, type, row) {
                            return `<a href="viewAttedanceCertificateHistorical/${row.id}" class="btn btn-success">Generar constancia</a>`
                        },
                        targets: 4
                    },
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })
            employeesTable.columns.adjust();

        }
    });

});