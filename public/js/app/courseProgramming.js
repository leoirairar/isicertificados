var startDate;
let courseId;
let dates

$(document).ready(function() {


    $('#datetimepicker5').datetimepicker({
        format: 'LT',
        useCurrent: false,
        language: 'es'
    });

    $('#datetimepicker3').datetimepicker({
        format: 'LT',
        useCurrent: false,
        language: 'es'
    });


    $('#datetimepicker6').datepicker({
        format: 'dd/mm/yyyy',
        multidate: true,
        multidateSeparator: ",",
        language: 'es',


    });


    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        height: 300,
        locale: 'es',
        plugins: ['dayGrid'],
        displayEventTime: false,
        events: 'getCourseProgrammingJson',
        selectable: false,
        eventColor: '#378006',
        nextDayThreshold: '00:00:00',
        eventClick: function(event) {

        },
        eventRender: function(info) {}
    });
    calendar.render();


    $("#datetimepicker6").change(function() {
        dates = $("#datetimepicker6").datepicker('getFormattedDate')

    });



});

function validateMyForm() {

    try {

        courseId = document.getElementById('course').value;
        var datesArr = dates.split(',');
        datesArr.sort(function(a, b) {
            var da = new Date(a).getTime();
            var db = new Date(b).getTime();

            return da < db ? -1 : da > db ? 1 : 0
        });
        var lastPositionArray = datesArr.length - 1;
        $.ajax({
            type: "post",
            url: "checkCourseProgramming",
            data: { 'courseId': courseId, 'beginDate': datesArr[0], 'endDate': datesArr[lastPositionArray] },
            success: function(response) {
                if (response) {
                    Swal.fire({
                        title: 'Ya existe una programacion para este curso en las mismas fechas',
                        text: 'Desea realizar una copia',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#38c172',
                        confirmButtonText: 'Si!',
                        cancelButtonText: 'No.'
                    }).then((result) => {
                        if (result.value) {
                            document.getElementById('formProgramming').submit();
                            url = route('courseProgramming');
                            const link = document.createElement('a');
                            link.href = url;
                            document.body.appendChild(link);
                            link.click();
                        } else if (result.dismiss === swal.DismissReason.cancel) {
                            return false;
                        }
                    });
                } else {
                    document.getElementById('formProgramming').submit();
                    return true;
                }
            }
        });

        return false;

    } catch (error) {
        console.log(error);
        return false;
    }






}