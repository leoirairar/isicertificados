var events = [];
let employeeId;
let whatchDocument = false;

//todos los documentos en la tabla documentType
let documentsTypeUploaded = document.querySelectorAll('input[type=file]');




$(document).ready(function() {

    $("#company").select2();

    setTimeout(function() {
        whatchDocument = false;
    }, 5000);

    //    var alert = document.querySelector('#cardbody');

    //    console.log(alert.dataset.course_validation);

    //    if (course_validation != "") {

    //         if (course_validation == "not_course") {
    //             Swal.fire({
    //                 type: 'error',
    //                 title: '',
    //                 text: 'No se ha seleccionado ',
    //             });
    //         } else if(course_validation == "not_file"){

    //         }
    //    }

    // let SITEURL = "{{url('/')}}";

    employeeId = document.getElementById('employeeId');

    if (employeeId != null) {
        employeeId = employeeId.value;
    }



    $('#identification_number').keyup(function(e) {
        e.preventDefault();
        //console.log(e.currentTarget.value);

        $.ajax({
            type: "GET",
            url: "checkEmployeeIdentification/" + e.currentTarget.value,
            success: function(response) {
                if (response) {

                    var url = route('getCourseAssignment');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: '<b>Este usuario ya está registrado en la plataforma, si desea inscribirlo a un curso haz click en el siguiente botón.</b> ',
                        confirmButtonText: '<a href="' + url + '" style="color: white;">Inscribir a curso</a>',
                    })
                    document.getElementById("button").disabled = true;
                } else {

                }
            }
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if ($("#employeesTable").length) {
    $.ajax({
        type: "GET",
        url: "getEmployeesTableData",
        data: { length: 500 }, // Enviar el parámetro length con el valor deseado
        success: function(response) {
            $("#employeesTable").empty();
            employeesTable = $('#employeesTable').DataTable({
                autoWidth: false,
                data: response.data,
                columnDefs: [
                    { title: "Nombre", render: (data, type, row) => row.user.name + ' ' + row.user.last_name, targets: 0 },
                    { title: "Cedula", data: 'user.identification_number', targets: 1 },
                    { title: "Empresa", data: 'company.company_name', targets: 2, defaultContent: "" },
                    { title: "Estudios", data: 'academic_degree.name', targets: 3 },
                    {
                        title: "Estado",
                        render: function(data, type, row) {
                            return (row.deleted_at == null) ? 'Activo' : 'Inactivo';
                        },
                        targets: 4
                    },
                    {
                        title: "Editar",
                        render: function(data, type, row) {
                            return `<a href="editEmployee/${row.id}" class="btn btn-success">Editar</a>`
                        },
                        targets: 5
                    },
                    {
                        title: "Eliminar",
                        render: function(data, type, row) {
                            //poner confirmacion.
                            if (row.deleted_at == null) {
                                return `<a href="deleteEmployee/${row.id}" class="btn btn-danger">Inactivar <span class="fa fa-trash-o"></a>`
                            } else {
                                return `<a href="deleteEmployee/${row.id}" class="btn btn-danger">Activar <span class="fa fa-undo"></a>`
                            }
                        },
                        targets: 6
                    },
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })
            employeesTable.columns.adjust();

        }
    });
    }
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

 






    $("#cancel").click(function() {
        $("#selected-course").text("");
        $("#courseProgrammedId").val("");

    });





});

function downloadFiles(fileId) {

    whatchDocument = true;
    fileDiv = document.getElementById('file-' + fileId);
    url = route('file', { id: fileId })
    const link = document.createElement('a');
    link.href = url;
    fileDiv.appendChild(link);
    link.click();
    event.preventDefault();
}


function showname(file) {

    var li = document.getElementById(file.dataset.id);
    if (li != undefined) {
        li.parentNode.removeChild(li);
    }
    var node = document.createElement("LI");
    var documentType = file.getAttribute("data-name");
    var textnode = document.createTextNode(file.files[0].name + '-' + documentType);
    node.className = "list-group-item";
    node.id = file.dataset.id;
    node.appendChild(textnode);
    document.getElementById("attachedDocuments").appendChild(node);

}

function validateMyForm() {

    try {
        if (!whatchDocument) {


            //e.preventDefault();
            let course = document.getElementById('courseProgrammedId').value;
            let courseId = document.getElementById('courseId').value;
            //documentos que se deben de cargar por cada curso.
            let documentsTypeByCourse = documentsTypeByCoursesJson.filter(el => el.course_id == courseId)
            let employeeFiles = document.getElementById('employeeFiles');
            if (employeeFiles != null) {
                employeeFiles = JSON.parse(employeeFiles.value);
            }
            let validation = true;

            console.log(courseId);
            if (course == "") {
                Swal.fire({
                    title: 'No se ha seleccionado ningun curso.',
                    text: 'Desea continuar sin inscribirlo a un curso.',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#38c172',
                    confirmButtonText: 'Si!',
                    cancelButtonText: 'No.'
                }).then((result) => {
                    if (result.value) {
                        document.getElementById('employeeForm').submit();
                    } else if (result.dismiss === swal.DismissReason.cancel) {
                        return false;
                    }
                });


                return false;
            }
            var udpatedFiles = []

            //los documentos que son obligarios para el curso.
            for (let i = 0; i < documentsTypeByCourse.length; i++) {

                let check = false;
                //los documentos que estan disponibles para subir
                for (let j = 0; j < documentsTypeUploaded.length; j++) {

                    if (documentsTypeByCourse[i].document_type_id == documentsTypeUploaded[j].dataset.id) {

                        if (documentsTypeUploaded[j].value == "") {

                            if (employeeFiles != null) {

                                //documentos que tiene cargado el empleado en bd
                                for (let k = 0; k < employeeFiles.length; k++) {

                                    if (employeeFiles[k].file_id == documentsTypeByCourse[i].document_type_id) {
                                        check = true;
                                        validation = false;
                                        udpatedFiles.push(j);
                                        break;
                                    }
                                }

                                if (!check) {
                                    Swal.fire({
                                        type: 'error',
                                        title: '',
                                        text: 'Es necesario subir el documento ' + documentsTypeUploaded[j].dataset.name,
                                    });


                                }

                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: '',
                                    text: 'Es necesario subir el documento ' + documentsTypeUploaded[j].dataset.name,
                                });

                            }

                        } else {


                            udpatedFiles.push(j);
                        }

                    }
                }

            }
            console.log(udpatedFiles);

            if (udpatedFiles.length == documentsTypeByCourse.length) {
                document.getElementById('employeeForm').submit();
            }

            return false;
        }
    } catch (error) {
        console.log(error);
        return false;
    }



    //alert("validations passed");
    //return true;
}
