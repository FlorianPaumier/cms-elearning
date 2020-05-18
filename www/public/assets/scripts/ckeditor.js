$(document).ready(function(){
    createCkeditor($(".form-container"));
});


function createCkeditor(container){
    let component = $(container).find(".ckeditor");

    component.each((key,element) => {
        ClassicEditor
            .create( element )
            .catch( error => {
                console.error( error );
            } );
    })
}