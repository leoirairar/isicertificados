let enrollTable;

$(document).ready(function() {


    $("#company").select2();

    var userFileId
    var showedFiles = [];
    var employeeFilesStatus = [];

    function callRoute(problemID) {
        window.location = '/download/' + problemID;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    fill_datatable();

    function fill_datatable(company_id = '') {
        let url = "";

        if (company_id != "") {
            url = "getPreEnrolledEmployeesByCompany/" + company_id + "/" + null
        } else {
            url = "getPreEnrolledEmployeesByCompany/" + null + "/" + null
        }

        //console.log(company_id);

        $.ajax({
            type: "get",
            url: url,
            dataType: "json",
            success: function(response) {
                $("#employeesEnrolled").empty();
                enrollTable = $('#employeesEnrolled').DataTable({
                    data: response,
                    "order": [
                        [0, "desc"]
                    ],
                    columnDefs: [
                        { title: "id", data: 'enrollment_id', targets: 0 },
                        { title: "Nombre empleado", data: 'employee_name', targets: 1 },
                        { title: "Empresa", data: 'company_name', targets: 2 },
                        { title: "Curso", data: 'course_name', targets: 3 },
                        { title: "Fecha del curso", data: 'begin_date', targets: 4 },
                        {
                            title: "Modificar documentos",

                            render: function(data, type, row) {
                                return '<a href="getCourseFilesByEmployeeNotification/' + row.enrollment_id + '/' + row.course_id + '/' + row.coursePrograming_id + '" class="btn btn-primary">Actualizar documentos</a>';
                            },
                            targets: 5
                        },
                        {
                            title: "Anular inscripción",

                            render: function(data, type, row) {
                                return '<button type="button" class="btn btn-danger" id="btn-delete" >Anular inscripción</button >';
                            },
                            targets: 6
                        }
                    ],
                    language: {
                        url: '../js/locales/Spanish.json'
                    }
                })

            },
        }).fail(function(jqXHR, textStatus, errorThrown) {
            // console.log(jqXHR);
            // console.log(textStatus);
            // console.log(errorThrown);
        });



    }

    // Handle click on "Delete" button
    $('#employeesEnrolled').on('click', '#btn-delete', function(e) {

        var data = enrollTable.row($(this).parents('tr')).data();

        Swal.fire({
            title: 'Estas seguro que desea anular la inscripción del empleado?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#38c172',
            confirmButtonText: 'Si!',
            cancelButtonText: 'No.'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "delete",
                    url: "unsuscribe/" + data.enrollment_id,
                    success: function(response) {
                        enrollTable.destroy();
                        fill_datatable();
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);
                });
                event.preventDefault();
            } else if (result.dismiss === swal.DismissReason.cancel) {
                console.log("no")
            }
        });

    });

    $('#filter').click(function() {
        var company_id = $('#company').val();
        $('#employeesEnrolled').DataTable().destroy();
        fill_datatable(company_id);
    });

    // modal construction.
    $('#employeesEnrolled').on('click', '#btn-view', function(e) {
        $('#docsName').empty();
        $('#docsIcons').empty();
        $("#checkContenedor").empty()
        var data = enrollTable.row($(this).parents('tr')).data();
        //console.log(data);

        $.ajax({
            type: "get",
            url: "getCourseFilesByEmployee/" + data.employee_id + "/" + data.course_id,
            success: function(response) {
                $("#flexColumnContainer").empty();
                if (response.user_files.length != 0) {
                    $("#fileAlert").alert('close');
                    $("#flexColumnContainer").append('<input id="prodId" name="enrollment_id" type="hidden" value="' + data.enrollment_id + '">');
                    $("#flexColumnContainer").append('<input id="prodId" name="coursePrograming_id" type="hidden" value="' + data.coursePrograming_id + '">');
                    $("#flexColumnContainer").append('<input id="prodId" name="employee_id" type="hidden" value="' + data.employee_id + '">');
                    $("#flexColumnContainer").append('<input id="prodId" name="company_id" type="hidden" value="' + data.company_id + '">');
                    $("#flexColumnContainer").append('<input id="prodId" name="course_id" type="hidden" value="' + data.course_id + '">');
                    var courseDocuments = response.courseDocuments.documents_type
                        //console.log(response)
                    courseDocuments.forEach(function(courseDocumentItem) {
                        $("#flexColumnContainer").append('<div class="d-flex flex-row flex-wrap" id="rowSectionContainer' + courseDocumentItem.id + '"></div>');

                        $("#rowSectionContainer" + courseDocumentItem.id).append(" <div class='p-2 flex-fill bd-highlight'> <span>" + courseDocumentItem.name + "</span></i></div>");



                        var emptyFile = true;
                        var create = false;
                        response.user_files.forEach(function(item) {

                            if (courseDocumentItem.id == item.file_id) {
                                var indesxOf = showedFiles.indexOf(item.file_id);
                                if (indesxOf == -1) {
                                    showedFiles.push(item.file_id);
                                    employeeFilesStatus.push({ id: item.file_id, status: item.status })
                                    emptyFile = false;
                                    //route() is a function of a library used to link laravelroutes to javascript
                                    var url = route('file', { id: item.id }, false)
                                    $("#rowSectionContainer" + courseDocumentItem.id).append("<div class='p-2 flex-fill bd-highlight'><a id='fileDownload' href='" + url + "' ><i class='far fa-file-alt fa-lg'> " + "</i></a></div>");
                                    userFileId = item.id
                                }

                            }

                        });
                        if (emptyFile) {
                            $("#rowSectionContainer" + courseDocumentItem.id).append("<div class='p-2 flex-fill bd-highlight'><i class='far fa-file-alt fa-lg'> </i></div>");
                        }


                        $('#rowSectionContainer' + courseDocumentItem.id).append('\
                        <div class="p-2 flex-fill bd-highlight"> \
                            <ul id="docsIcons" class=" list-group-flush list-inline"> \
                            <i class="list-inline-item" ><div class="custom-control custom-radio custom-control-inline">\
                                    <input name="radio' + courseDocumentItem.id + '[file' + userFileId + '][status]" id="radio' + courseDocumentItem.id + '_0" type="radio" class="custom-control-input" required value="A"> \
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][file_id]" type="hidden" value="' + userFileId + '">\
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][courseDocument_id]" type="hidden" value="' + courseDocumentItem.id + '">\
                                    <label for="radio' + courseDocumentItem.id + '_0" class="custom-control-label">Aprobado' + '</label>\
                                </div></i>\
                                <i class="list-inline-item" ><div class="custom-control custom-radio custom-control-inline">\
                                    <input name="radio' + courseDocumentItem.id + '[file' + userFileId + '][status]" id="radio' + courseDocumentItem.id + '_1" type="radio" class="custom-control-input" required value="E"> \
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][file_id]" type="hidden" value="' + userFileId + '">\
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][courseDocument_id]" type="hidden" value="' + courseDocumentItem.id + '">\
                                    <label for="radio' + courseDocumentItem.id + '_1" class="custom-control-label">Falta Documento' + '</label>\
                                </div></i>\
                                <i class="list-inline-item" ><div class="custom-control custom-radio custom-control-inline">\
                                    <input name="radio' + courseDocumentItem.id + '[file' + userFileId + '][status]" id="radio' + courseDocumentItem.id + '_2" type="radio" class="custom-control-input" required value="W"> \
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][file_id]" type="hidden" value="' + userFileId + '">\
                                    <input id="prodId" name="radio' + courseDocumentItem.id + '[file' + userFileId + '][courseDocument_id]" type="hidden" value="' + courseDocumentItem.id + '">\
                                    <label for="radio' + courseDocumentItem.id + '_2" class="custom-control-label">Documento con errores' + '</label>\
                                </div></i>\
                            </ul>\
                        </div>\
                        ');


                        employeeFilesStatus.forEach(element => {
                            if (element.id == courseDocumentItem.id) {

                                if (document.getElementById('radio' + courseDocumentItem.id + '_0').value == element.status) {
                                    document.getElementById('radio' + courseDocumentItem.id + '_0').checked = true;
                                }

                                if (document.getElementById('radio' + courseDocumentItem.id + '_1').value == element.status) {
                                    document.getElementById('radio' + courseDocumentItem.id + '_1').checked = true;
                                }

                                if (document.getElementById('radio' + courseDocumentItem.id + '_2').value == element.status) {
                                    document.getElementById('radio' + courseDocumentItem.id + '_2').checked = true;
                                }

                            }
                        });

                    })



                } else {
                    $("#filesContenedor").empty();
                    $("#btnSave").remove();
                    $("#fileAlert").show();
                }

                $('#docsModal').modal('show')
                $("#lableModal").text(data.employee_name + " - " + data.course_name);
                showedFiles = [];
            }

        });
    });

    $("#docButt").click(function() {
        window.location.href = "{{URL::to('restaurants/20')}}"
    });




});

function unsuscribe(enrollment_id) {

    let enrollmentId = enrollment_id;

    jQuery(function($) {

    });
}