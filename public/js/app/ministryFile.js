$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#programmedCourses").change(function (e) { 
        
        $.ajax({
            type: "GET",
            url: "getMinistryEmployeesByFinishedCoruse/"+e.currentTarget.value,
            success: function (response) {
                $("#cotent").html(response);
            }
        });
        
    });

   

});
