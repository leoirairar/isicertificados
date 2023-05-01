$(function() {
    $('#identificationButton').on('click', function() {
        var id = document.getElementById('identification').value;
        if (!id) {
            return;
        }
        // begin ajax to get employee enrollment
        $.ajax({
            type: "get",
            url: "getEnrollmentEmployeeInformationByIdentification/" + id,
            success: function(response) {
                if ($.fn.DataTable.isDataTable('#employeeEnrollmentInformation')) {
                    $('#employeeEnrollmentInformation').DataTable().destroy();
                }
                employeeEnrollment = $('#employeeEnrollmentInformation').DataTable({
                    lengthMenu: [5, 10, 25, 50, 75, 100],
                    data: response,
                    "columnDefs": [
                        { "className": "dt-center", "targets": [0, 1, 2, 3] },
                        {
                            "title": "Nombre Empleado",
                            "render": function(data, type, row) {
                                return row.full_name;
                            },
                            "targets": 0
                        },
                        {
                            "title": "Nombre Curso",
                            "render": function(data, type, row) {
                                return row.course_name;
                            },
                            "targets": 1
                        },
                        {
                            "title": "Fecha del curso",
                            "render": function(data, type, row) {
                                return row.begin_date;
                            },
                            "targets": 2
                        },
                        {
                            "title": "Certificado",
                            "data": "",
                            "render": function(data, type, row) {
                                return `<a href="viewCertificate/${row.id_enrollment}" target="_blank" class="btn btn-success">Generar certificados</a>`
                            },
                            "targets": 3
                        }
                    ],
                    language: {
                        url: '../js/locales/Spanish.json',
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert("Ocurrió un error al obtener la información del empleado. Por favor, inténtelo de nuevo más tarde.");
            }
        });
    });
    $('#identificationButton').click(function(e) {
        var id = document.getElementById('identification').value;
        if (id === "") {
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor ingrese la cedula de un empleado!',
            })
        } else {
            $.ajax({
                type: "get",
                url: "getEmployeeInformationByIdentification/" + id,
                success: function(response) {
                    $('#employeeInformation').html(response);
                }
            });
        }
    });
});
