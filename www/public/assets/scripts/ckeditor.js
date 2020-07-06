$(document).ready(function(){
    createCkeditor($(".form-container"));
});


function createCkeditor(container){
    let component = $(container).find(".ckeditor");

    component.each((key,element) => {
        ClassicEditor
            .create( element , {
                filebrowserBrowseUrl: '/assets/scripts/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '/assets/scripts/ckfinder/ckfinder.html?type=Images',
                filebrowserUploadUrl: '/assets/scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '/assets/scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                ckfinder: {
                    openerMethod: 'popup',
                    uploadUrl: '/assets/scripts/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images&responseType=json'
                }
            })
            .catch( error => {
                console.error( error );
            } );
    })
}