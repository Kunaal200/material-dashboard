(function($) {  
	"use strict";
    
    var editProfile = {
        formElm: $('#editProfileForm'),

        init: function(){
            $(".inline-form-actions").on('click', function(){
                let card = $(this).parents('.inline-card');
                card.find('.inline-form-wrapper').toggleClass('d-none');
                card.find('.inline-info-wrapper').toggleClass('d-none');
                card.find('.inline-form-actions').toggleClass('d-none');
            })
        }
    };

    $(document).ready(function () {
		if($('#editProfileForm').length > 0){
			editProfile.init();
		}

	})
}) (jQuery)