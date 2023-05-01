
$(document).ready(function () {
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var comanyInput = null;
    var adminCompanyId = document.getElementById("adminCompanyId");


    if(adminCompanyId != null)
    {
        var url = "getPreEnrolledEmployeesByCompany/"+ comanyInput+"/"+adminCompanyId.value
    }
    else{
        var url = "getPreEnrolledEmployees"
    }

    $.ajax({
        type: "get",
        url:url,
        dataType: "json",
        success: function (response) {
        $("#employeesPreEnrolled").empty();
         preEnrollTable =  $('#employeesPreEnrolled').DataTable({
                        autoWidth: false,
                        data:response,
                        columnDefs:[
                            {title: "Nombre",data:'employee_name',targets:0},
                            {title: "Empresa",data:'company_name', targets:1},
                            {title: "Nombre curso",data:'course_name',targets:2},
                            {title: "Fecha de inicio",data:'begin_date',targets:3},
                            {
                              title: "Eliminar",
                              
                              render: function ( data, type, row ) {
                                return '<a href="getEditablesFilesByEmployee/'+row.employee_id+'/'+row.course_id+'/'+row.company_id+'/'+row.coursePrograming_id+'" class="btn btn-primary">Actualizar documentos</a>';
                              },
                              targets:4
                          }
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
        $("#employeesPreEnrolled").empty();
        $.ajax({
            type: "get",
            url:"getPreEnrolledEmployeesByCompany/"+ company_id+"/"+null,
            dataType: "json",
            success: function (response) {
           
             preEnrollTable =  $('#employeesPreEnrolled').DataTable({
                            destroy: true,
                            autoWidth: false,
                            data:response,
                            columnDefs:[
                              {title: "Nombre",data:'employee_name',targets:0},
                              {title: "Empresa",data:'company_name', targets:1},
                              {title: "Nombre curso",data:'course_name',targets:2},
                              {title: "Fecha de inicio",data:'begin_date',targets:3},
                              {
                                title: "Eliminar",
                                data: "data",
                                render: function ( data, type, row ) {
                                    return '<a href="getEditablesFilesByEmployee/'+row.employee_id+'/'+row.course_id+'/'+row.company_id+'/'+row.coursePrograming_id+'" class="btn btn-primary">Actualizar documentos</a>';
                                
                                },
                                targets:4
                            }
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