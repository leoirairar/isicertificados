$(document).ready(function () {


    $("#chartdatetimepicker1").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });

    $("#chartdatetimepicker2").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });
    
    $("#chartdatetimepicker1").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker2").datetimepicker("minDate", e.date);
        startDate = e.date;

    });

    $("#chartdatetimepicker2").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker1").datetimepicker("maxDate", e.date);
    });

    $.ajax({
        type: "get",
        url: "getAllFinishedEmployeesCertificates",
        success: function (response) {
            preEnrollTable =  $('#enrollmentInformation').DataTable({
                data:response,
                destroy: true,
                columns:[
                  {title: "Codigo ISI",data:'isi_code_certification',name:'isi_code_certification'},
                  {title: "Nombre",data:'full_name',name:'full_name'},
                  {title: "Identificación",data:'identification_number', name:'identification_number'},
                  {title: "Nombre curso",data:'course_name',name:'course_name'},
                  {title: "Fecha de inicio",data:'begin_date',name:'begin_date'},
                  {title: "Entrenador",data:'instructor_name',name:'instructor_name'},
                  {title: "Empresa",data:'company_name',name:'company_name'},
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
                
            })
        }
    });



    $("#certificatesUsersBetweenDates").click(function (e) { 
        
        var datetimepicker1 = document.getElementById("begin_date1").value;
        var datetimepicker2 = document.getElementById("end_date2").value;

        if (datetimepicker1 == "" || datetimepicker2 == "") {
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor seleccione las fechas que desea evaluar!',
            }) 
        }
        else{


            var formatdate1 = moment(datetimepicker1,'DD/MM/YYYY').format('YYYY-MM-DD');
            var formatdate2 = moment(datetimepicker2,'DD/MM/YYYY').format('YYYY-MM-DD');

            $.ajax({
                type: "GET",
                url: "getAllFinishedEmployeesCertificatesByDate/"+formatdate1+"/"+formatdate2,
                success: function (response) {
                    preEnrollTable =  $('#enrollmentInformation').DataTable({
                        data:response,
                        destroy: true,
                        columns:[
                          {title: "Codigo ISI",data:'isi_code_certification',name:'isi_code_certification'},
                          {title: "Nombre",data:'full_name',name:'full_name'},
                          {title: "Identificación",data:'identification_number', name:'identification_number'},
                          {title: "Nombre curso",data:'course_name',name:'course_name'},
                          {title: "Fecha de inicio",data:'begin_date',name:'begin_date'},
                          {title: "Entrenador",data:'instructor_name',name:'instructor_name'},
                          {title: "Empresa",data:'company_name',name:'company_name'},
                        ],
                        language: {
                            url: '../js/locales/Spanish.json'
                        }
                        
                    })
                }
            });

        }

        e.preventDefault();
        
    });



    $("#btncreateEnrollmentDocument").click(function (e) { 

        $.ajax({
            type: "get",
            url: "createEnrollmentDocument",
            success: function (response) {
                console.log(response)
            }
        });

        e.preventDefault();
        
    });



});