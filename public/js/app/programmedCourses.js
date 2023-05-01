$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    $.ajax({
        type: "get",
        url: "getProgrammedCourses",
        dataType: "json",
        success: function(response) {
            $("#programmedCourses").empty();
            programmedCourses = $('#programmedCourses').DataTable({
                lengthMenu: [5, 10, 25, 50, 75, 100],
                data: response,
                // columns:[
                //   {title: "Nombre",data:'course.name',name:'course.name'},
                //   {title: "Fechas programadas",data:'course_days.[].date'},
                // ],
                "columnDefs": [
                    { "className": "dt-center", "targets": [0, 1, 2, 3, 4, 5] },
                    { "title": "Nombre Curso", "data": 'id', "targets": 0 },
                    { "title": "Nombre Curso", "data": 'course.name', "targets": 1 },
                    // {"title": "Codigo curso","data":'course.course_code',"targets": 1},
                    { "title": "Fecha de inicio", "data": 'begin_date', "targets": 2 },
                    { "title": "Fecha de finalización", "data": 'end_date', "targets": 3 },
                    // {"title": "Hora de inicio","data":'begin_hour',"targets": 4},
                    // {"title": "Hora de finalización","data":'end_hour',"targets": 5},
                    // {"title": "Lugar","data":'place',"targets": 6},
                    // {
                    //     "title": "Fechas curso",
                    //     "data": "course_days.[].date",
                    //     "render": function ( data, type, row ) {
                    //         var dates = [];
                    //         data.forEach(function(element) {
                    //             dates.push('<li>'+element+'</li>')
                    //           });
                    //         return dates.join('');
                    //     },
                    //     "targets": 7
                    // },
                    {
                        "title": "Actualizar",
                        "data": "id",
                        "render": function(data, type, row) {
                            return '<a href="editCourseProgramming/' + data + '" class="btn btn-success">Editar</a>';

                        },
                        "targets": 4
                    },
                    {
                        "title": "Eliminar",
                        "data": "id",
                        "render": function(data, type, row) {
                            return '<a href="deleteCourseProgramming/' + data + '" class="btn btn-danger">Eliminar</a>';

                        },
                        "targets": 5
                    }

                ],
                language: {
                    url: '../js/locales/Spanish.json'
                }
            })


        }
    });

});