$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $("#courseDay").change(function (e) { 
        $.ajax({
            type: "get",
            url: "getAttendancesEmployeesByDay/"+e.currentTarget.value,
            success: function (response) {
                if (response.employee_enrollment.length != 0) {
                    $('#buttonAttendance').prop('disabled', true);
                    //document.getElementById("buttonAttendance").disabled = true;
                    $("tbody").find("tr").each(function () { 
                        var checked = false;
                        var inputs = document.getElementsByClassName("form-check-input");
                        for(var i=0;i<inputs.length;i++){
                            inputs[i].disabled = true;
                        }
                        var input = $(this).find('td.enroll #euid');  
                        var inputId = input[0].value;
                        response.employee_enrollment.forEach(element =>{                            
                            if (inputId == element.id) {                             
                                var statusDiv = document.getElementById("status-"+inputId);
                                statusDiv.classList.contains("badge-primary")?statusDiv.classList.remove("badge-primary"):null;
                                statusDiv.classList.contains("badge-danger")?statusDiv.classList.remove("badge-danger"):null;
                                statusDiv.classList.add("badge-success");
                                statusDiv.innerHTML = "Asistió";
                                checked = true;
                            }
                            else{
                                if (!checked) {
                                var statusDiv = document.getElementById("status-"+inputId);
                                statusDiv.classList.contains("badge-primary")?statusDiv.classList.remove("badge-primary"):null;
                                statusDiv.classList.contains("badge-success")?statusDiv.classList.remove("badge-success"):null;
                                statusDiv.classList.add("badge-danger");
                                statusDiv.innerHTML = "No Asistió";
                                }
                            }
                        })
                     });
                }else{
                    $("tbody").find("tr").each(function () { 
                        $('#buttonAttendance').prop('disabled', false);
                        //document.getElementById("buttonAttendance").disabled = false;
                        var inputs = document.getElementsByClassName("form-check-input");
                        for(var i=0;i<inputs.length;i++){
                            inputs[i].disabled = false;
                        }
                        var input = $(this).find('td.enroll #euid');  
                        var inputId = input[0].value;
                                                     
                        var statusDiv = document.getElementById("status-"+inputId);
                        statusDiv.classList.contains("badge-success")?statusDiv.classList.remove("badge-success"):null;
                        statusDiv.classList.contains("badge-danger")?statusDiv.classList.remove("badge-danger"):null;
                        statusDiv.classList.add("badge-primary")
                        statusDiv.innerHTML = "No chequeado"

                     });
                }
            }
        });
        
    });

    
});

function changeCheck(e) {
    var check = e.checked;
    var data = e.parentNode.parentNode.childNodes;
    data.forEach(element => {
        if(element.childNodes.length != 0){
            if (check) {
                var hasAttribute = element.childNodes[0].disabled = false;
            }
        }
    });
   
    
}