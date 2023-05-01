$(document).ready(function() {
    var enrollTable;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var company_id = document.getElementById('company_id').value;
    console.log(company_id);
    $.ajax({
        type: "get",
        url: "getPreEnrolledEmployeesByCompany/" + company_id + "/" + null,
        dataType: "json",
        success: function(response) {
            $("#employeesPreEnrolled").empty();
            preEnrollTable = $('#employeesPreEnrolled').DataTable({
                autoWidth: false,
                data: response,
                columnDefs: [
                    { title: "Nombre", data: 'employee_name', name: 'employee_name', targets: 0 },
                    { title: "Empresa", data: 'company_name', name: 'company_name', targets: 1 },
                    { title: "Nombre curso", data: 'course_name', name: 'course_name', targets: 2 },
                    { title: "Fecha de inicio", data: 'begin_date', name: 'begin_date', targets: 3 },
                    {
                        title: "Eliminar",
                        data: "data",
                        render: function(data, type, row) {
                            return '<a href="getEditablesFilesByEmployee/' + row.employee_id + '/' + row.course_id + '/' + row.company_id + '/' + row.coursePrograming_id + '" class="btn btn-primary">Actualizar documentos</a>';

                        },
                        targets: 4
                    }
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })
            preEnrollTable.columns.adjust();

        },
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // console.log(jqXHR);
        // console.log(textStatus);
        // console.log(errorThrown);
    });

    $('#employeesPreEnrolled').on('click', '#btn-view', function(e) {
        var data = preEnrollTable.row($(this).parents('tr')).data();
        $.ajax({
            type: "get",
            url: "showEditableFilesByEmployee/" + data.employee_id + "/" + data.course_id + "/" + data.company_id + "/" + data.coursePrograming_id,
            success: function(response) {
                // window.location.replace(response);
                window.location = response.html;
            }
        });
    });

    $.ajax({
        type: "get",
        url: "getEnrolledEmployeesByCompany/" + company_id + "/" + null,
        dataType: "json",
        success: function(response) {
            $("#employeesEnrolled").empty();
            enrollTable = $('#employeesEnrolled').DataTable({
                autoWidth: false,
                data: response,
                columns: [
                    { title: "Nombre", data: 'employee_name', name: 'employee_name' },
                    { title: "Empresa", data: 'company_name', name: 'company_name' },
                    { title: "Nombre curso", data: 'course_name', name: 'course_name' },
                    { title: "Código Curso", data: 'course_code', name: 'course_code' },
                    { title: "Fecha de iniciio", data: 'begin_date', name: 'begin_date' },
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })
            enrollTable.columns.adjust();

        },
    }).fail(function(jqXHR, textStatus, errorThrown) {
        // console.log(jqXHR);
        // console.log(textStatus);
        // console.log(errorThrown);
    });






});