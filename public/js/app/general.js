var idFile = [];



$(document).ready(function() {

    setTimeout(function() {
        $(".alert").alert('close');
    }, 20000);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "get",
        url: "getNotifications",
        success: function(response) {
            document.getElementById("notifyQuantity").innerHTML = response.length;
            $("#notifyContent").empty();
            for (let index = 0; index < 3; index++) {
                if (response.length > 0) {

                    $("#notifyContent").append(`
                    <div class="d-flex flex-row mt-4">
                    <div class="col-sm-2" style="">
                    <i class="far fa-bell"></i>
                    </div>
                    <div class="col-sm-10" style="">
                    <div style="font-size:12px;font-weight: bold;">
                      ${response[index].detail}
                    </div>
                    <div style="font-size: 12px;font-weight: normal;">
                      ${moment(response[index].created_at)
                          .locale("es")
                          .format("MMMM DD YYYY, h:mm:ss a")}
                    </div>
                    </div>
                    </div>


                `);
                }
            }
           
        }
    });

    $('#email').change(function(e) {
        e.preventDefault();

        var email = document.getElementById('email').value;
        var data = { 'email': email }

        $.post("veryfyEmail", data).done(function(response, textStatus, jqXHR) {

            if (response) {
                document.getElementById('email').value = '';
                Swal.fire({
                    type: 'error',
                    title: 'Correo duplicado',
                    text: 'El correo que acabas de ingresar ya se encuentra registrado, por favor ingrese otro!',
                });

            }
        });

    });

    $("#companyAdmin").select2();

});



function showAlert() {
    event.preventDefault();
    let ev = event.currentTarget;

    let form = ev.form;
    Swal.fire({
        title: 'Estas seguro que desea modificar el registro ?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#38c172',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No.'
    }).then((result) => {
        if (result.value) {
            form.submit();
        } else if (result.dismiss === swal.DismissReason.cancel) {
            swal.fire("Cancelado");
        }
    });
}




//third party code to prevent drop-up
// (function($) {

// 	var Defaults = $.fn.select2.amd.require('select2/defaults');

//   $.extend(Defaults.defaults, {
//   	dropdownPosition: 'auto'
//   });

//  	var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

//   var _positionDropdown = AttachBody.prototype._positionDropdown;

//   AttachBody.prototype._positionDropdown = function() {

//     var $window = $(window);

// 		var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
// 		var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

// 		var newDirection = null;

// 		var offset = this.$container.offset();

// 		offset.bottom = offset.top + this.$container.outerHeight(false);

// 		var container = {
//     		height: this.$container.outerHeight(false)
// 		};

//     container.top = offset.top;
//     container.bottom = offset.top + container.height;

//     var dropdown = {
//       height: this.$dropdown.outerHeight(false)
//     };

//     var viewport = {
//       top: $window.scrollTop(),
//       bottom: $window.scrollTop() + $window.height()
//     };

//     var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
//     var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

//     var css = {
//       left: offset.left,
//       top: container.bottom
//     };

//     // Determine what the parent element is to use for calciulating the offset
//     var $offsetParent = this.$dropdownParent;

//     // For statically positoned elements, we need to get the element
//     // that is determining the offset
//     if ($offsetParent.css('position') === 'static') {
//       $offsetParent = $offsetParent.offsetParent();
//     }

//     var parentOffset = $offsetParent.offset();

//     css.top -= parentOffset.top
//     css.left -= parentOffset.left;

//     var dropdownPositionOption = this.options.get('dropdownPosition');

// 		if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {

//     		newDirection = dropdownPositionOption;

//     } else {

//         if (!isCurrentlyAbove && !isCurrentlyBelow) {
//       			newDirection = 'below';
//     		}

//     		if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
//       		newDirection = 'above';
//     		} else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
//       		newDirection = 'below';
//     		}

//     }

//     if (newDirection == 'above' ||
//         (isCurrentlyAbove && newDirection !== 'below')) {
//       css.top = container.top - parentOffset.top - dropdown.height;
//     }

//     if (newDirection != null) {
//       this.$dropdown
//         .removeClass('select2-dropdown--below select2-dropdown--above')
//         .addClass('select2-dropdown--' + newDirection);
//       this.$container
//         .removeClass('select2-container--below select2-container--above')
//         .addClass('select2-container--' + newDirection);
//     }

//     this.$dropdownContainer.css(css);

//   };

// })(window.jQuery);
