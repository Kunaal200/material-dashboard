$(document).ready(function () {
  $("#validate-form").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      pwd: {
        required: true,
        minlength: 6,
        maxlength: 15,
      },
    },

    messages: {
      email: {
        required: "We need your email address to contact you",
        email: "Your email address must be in the format of name@domain.com",
      },
      pwd: {
        required: "Please provide a password",
        minlength: "Your password must be at least 6 characters long",
      },
    },
  });

  $("#signupForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3,
      },
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 6,
      },
    },
    messages: {
      name: {
        required: "Please enter your name",
        minlength: "Your name must be at least 3 characters long",
      },
      email: {
        required: "Please enter your email",
        email: "Please enter a valid email address",
      },
      password: {
        required: "Please enter your password",
        minlength: "Password must be at least 6 characters long",
      },
    },
  });
});
