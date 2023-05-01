var idDocumentCourse = [];
var filesFlag = true;
var chekFileNotification = [];
var url
var idEmployeeDocuments = [];

$(document).ready(function () {

    
    var courseDocumentsType= course.documents_type

    courseDocumentsType.forEach(element => {
        
        

        idDocumentCourse.push(element.id);
        $("#attachment").append("<div data-type='default' class='row'>\
              <div data-type='default' class='col-md-8 mt-3'>\
              <label>"+element.name+"</label>\
              <input class='form-control form-control-file target' type='file' id='file-"+element.id+"' value=''  onchange='getValue("+element.id+")' dataid='"+element.id+"' name='docFiles[]' required='required' autofocus='autofocus'>\
              <i class='btn btn-primary btn-sm mt-1' onclick='modify("+element.id+")'; return false; id='modify"+element.id+"'>Modificar documento</i>\
              <a class='btn btn-primary btn-sm mt-1' href='"+url+"' ; return false;' id='userFile"+element.id+"' style='margin-left: 5%'>Ver documento</a>\
              <input id='fileid-"+element.id+"' name='fileid[]' type='hidden' value=''>\
              </input>\
              </div>\
              </div>");  

             

              employeeFiles.forEach(employeeFile => {
               var index  = idEmployeeDocuments.indexOf(employeeFile.file_id);
                if(index == -1){
                    if(element.id == employeeFile.file_id){
                   
                        url = route('file', {id: employeeFile.id})
                        document.getElementById('fileid-'+element.id).value = employeeFile.id;
                        idEmployeeDocuments.push(employeeFile.file_id);
                        if(employeeFile.status == null){
                           var modify = document.getElementById('modify'+element.id)
                           modify.removeAttribute('onclick');
                           modify.style.visibility = 'hidden';

                        }
                        idEmployeeDocuments.push(employeeFile.file_id);
                    } 
                }
                  
            });
            var a = document.getElementById('userFile'+element.id);
            a.href = url;
              
            document.getElementById('file-'+element.id).disabled = true;
            document.getElementById('fileid-'+element.id).disabled = true;
    });

    //this control that if the user try to update a file and click on the cancel button and the input is empty, it'll disaible it 
    window.setInterval(() => {
        
        idDocumentCourse.forEach(element => {
            //console.log(element);
            var file =  document.getElementById('file-'+element)
            var fileid =  document.getElementById('fileid-'+element)
            if(file != null){
                if(file.files.length == 0){
                    file.disabled = true;
                    fileid.disabled = true
                }
                else{
                    filesFlag = false;
                }
            }
        });
    }, 60000);
    
    

    employeeFiles.forEach(employeeFile => {
        
        courseDocumentsType.forEach(courseFile => {
            
            if(courseFile.id == employeeFile.file_id){
                var indexOf = chekFileNotification.indexOf(courseFile.id);
                if (indexOf == -1) {
                    chekFileNotification.push(courseFile.id)
                    var node = document.createElement("LI"); 
                    if (employeeFile.status == "W") {
                        var textnode = document.createTextNode("El documento "+courseFile.name+" contiene errores o no es el correcto.");
                    }
                    if (employeeFile.status == "A") {
                        var textnode = document.createTextNode("El documento "+courseFile.name+" fue aprobado.");
                    }
                    if (employeeFile.status == "E") {
                        var textnode = document.createTextNode("No existe el documento "+courseFile.name+"");
                    }
                    if (employeeFile.status == null) {
                        var textnode = document.createTextNode("El documento "+courseFile.name+" esta pendiente por abrobar");
                    }
                    node.className = "list-group-item" ;
                    node.id = courseFile.id.toString();
                    node.appendChild(textnode);
                    document.getElementById("attachedDocuments").appendChild(node); 
                    
                }
                  
            }
        });
        
    });


});

function modify(id){
    //Swal.fire('Any fool can use a computer')
    Swal.fire({
        title: 'Estas seguro que desea modificar el documento?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#38c172',
        confirmButtonText: 'Si!',
        cancelButtonText: 'No.'
      }).then((result) => {
        if (result.value) {
            document.getElementById('file-'+id).disabled = false;
            document.getElementById('fileid-'+id).disabled = false;
            event.preventDefault();
        } else if (result.dismiss === swal.DismissReason.cancel) {
            document.getElementById('file-'+id).disabled = true;
            document.getElementById('fileid-'+id).disabled = true;
          }
      });
}

function getValue(param) {
    var file =  document.getElementById('file-'+param)
            if(file != null){
                if(file.files.length != 0){
                    document.getElementById('sendButton').disabled = false;
                }
            }
    
}
