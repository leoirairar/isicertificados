var idFile = [];
var employeeCoursesProgrammed = [];
var employeeFiles = [];
var url;
const myNode = document.getElementById("attachment");

$(document).ready(function() {

    $("#company").select2();
    $("#employee").select2();
    $("#course").select2();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // get all coruses 
    $('#company').change(function(e) {
        var employeeId = e.currentTarget.value;
        if (e.currentTarget.value != "") {
            $.ajax({
                type: "GET",
                url: "getEmployeesByCompanyId/" + e.currentTarget.value,
                success: function(response) {

                    var el = $("#employee");
                    el.empty();

                    el.append($("<option></option>")
                        .attr("value", "")
                        .text('Selecciona una opción'));

                    response.forEach(element => {
                        console.log(element.id);
                        if (element.user != null) {
                            el.append($("<option></option>")
                                .attr("value", element.id)
                                .text(element.user.name + " " + element.user.last_name));
                        }

                    });

                    $("#courseProgrammedId").val("");
                    removeAttachment();
                }
            });

        }
        e.preventDefault();
    });

    $('#employee').change(function(e) {

        if (e.currentTarget.value != "") {
            $.ajax({
                type: "GET",
                url: "getCourseAssignment/checkEmployeeCourses/" + e.currentTarget.value,
                success: function(response) {
                    employeeCoursesProgrammed.length = 0;
                    response.employee_enrollment.forEach(element => {
                        employeeCoursesProgrammed.push(element.course_programming_id);
                    });

                    response.files.forEach(element => {
                        employeeFiles.push({ course_file_id: element.file_id, employee_file_id: element.id });
                    });
                    $("#courseProgrammedId").val("");
                    removeAttachment();

                }
            });

        }
        e.preventDefault();
    });


    //


    // var list = $("#course").select2({
    //         closeOnSelect: false,
    //         dropdownPosition: "below",    
    //     })
    //     .on("select2:closing", function(e) {
    //         e.preventDefault();
    //     })
    //     .on("select2:closed", function(e) {
    //         list.select2("open");
    //     })
    //     .on("select2:open", function() {
    //         $(".select2-dropdown--above").attr("id", "fix");
    //         $("#fix").removeClass("select2-dropdown--above");
    //         $("#fix").addClass("select2-dropdown--below");
    //         //$("#course>option").attr('disabled','disabled');
    //         $(".select2-results__option").attr('aria-disabled','true');

    //     });

    // list.select2("open");

    // $("#course").on("select2:select", function(e) {
    //     const myNode = document.getElementById("attachment");
    //     if (myNode != null) {
    //         while (myNode.firstChild) {
    //             myNode.removeChild(myNode.firstChild);
    //         }
    //     }
    //     var courseId = e.params.data.element.attributes.courseid.value;
    //     if (document.getElementById('employee').value != "") {

    //         if (!employeeCoursesProgrammed.find(element => element == e.params.data.element.attributes.value.value)) {
    //             console.log('primerid' + courseId)
    //             $.ajax({
    //                 type: "get",
    //                 async: false,
    //                 url: "getCourseAssignment/selectedDocumentsType/" + courseId,
    //                 dataType: "json",
    //                 success: function(response) {
    //                     var i = 0;
    //                     response.forEach(function(item) {
    //                         let exist = false;
    //                         idFile.push(item.name + "-" + item.id);
    //                         $("#attachment").append("<div data-type='default' class='row'>\
    //                             <div data-type='default' class='col-md-8 mt-3'>\
    //                             <label>" + item.name + " <span style='color: red;' id='exist" + item.id + "'> </span> </label>\
    //                             <input class='form-control form-control-file target' type='file' id='" + item.name + "-" + item.id + "' value='' onchange='showname(" + item.id + ");' dataid='" + item.id +
    //                             "' name='docFiles[]' required='required' autofocus='autofocus'>\
    //                             <a class='btn btn-primary btn-sm mt-1' return false;' id='userFile" + item.id + "' style='margin-left: 5%'>Ver documento</a>\
    //                             <input id='fileid' name='fileid[]' type='hidden' value='" + item.id + "'>\
    //                             </input>\
    //                             </div>\
    //                             </div>"
    //                         );
    //                         // let inputId = item.name +"-" +item.id;

    //                         employeeFiles.forEach(element => {
    //                             if (!exist) {
    //                                 if (item.id == element.course_file_id) {
    //                                     url = route('file', { id: element.employee_file_id })
    //                                     document.getElementById('exist' + item.id).innerHTML = "  Este documento ya se encuentra almacenado";
    //                                     document.getElementById(item.name + "-" + item.id).removeAttribute('required');
    //                                     document.getElementById(item.name + "-" + item.id).setAttribute("disabled", "true");
    //                                     document.getElementById('userFile' + item.id).setAttribute("href", url);
    //                                     exist = true;
    //                                 }
    //                             }
    //                         });

    //                     });
    //                 }
    //             }).fail(function(jqXHR, textStatus, errorThrown) {
    //                 console.log(jqXHR);
    //                 console.log(textStatus);
    //                 console.log(errorThrown);
    //             });
    //         } else {
    //             $("#course").val("");
    //             $('#course').select2().trigger('change');
    //             Swal.fire({
    //                 type: 'error',
    //                 title: 'Usuario registrado',
    //                 text: 'Este usuario ya se encuentra matriculado en este curso!',
    //             })
    //         }
    //     } else {
    //         $("#course").val("");
    //         $('#course').select2().trigger('change');
    //         Swal.fire({
    //             type: 'error',
    //             title: '',
    //             text: 'Por favor seleccione un empleado!',
    //         })
    //     }

    // });

    $("#cancel").click(function() {
        $("#selected-course").text("");
        $("#courseProgrammedId").val("");
        removeAttachment();
        console.log('clic');

    });



    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: 300,
        locale: 'es',
        plugins: ['dayGrid'],
        displayEventTime: false,
        events: 'getCourseProgrammingJson',
        selectable: true,
        eventColor: '#378006',
        eventClick: function(event) {

            removeAttachment();
            if (document.getElementById('employee').value != "") {

                if (!employeeCoursesProgrammed.find(element => element == event.event.id)) {
                    //console.log('segundoId' + event.event.extendedProps.courseId);
                    $("#selected-course").text(event.event.extendedProps.description);
                    $("#courseProgrammedId").val(event.event.id);
                    $("#courseId").val(event.event.extendedProps.courseId);

                    $.ajax({
                        type: "get",
                        async: false,
                        url: "getCourseAssignment/selectedDocumentsType/" + event.event.extendedProps.courseId,
                        dataType: "json",
                        success: function(response) {
                            var i = 0;
                            response.forEach(function(item) {
                                let exist = false;
                                idFile.push(item.name + "-" + item.id);
                                $("#attachment").append("<div data-type='default' class='row'>\
                                <div data-type='default' class='col-md-8 mt-3'>\
                                <label>" + item.name + " <span style='color: red;' id='exist" + item.id + "'> </span> </label>\
                                <input class='form-control form-control-file target' type='file' id='" + item.name + "-" + item.id + "' value='' onchange='showname(" + item.id + ");' dataid='" + item.id +
                                    "' name='docFiles[]' required='required' autofocus='autofocus'>\
                                <a class='btn btn-primary btn-sm mt-1' return false;' id='userFile" + item.id + "' style='margin-left: 5%'>Ver documento</a>\
                                <input id='fileid' name='fileid[]' type='hidden' value='" + item.id + "'>\
                                </input>\
                                </div>\
                                </div>"
                                );
                                // let inputId = item.name +"-" +item.id;

                                employeeFiles.forEach(element => {
                                    if (!exist) {
                                        if (item.id == element.course_file_id) {
                                            url = route('file', { id: element.employee_file_id })
                                            document.getElementById('exist' + item.id).innerHTML = "  Este documento ya se encuentra almacenado";
                                            document.getElementById(item.name + "-" + item.id).removeAttribute('required');
                                            document.getElementById(item.name + "-" + item.id).setAttribute("disabled", "true");
                                            document.getElementById('userFile' + item.id).setAttribute("href", url);
                                            exist = true;
                                        }
                                    }
                                });

                            });
                        }
                    }).fail(function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        console.log(textStatus);
                        console.log(errorThrown);
                    });
                } else {
                    $("#course").val("");
                    $('#course').select2().trigger('change');
                    Swal.fire({
                        type: 'error',
                        title: 'Usuario registrado',
                        text: 'Este usuario ya se encuentra matriculado en este curso!',
                    })
                }
            } else {
                $("#course").val("");
                $('#course').select2().trigger('change');
                Swal.fire({
                    type: 'error',
                    title: '',
                    text: 'Por favor seleccione un empleado!',
                })
            }

        },
        eventRender: function(info) {


            // var $el = $(info.el);
            // var shown = false;
            // $(document).on('click', function(event) {
            //   if (!shown) {
            //     return;
            //   }
            //   if (!$(event.target).closest($el).length &&
            //     !$(event.target).closest(".popover").length) {
            //     shown = false;
            //     $el.popover("hide");
            //   }
            // });
            // $el.attr('tabindex', -1);
            // $el.popover({
            //   placement: 'bottom',
            //   title: 'Appointment Actions',
            //   content: "test",
            //   trigger: 'manual'
            // }).on("click", function() {
            //     shown = true;
            //   $(this).popover("show");
            // });
        }
    });




    calendar.render();
});

