
$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    adminCompanyId = document.getElementById("adminCompanyId");

    if(adminCompanyId != null)
    {
        var url = "getEnrolledEmployeesByCompany/"+null+"/"+adminCompanyId.value
    }
    else{
        var url = "getEnrolledEmployees"
    }

    $.ajax({
        type: "get",
        url:url,
        success: function (response) {
        $("#enrolledEmployees").empty();
         preEnrollTable =  $('#enrolledEmployees').DataTable({
                        autoWidth: false,
                        data:response,
                        columns:[
                          {title: "Nombre",data:'employee_name',name:'employee_name'},
                          {title: "Empresa",data:'company_name', name:'company_name'},
                          {title: "Nombre curso",data:'course_name',name:'course_name'},
                          {title: "Fecha de inicio",data:'begin_date',name:'begin_date'}
                        ],
                        language: {
                            url: '../js/locales/Spanish.json'
                        }
                    })
            preEnrollTable.columns.adjust();
         
        },
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });

    $('#filter').click(function(){
        var company_id = $('#company').val();
        $("#enrolledEmployees").empty();
        $.ajax({
            type: "get",
            url:"getEnrolledEmployeesByCompany/"+ company_id+"/"+null,
            success: function (response) {
           
             preEnrollTable =  $('#enrolledEmployees').DataTable({
                            destroy: true,
                            autoWidth: false,
                            data:response,
                            columns:[
                              {title: "Nombre",data:'employee_name'},
                              {title: "Empresa",data:'company_name'},
                              {title: "Nombre curso",data:'course_name'},
                              {title: "Fecha de inicio",data:'begin_date'}
                            ],
                            language: {
                                url: '../js/locales/Spanish.json'
                            }
                        })
                preEnrollTable.columns.adjust();
             
            },
          }).fail( function( jqXHR, textStatus, errorThrown ) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        });        
    });

});