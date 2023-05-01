$(document).ready(function() {

    $("#programmedCourses").select2();
    $("#companies").select2();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $('#btnCertificatesCompany').click(function(e) {
        var programmedCourseId = $("#programmedCourses").find(':selected').val()
        var companyId = $("#companies").find(':selected').val()

        if (programmedCourseId != "" && companyId != "") {

            $.ajax({
                type: "get",
                url: "sendCertificates/" + companyId + '/' + programmedCourseId,
                success: function(response) {
                    // var url = route('zip', {name: response})
                    // const link = document.createElement('a');
                    // link.href = url;
                    // document.body.appendChild(link);
                    // link.click();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });


            document.getElementById("companies").blur();

        } else if (companyId != "") {

            $.ajax({
                type: "get",
                url: "sendCertificates/" + companyId + '/0',
                success: function(response) {
                    // var url = route('zip', {name: response})
                    // const link = document.createElement('a');
                    // link.href = url;
                    // document.body.appendChild(link);
                    // link.click();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });

            document.getElementById("companies").blur();

        } else {
            document.getElementById("companies").focus();
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor seleccione la empresa!',
            })
        }

        e.preventDefault();

    });

    $('#btnFilter').click(function(e) {

        var programmedCourseId = $("#programmedCourses").find(':selected').val()
        var companyId = $("#companies").find(':selected').val()
        if (programmedCourseId != "" && companyId != "") {

            $.ajax({
                type: "get",
                url: "getEmployeeCertificateByComapnyCourse/" + companyId + '/' + programmedCourseId,
                success: function(response) {
                    $("#content").html(response);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });

        } else if (programmedCourseId != "") {

            $.ajax({
                type: "get",
                url: "getEmployeeCertificateByProgrammedCourse/" + programmedCourseId,
                success: function(response) {
                    $("#content").html(response);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });

        } else if (companyId != "") {
            $.ajax({
                type: "get",
                url: "getEmployeeCertificateByComapny/" + companyId,
                success: function(response) {
                    $("#content").html(response);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }
        e.preventDefault();

    });

});