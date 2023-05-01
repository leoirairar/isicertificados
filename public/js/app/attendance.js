$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#programmedCourses").change(function (e) { 
        
        $.ajax({
            type: "GET",
            url: "getAttendanceListByCourse/"+e.currentTarget.value,
            success: function (response) {
                $("#cotentAttendanceList").html(response);
            }
        });
        
    });

    $('#btnAttendanceCourse').click(function (e) { 
        var programmedCourseId =  $("#programmedCourses").find(':selected').val()
        if (programmedCourseId != "") {
            
            $.ajax({
                type: "get",
                url: "exportCourseProgamingAttendance/"+programmedCourseId,
                success: function (response) {

                    if(response === 'unchecked'){
                        Swal.fire({
                            type: 'error',
                            title: 'No se puede generar la lista',
                            text: 'Aun hay usuarios a los que no se les ha tomado asistencia!',
                        }) 
                    }
                    else{
                        var url = route('attendanceExcel', {name: response})
                        const link = document.createElement('a');
                        link.href = url;
                        document.body.appendChild(link);
                        link.click();
                        e.preventDefault();
                    }
                    
                }
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                console.log(jqXHR);
                console.log(textStatus);
                console.log(errorThrown);
            });
        }else{
            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor seleccione la empresa!',
            }) 
        }
        
        
    });
});