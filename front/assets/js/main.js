$(document).ready(function () {
    $("#validate-form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            pwd: {
                required: true,
                minlength: 6,
                maxlength: 15
            }
        },
        messages: {
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"
            },
            pwd: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            }
        }
    });
})
