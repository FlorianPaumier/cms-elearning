$(document).ready(function(){
    createCkeditor($(".form-container"));
});


function createCkeditor(container){
    let component = $(container).find(".ckeditor");

    component.each((key,element) => {
        $(element).froalaEditor({
            // Set the file upload URL.
            imageUploadURL: '/upload/file',

            imageUploadParams: {
                id: 'my_editor'
            }
        })
    });
}