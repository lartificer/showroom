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
     * Handle everything that has to do with the checkboxes
     */
    $('.visibility-checkbox').change(function() {

        // Retrieve the state of the checkbox after being clicked and compute a text that has to be confirmed on change of the box.
        var $isChecked = $(this).is(":checked");
        if(!$isChecked) {
            var text = 'Do you really want to hide the news entry?';
        } else {
            var text = 'Make the news entry visible?';
        }

        var confirmation = confirm(text);

        var $entryId = $(this).data('entry-id');

        // Check if the user confirmed the change. Send a POST request to the server in that case. Otherwise reset the checkbox state.
        if(confirmation) {

            // Fetch the current url of the toggleVisibility route
            var $path = $('input[name=secret-visibility-route]').val();
            var data = { Visibility: '' + $isChecked , Id: $entryId};

            $.ajax({
                url: $path,
                type: 'POST',
                data: JSON.stringify(data),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                async: true,
                success: function(msg) {
                    alert(msg);
                }
            });
        } else {

            $(this).prop('checked', !$isChecked);

        }
    });

    /**
     * Handle removing
     */
    $('.remove-news-button').click(function(event) {

        event.preventDefault();

        // Ask the user to really delete the news entry
        var text = 'Really delete the news entry?';
        var confirmation = confirm(text);

        if(confirmation) {

            var path = $('input[name=secret-delete-route]').val();
            var entryId = $(this).data('entry-id');

            window.location.href = path + '/' + entryId;

        } else {

        }
    });

    /**
     * CKEditor area
     */

    CKEDITOR.disableAutoInline = true;

    // Go through all class .editor elements
    $('.editor').each(function() {

        // Check if they are a .headline or .content element and load the default or none config file in order to have no toolbar for headlines
        if($(this).hasClass('content')) {

            // Init the content with the default config
            CKEDITOR.inline($(this).get(0));

        } else {

            // For the headline remove the toolbar and only allow unformatted headlines
            CKEDITOR.inline(
                $(this).get(0), {
                    removePlugins: 'toolbar',
                    allowedContent: 'h1 h2 h3'
                }
            );

        }
    });


    CKEDITOR.on('instanceReady', function(e) {

        // Remove the title attribute that is created automatically by the editor
        $(e.editor.element.$).removeAttr("title");

        // If the editor looses focus, save the news entry
        e.editor.on('blur', function(event) {

            var $editor = $(event.editor.element.$);
            var entryId = $editor.data('entry-id');
            var path = $('input[name=secret-update-route]').val() + '/' + entryId;
            var textContent = event.editor.getData();

            console.log(textContent);

            // The element is a headline element
            if($editor.hasClass('headline')) {

                var data = { Type: 'headline' , Content: textContent};

                $.ajax({
                    url: path,
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    async: true,
                    success: function(msg) {
                        alert(msg);
                    }
                });

            } else {

                var data = { Type: 'content' , Content: textContent};

                $.ajax({
                    url: path,
                    type: 'POST',
                    data: JSON.stringify(data),
                    contentType: 'application/json; charset=utf-8',
                    dataType: 'json',
                    async: true,
                    success: function(msg) {
                        alert(msg);
                    }
                });

            }
        });

    });
});