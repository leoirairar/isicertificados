$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var employeeId = document.getElementById('employeeId');
    if (employeeId) {
        var id = employeeId.value;
        // Resto del código
    } else {
        // El elemento no existe, hacer algo aquí
    }
    // begin ajax to get employee enrollment
    $.ajax({
        type: "get",
        url: "getEnrollmentEmployeeInformation/" + id,
        success: function(response) {

            employeeEnrollment = $('#employeeEnrollmentInformation').DataTable({
                    lengthMenu: [5, 10, 25, 50, 75, 100],
                    data: response,
                    "columnDefs": [
                        { "className": "dt-center", "targets": [0, 1, 2, 3, 4] },
                        {
                            "title": "Nombre Curso",
                            "data": 'course_programming.course',
                            "render": function(data, type, row) {
                                return data.name + ' ' + data.course_code;

                            },
                            "targets": 0
                        },
                        {
                            "title": "Fecha del curso",
                            "data": 'course_programming.begin_date',
                            "render": function(data, type, row) {
                                return data;

                            },
                            "targets": 1
                        },
                        {
                            "title": "Estado en el curso",
                            "data": "status_employee",
                            "render": function(data, type, row) {

                                if (row.certificate == null) {

                                    if (row.cancel == 1) {
                                        return 'Cancelado';
                                    }

                                    if (row.reschedule === 1) {
                                        return 'Reprogramado';
                                    }

                                    if (row.status_employee === 1) {
                                        return 'Inscrito';
                                    } else {
                                        return 'Preinscrito';
                                    }
                                } else {

                                    if (row.certificate.status === 0) {
                                        return 'Certificado'
                                    } else {
                                        return 'Finalizado'
                                    }


                                }



                            },
                            "targets": 2
                        },
                        {
                            "title": "juicio",
                            "data": "certificate",
                            "render": function(data, type, row) {
                                if (data !== null) {
                                    if (data.statement === 1) {
                                        return 'Aprobó';
                                    } else {
                                        return 'Reprobó';
                                    }
                                } else {
                                    return 'Sin Juicio';
                                }


                            },
                            "targets": 3
                        },
                        {
                            "title": "Certificado",
                            "data": "certificate",
                            "render": function(data, type, row) {
                                if (data !== null) {
                                    return `<a href="viewCertificate/${row.id}" target="_blank" class="btn btn-success">Generar certificados</a>`
                                } else {
                                    return 'Aun no ha finalizado el curso ¡¡¡¡';
                                }
                            },
                            "targets": 4
                        },

                    ],
                    language: {

                        url: '../js/locales/Spanish.json',

                    }
                })
                //employeeEnrollment.columns.adjust(); 
        }
    });


    //begin ajax table to reprogramar users. 
    $.ajax({
        type: "get",
        url: "rescheduleEmployeeById/" + id,
        success: function(response) {
    

            var rescheduleEmployee = $('#rescheduleEmployee').DataTable({
                lengthMenu: [5, 10, 25, 50, 75, 100],
                data: response[0],
                "columnDefs": [
                    { "className": "dt-center", "targets": [0] },
                    {
                        "title": "Nombre",
                        "data": '',
                        "render": function(data, type, row) {
                            return row.employee.user.name + ' ' + row.employee.user.last_name;

                        },
                        "targets": 0
                    },
                    {
                        "title": "Curso a reprogramar",
                        "data": '',
                        "render": function(data, type, row) {
                            return row.course_programming.course.name + ' - ' + row.course_programming.begin_date;

                        },
                        "targets": 1
                    },
                    {
                        "title": "Nuevas fechas disponibles",
                        "data": '',
                        "render": function(data, type, row) {
                            var $select = $('<select></select>', {
                                'id': 'courseProgrammed',
                                'class': 'form-control'
                            });
                            response[1].forEach(element => {
                                element.forEach(e => {

                                    if (row.course_programming.course_id == e.course_id) {
                                        var $option = $("<option></option>", {
                                            "text": e.course.name + ' - ' + e.begin_date,
                                            "value": e.id

                                        });
                                        $select.append($option);

                                    }

                                });
                            });
                            return $select.prop("outerHTML");;

                        },
                        "targets": 2
                    },
                    {
                        title: "Reprogramar",
                        data: "",
                        render: function(data, type, row) {
                            return `<button type="button" id="btn" class="btn btn-primary">Reprogramar</button>`;
                        },
                        targets: 3,
                    },

                ],
                language: {

                    url: '../js/locales/Spanish.json',

                }
            })

            $('#rescheduleEmployee tbody').on('click', '#btn', function(e) {


                var newCourseProgrammedId = $(this).parents("tr").find('#courseProgrammed').val();
                var oldCourseProgramming = rescheduleEmployee.row($(this).parents('tr')).data().course_programming_id;
                var employeeId = rescheduleEmployee.row($(this).parents('tr')).data().employee_id;


                Swal.fire({
                    title: 'Estas seguro que desea re-programar el empleado en este curso ?',
                    text: '',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#38c172',
                    confirmButtonText: 'Si!',
                    cancelButtonText: 'No.'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "get",
                            url: "reprogramEmployee/" + employeeId + "/" + oldCourseProgramming + "/" + newCourseProgrammedId,
                            success: function(response) {

                                if (response) {
                                    location.reload();
                                }
                            }
                        });
                    }
                });
            });

        }

    });




});