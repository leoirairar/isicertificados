$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#modalUser').on( "click", function(e) {
        console.log(e.currentTarget.dataset.course);
        $('#modalContent').empty();
        $.ajax({
            type: "get",
            url: "getCourseProgrammingById/"+e.currentTarget.dataset.course,
            success: function (response) {
                document.getElementById('lableModal').innerHTML = response[0].course_programming.course.name+'-'+response[0].course_programming.begin_date;
                //console.log(response);
                response.forEach(element => {
                    $('#modalContent').append(`
                    <p>
                    <span>${element.employee.user.name+' '+element.employee.user.last_name}</span>
                    </p>
                `); 
                });
                
            }
        });

        $('#attendanceModal').modal('show');
     });

    
});