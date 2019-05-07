jQuery(document).ready(function($) {

	// ADD IMAGE LINK
    $('body').on('click','.salon-upload-button',function(e) {
        e.preventDefault();
        var clicked = $(this).closest('div');
        var custom_uploader = wp.media({
            title: 'Salon Image Uploader',
            // button: {
            //     text: 'Custom Button Text',
            // },
            multiple: false  // Set this to true to allow multiple files to be selected
            })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            var str = attachment.url.split('.').pop(); 
            var strarray = [ 'jpg', 'gif', 'png', 'jpeg' ]; 
            if( $.inArray( str, strarray ) != -1 ){
                clicked.find('.salon-screenshot').empty().hide().append('<img src="' + attachment.url + '"><a class="rara-remove-image"></a>').slideDown('fast');
            }else{
                clicked.find('.salon-screenshot').empty().hide().append('<small>'+salon_companion_uploader.msg+'</small>').slideDown('fast');    
            }
            
            clicked.find('.salon-upload').val(attachment.id).trigger('change');
            clicked.find('.salon-upload-button').val(salon_companion_uploader.change);
        }) 
        .open();
    });

    $('body').on('click','.salon-remove-image',function(e) {
        
        var selector = $(this).parent('div').parent('div');
        selector.find('.salon-upload').val('').trigger('change');
        selector.find('.salon-remove-image').hide();
        selector.find('.salon-screenshot').slideUp();
        selector.find('.salon-upload-button').val(salon_companion_uploader.upload);
        
        return false;
    });

});
