$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    var paymentDay =  document.getElementById("paymentDay");

    if(paymentDay !== 'undefined'){

        $("#paymentStatus").change(function (e) { 
            if (e.currentTarget.value == 0) {
                paymentDay.disabled = true;
                paymentDay.value = '';
                paymentDay.required = false;
            }
            else{
                paymentDay.disabled = false;
                paymentDay.required = true;
                
            }
            
        });
    }


    $.ajax({
        type: "get",
        url: "getDebtFreeEmployees",
        success: function (response) {
            $("#debtFreeEmployeesDataTable").empty();
            $('#debtFreeEmployeesDataTable').DataTable({
                data:response,
                columnDefs:[
                  {
                        title: "Nombre empleado",
                        data: "",
                        render:function(data,type,row){
                            return row.name+' '+row.last_name;
                        },
                        targets:0
                  },
                  {title: "Empresa",data:'company_name', targets:1},
                  {title: "Curso",data:'course_name',targets:2},
                  {title: "Fecha del curso",data:'begin_date',targets:3},
                  {
                      title: "Factura",
                      data: "bill_serial",
                      targets:4,
                  },
                  {
                        title: "Valor",
                        data: "payment",
                        targets:5,
                  },
                  {
                        title: "Estado pago",
                        data: "",
                        render:function (data,type,row) {
                          return (row.payment_status == 1)?"Pagó":""
                          
                        },
                        targets:6,
                  },                  
                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })
        }
    });

   

    $.ajax({
        type: "get",
        url: "getIndebtedEmployees",
        success: function (response) {
            $("#indebtedEmployeesDataTable").empty();
             var enrollTable =  $('#indebtedEmployeesDataTable').DataTable({
                            data:response,
                            columnDefs:[
                              {
                                    title: "Nombre empleado",
                                    data: "",
                                    render:function(data,type,row){
                                        return row.name+' '+row.last_name;
                                    },
                                    targets:0
                              },
                              {title: "Empresa",data:'company_name', targets:1},
                              {title: "Curso",data:'course_name',targets:2},
                              {title: "Fecha del curso",data:'begin_date',targets:3},
                              {
                                  title: "Factura",
                                  data: "",
                                  render:function (data,type,row) {
                                    return `<input class="form-control" type="text" id="bill_serial" value="${row.bill_serial}">`
                                  },
                                  targets:4,
                              },
                              {
                                    title: "Valor",
                                    data: "",
                                    render:function (data,type,row) {
                                      return `<input class="form-control" type="text" id="payment" value="${row.payment}">`
                                    },
                                    targets:5,
                              },
                              {
                                    title: "Estado pago",
                                    data: "",
                                    render:function (data,type,row) {
                                      return `<select class=" form-control" id="status">
                                                    <option value="1" ${(row.payment_status == 1 ? "selected":"") } >Si</option>
                                                    <option value="0" ${(row.payment_status == 0 ? "selected":"") } >No</option>
                                               </select>`
                                    },
                                    targets:6,
                              },
                              {
                                    title: "Actualizar",
                                    data: "",
                                    render:function (data,type,row) {
                                      return `<button type="button" id="btn" class="btn btn-primary">Actualizar</button>`;
                                    },
                                    targets:7,
                              },
                              
                            ],
                            language: {
                                url: '../js/locales/Spanish.json'
                            }
                        })
            //console.log(response);

            $('#indebtedEmployeesDataTable tbody').on( 'click', '#btn', function (e) {

                var formData = new FormData();
                
                formData.append("billSerial", $(this).parents("tr").find('#bill_serial').val());
                formData.append("paymentStatus", $(this).parents("tr").find('#status').val());
                formData.append("payment",$(this).parents("tr").find('#payment').val() );

                $.ajax({
                    type: "POST",
                    url: "updateBill/"+enrollTable.row( $(this).parents('tr') ).data().id,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response) {
                            location.reload();  
                        }
                    }
                });
            } );
        
        }
    });
    
    
}); 



