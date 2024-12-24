(function($) {  
	"use strict";
    
    var inlineCardActions = {
        inlineCard: '',

        saveForm: function(){
            
            let formElm = $(inlineCardActions.inlineCard.find('form')[0]);
            let formData = formElm.serializeArray();
            console.log(formData);

            formData.forEach(elm => {
                $('.inline-info-wrapper').find("[data-card='" + elm.name + "']").html(elm.value);
            });

            
        },

        resetForm: function(){
            console.log("resetAction")
        },

        init: function(){
            $(".inline-form-actions").on('click', function(){
                inlineCardActions.inlineCard = $(this).parents('.inline-card');
                inlineCardActions.inlineCard.find('.inline-form-wrapper').toggleClass('d-none');
                inlineCardActions.inlineCard.find('.inline-info-wrapper').toggleClass('d-none');
                inlineCardActions.inlineCard.find('.inline-form-actions').toggleClass('d-none');

                if($(this).hasClass('inline-form-save-action')){
                    inlineCardActions.saveForm();
                }

                if($(this).hasClass('inline-form-cancel-action')){
                    inlineCardActions.resetForm();
                }

            });

        }
    };

    $(document).ready(function () {
		inlineCardActions.init();
	})
}) (jQuery)