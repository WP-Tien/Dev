jQuery(function ($) {
    'use strict';

    /** Media Admin **/
    $(document).on('click', '.apis-button-upload', function(e) {
        var mediaUploader;

        const button = $(this);
        const clearButton = button.siblings('.apis-button-clear');
        const inputFields = button.siblings('.apis-input-upload');

        if( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_name = wp.media({
            title: 'Set the image',
            button: {
                text: 'Choose the image'    
            },
            multiple: false
        });

        mediaUploader.on('select', function(){
            attachment = mediaUploader.state().get('selection').first().toJSON();

            inputFields.val(attachment.url);

            if( inputFields.siblings('.preview-image').length > 0 ){
                inputFields.siblings('.preview-image').attr('src', attachment.url);
            }else{
                var imageHtml =  '<img class="apis-preview-image" src="'+ attachment.url +'" />';
                inputFields.parent().append(imageHtml);
            }

            clearButton.attr('disabled', false);
            // inputFields.trigger('change'); /* For widget */
        });

        mediaUploader.open();
    });

    $(document).on('click', '.apis-button-clear', function(e){
        const button = $(this);

        button.attr('disabled', true);
        button.siblings('.apis-input-upload').val('');
        button.siblings('.apis-preview-image').fadeOut( 250, function(){
            button.siblings('.apis-preview-image').remove();
        });

        // button.siblings('.apis-input-upload').trigger('change'); /* For widget */
    });

    /** SELECT 2 JS */
    $('.apis-select-multiple > select').select2({
        placeholder: 'Select an option',
        width: '350px'
    });

    /** Admin notice */
    $(document).on('click', '.apis-notice-dismiss', function(e) {
        e.preventDefault();

        var $notice = $(this).parent('.notice.is-dismissible');
        $notice.slideUp(150);
    });
});