//function to create list dependig of upload document
function showname(documentid) {
    var li = document.getElementById(documentid.toString());
    if (li != undefined) {
        li.parentNode.removeChild(li);
    }

    idFile.forEach(function(item) {
        var fileinput = document.getElementById(item);
        console.log(fileinput.attributes.dataid);
        if (documentid.toString() == fileinput.attributes.dataid.value) {
            var node = document.createElement("LI");
            var n = fileinput.attributes.id.value.search("-");
            var res = fileinput.attributes.id.value.substring(0, n);
            var textnode = document.createTextNode(res + " - " + fileinput.files[0].name);
            node.className = "list-group-item";
            node.id = documentid.toString();
            node.appendChild(textnode);
            document.getElementById("attachedDocuments").appendChild(node);
            console.log(fileinput.files);
        }
    });
}

function removeAttachment(params) {
    if (myNode != null) {
        while (myNode.firstChild) {
            myNode.removeChild(myNode.firstChild);
        }
    }

}

function validateMyForm() {

    try {

        //e.preventDefault();
        let course = document.getElementById('courseProgrammedId').value;
        if (course == "") {
            Swal.fire({
                title: 'No se ha seleccionado ningun curso.',
                icon: 'warning',
            })


            return false;
        }
        // let courseId = document.getElementById('courseId').value;
        // //documentos que se deben de cargar por cada curso. 
        // let documentsTypeByCourse = documentsTypeByCoursesJson.filter(el => el.course_id == courseId)
        // let employeeFiles = document.getElementById('employeeFiles');
        // if (employeeFiles != null) {
        //     employeeFiles = JSON.parse(employeeFiles.value);
        // }
        // let validation = true;

        // console.log(courseId);
        // if (course == "") {
        //     Swal.fire({
        //         title: 'No se ha seleccionado ningun curso.',
        //         text: 'Desea continuar sin inscribirlo a un curso.',
        //         type: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#38c172',
        //         confirmButtonText: 'Si!',
        //         cancelButtonText: 'No.'
        //     }).then((result) => {
        //         if (result.value) {
        //             document.getElementById('employeeForm').submit();
        //         } else if (result.dismiss === swal.DismissReason.cancel) {
        //             return false;
        //         }
        //     });


        //     return false;
        // }
        // var udpatedFiles = []

        // //los documentos que son obligarios para el curso.
        // for (let i = 0; i < documentsTypeByCourse.length; i++) {

        //     let check = false;
        //     //los documentos que estan disponibles para subir
        //     for (let j = 0; j < documentsTypeUploaded.length; j++) {

        //         if (documentsTypeByCourse[i].document_type_id == documentsTypeUploaded[j].dataset.id) {

        //             if (documentsTypeUploaded[j].value == "") {

        //                 if (employeeFiles != null) {

        //                     //documentos que tiene cargado el empleado en bd
        //                     for (let k = 0; k < employeeFiles.length; k++) {

        //                         if (employeeFiles[k].file_id == documentsTypeByCourse[i].document_type_id) {
        //                             check = true;
        //                             validation = false;
        //                             udpatedFiles.push(j);
        //                             break;
        //                         }
        //                     }

        //                     if (!check) {
        //                         Swal.fire({
        //                             type: 'error',
        //                             title: '',
        //                             text: 'Es necesario subir el documento ' + documentsTypeUploaded[j].dataset.name,
        //                         });


        //                     }

        //                 } else {
        //                     Swal.fire({
        //                         type: 'error',
        //                         title: '',
        //                         text: 'Es necesario subir el documento ' + documentsTypeUploaded[j].dataset.name,
        //                     });

        //                 }

        //             } else {


        //                 udpatedFiles.push(j);
        //             }

        //         }
        //     }

        // }
        // console.log(udpatedFiles);

        // if (udpatedFiles.length == documentsTypeByCourse.length) {
        //     document.getElementById('employeeForm').submit();
        // }

        // return false;
    } catch (error) {
        console.log(error);
        return false;
    }



    //alert("validations passed");
    //return true;
}