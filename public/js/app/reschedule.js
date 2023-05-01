$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});

function reprogram(oldCourseProgramming,employeeId)
{
    
    var newCourseProgrammedId  = $('select[name=avaibleCourses'+oldCourseProgramming+']').val()

    if(newCourseProgrammedId == ""){
        Swal.fire({
            type: 'error',
            title: '',
            text: 'Por favor seleccione el curso al cual desea reprogramar a el empleado!',
        }) 
    }
    else{
        Swal.fire({
            title: 'Estas seguro que desea re-programar el empleado en este curso ?',
            text: '',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#38c172',
            confirmButtonText: 'Si!',
            cancelButtonText: 'No.'
          }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "reprogramEmployee/"+employeeId+"/"+oldCourseProgramming+"/"+newCourseProgrammedId,
                    success: function (response) {
        
                        if(response){
                            location.reload();
                        }
                    }
                });
            }
          });
       
    }
}