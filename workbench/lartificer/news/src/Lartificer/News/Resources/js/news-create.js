$(document).ready(function() {

    /**
     * Ajax configuration
     */

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**
     * CKEditor area
     */

    CKEDITOR.replace('news-create-content');

    // Get rid of the editor's title attribute
    CKEDITOR.on('instanceCreated', function(event) {

        var editor = event.editor;
        editor.on('instanceReady', function(e) {
            $(e.editor.element.$).removeAttr("title");
        });
    });
});