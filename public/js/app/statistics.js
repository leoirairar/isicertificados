$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    /*section getCertificatesUsersByTwoDates*/

    $("#chartdatetimepicker3").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });

    $("#chartdatetimepicker4").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });

    $("#chartdatetimepicker3").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker4").datetimepicker("minDate", e.date);
        startDate = e.date;

    });

    $("#chartdatetimepicker4").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker3").datetimepicker("maxDate", e.date);
    });

    $("#certificatesUsersBetweenDates").click(function (e) { 
        
        var datetimepicker3 = document.getElementById("begin_date3").value;
        var datetimepicker4 = document.getElementById("end_date4").value;

        if (datetimepicker3 == "" || datetimepicker4 == "") {
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor seleccione las fechas que desea evaluar!',
            }) 
        }
        else{


            var companyId2 = ($("#company2 :selected").val()=="")?null:$("#company2 :selected").val();
            var courseId2 = ($("#course2 :selected").val() == "")? null:$("#course2 :selected").val(); 

            var formatdate3 = moment(datetimepicker3,'DD/MM/YYYY').format('YYYY-MM-DD');
            var formatdate4 = moment(datetimepicker4,'DD/MM/YYYY').format('YYYY-MM-DD');

            console.log(formatdate4);

            $.ajax({
                type: "GET",
                url: "getCertificateUsersBetweenDates/"+formatdate3+"/"+formatdate4+"/"+companyId2+"/"+courseId2,
                success: function (response) {
                    var ctx = document.getElementById('contentCertificatesByDates').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: response.datesCertificateUsersCollection,
                            datasets: [{
                                label: 'Cantidad de usuarios certificados',
                                data: response.certificatesUSersCollection,
                                backgroundColor: [
                                    '#fc6002',
                                ],
                                borderColor: [
                                    '#ffffff',
                                ],
                                borderWidth: 2
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        precision:0,
                                        // userCallback: function(label, index, labels) {
                                        //     // when the floored value is the same as the value we have a whole number
                                        //     if (Math.floor(label) === label) {
                                        //         return label;
                                        //     }
                       
                                        // },
                                    }
                                }]
                            }
                        }
                    });
                }
            });

        }
        
    });



    /*section getCertificatesUsersVsUncertificate*/
    
    $("#chartdatetimepicker5").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });

    $("#chartdatetimepicker6").datetimepicker({
        format: "DD/MM/YYYY",
        useCurrent: false,
    });

    $("#chartdatetimepicker5").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker6").datetimepicker("minDate", e.date);
        startDate = e.date;

    });

    $("#chartdatetimepicker6").on("change.datetimepicker", function (e) {
        $("#chartdatetimepicker5").datetimepicker("maxDate", e.date);
    });

    $("#btnCertificatesUncerEmployees").click(function (e) { 
        
        var datetimepicker5 = document.getElementById("begin_date5").value;
        var datetimepicker6 = document.getElementById("end_date6").value;

        if (datetimepicker5 == "" || datetimepicker6 == "") {
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor seleccione las fechas que desea evaluar!',
            }) 
        }
        else{


            var companyId3 = ($("#company3 :selected").val()=="")?null:$("#company3 :selected").val();
            var courseId3 = ($("#course3 :selected").val() == "")? null:$("#course3 :selected").val(); 

            var formatdate5 = moment(datetimepicker5,'DD/MM/YYYY').format('YYYY-MM-DD');
            var formatdate6 = moment(datetimepicker6,'DD/MM/YYYY').format('YYYY-MM-DD');

            console.log(formatdate6);

            $.ajax({
                type: "GET",
                url: "getCertificatesUsersVsUncertificate/"+formatdate5+"/"+formatdate6+"/"+companyId3+"/"+courseId3,
                success: function (response) {
                    var ctx = document.getElementById('certificatesUncerEmployees').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Empleados certificados: '+response.certificatesEmployess[0].certificates, 'Empleados no certificados: '+response.uncertificatesUsers[0].certificates],
                            datasets: [{
                                label: '',
                                data: [response.certificatesEmployess[0].certificates,response.uncertificatesUsers[0].certificates],
                                backgroundColor: [
                                    '#fc6002',
                                    '#ffffff',
                                ],
                                borderColor: [
                                    '#ffffff',
                                    '#fc6002',
                                ],
                                borderWidth: 2
                            }]
                        },
                        
                    });


                    $('#contentCertificatesByDates').html(response);
                    console.log(response)
                }
            });

        }
        
    });


 /*section getCertificatesUsersByTwoDates*/
    
 $("#chartdatetimepicker7").datetimepicker({
    format: "DD/MM/YYYY",
    useCurrent: false,
});

$("#chartdatetimepicker8").datetimepicker({
    format: "DD/MM/YYYY",
    useCurrent: false,
});

$("#chartdatetimepicker7").on("change.datetimepicker", function (e) {
    $("#chartdatetimepicker8").datetimepicker("minDate", e.date);
    startDate = e.date;

});

$("#chartdatetimepicker8").on("change.datetimepicker", function (e) {
    $("#chartdatetimepicker7").datetimepicker("maxDate", e.date);
});

$("#btnCertificatesEmployeesByCurse").click(function (e) { 
    
    var datetimepicker7 = document.getElementById("begin_date7").value;
    var datetimepicker8 = document.getElementById("end_date8").value;

    if (datetimepicker7 == "" || datetimepicker8 == "") {
        Swal.fire({
            type: 'error',
            title: '',
            text: 'Por favor seleccione las fechas que desea evaluar!',
        }) 
    }
    else{


        var companyId4 = ($("#company4 :selected").val()=="")?null:$("#company4 :selected").val();
        var courseId4 = ($("#course4 :selected").val() == "")? null:$("#course4 :selected").val(); 

        var formatdate7 = moment(datetimepicker7,'DD/MM/YYYY').format('YYYY-MM-DD');
        var formatdate8 = moment(datetimepicker8,'DD/MM/YYYY').format('YYYY-MM-DD');

        console.log(formatdate8);

        $.ajax({
            type: "GET",
            url: "getEnrolledEmployeesGroupByCurses/"+formatdate7+"/"+formatdate8+"/"+companyId4+"/"+courseId4,
            success: function (response) {
                var ctx = document.getElementById('certificatesEmployeesByCurse').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: response.coursesLabel,
                        datasets: [{
                            label: 'Cantidad de empleados por curso',
                            data: response.employeesByCourse,
                            backgroundColor: response.backGroundColor,
                            borderColor: response.borderColor,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    precision:0,
                                    // userCallback: function(label, index, labels) {
                                    //     // when the floored value is the same as the value we have a whole number
                                    //     if (Math.floor(label) === label) {
                                    //         return label;
                                    //     }
                   
                                    // },
                                }
                            }]
                        }
                    }
                    
                });


                $('#contentCertificatesByDates').html(response);
                console.log(response)
            }
        });

    }
    
});


});