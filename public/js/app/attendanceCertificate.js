$(document).ready(function () {
    

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
    
    $('#btnIdentification').click(function () { 
        let identification = document.getElementById('identification').value;

        if (identification == null) {

            Swal.fire({
                type: 'error',
                title: '',
                text: 'Por favor ingrese una cedula',
            })
            
        }
        else{
            let url  = `getEmployeeAttendaceCertificate/${identification}`;
            console.log(url);
            
            $.ajax({
                type: "get",
                url: url,
                success: function (response) {
                    $("#container").html(response);
                }
            });
        }
        
    });

    


});