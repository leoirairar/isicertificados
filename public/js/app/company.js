$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $.ajax({
        type: "get",
        url:"getCompaniesData/",
        dataType: "json",
        success: function (response) {
        $("#companiesTable").empty();
         companiesTable =  $('#companiesTable').DataTable({
                        autoWidth: false,
                        data:response[0],
                        columnDefs:[
                            {title: "Nombre",data:'company_name',targets:0},
                            {title: "Nit",data:'nit', targets:1},
                            {title: "Teléfono",data:'phone_number',targets:2},
                            {title: "Estado",
                                render: function ( data, type, row ) {
                                    return (row.deleted_at == null)?'Activo':'Inactivo';
                                  },
                                targets:3
                            },
                            {title: "Detalle",
                                render: function ( data, type, row ) {
                                    return `<a href="getCompanyInformation/${row.id}" class="btn btn-success">detalle</a>`
                                  },
                                targets:4
                            },
                            {title: "Editar",
                                render: function ( data, type, row ) {
                                    return `<a href="editCompany/${row.id}" class="btn btn-success">editar</a>`
                                  },
                                targets:5
                            },
                            {title: "Editar",
                                render: function ( data, type, row ) {
                                    if(row.deleted_at == null){
                                        return `<a href="deleteCompany/${row.id}" class="btn btn-danger"><span class="fa fa-trash-o"></a>`
                                    }else{
                                        return `<a href="deleteCompany/${row.id}" class="btn btn-danger"><span class="fa fa-undo"></a>`
                                    }
                                    
                                  },
                                targets:6
                            },
                            
                          ],
                        language: {
                            url: '../js/locales/Spanish.json'
                        }
                    })
            companiesTable.columns.adjust();
         
        },
      }).fail( function( jqXHR, textStatus, errorThrown ) {
        console.log(jqXHR);
        console.log(textStatus);
        console.log(errorThrown);
    });
});