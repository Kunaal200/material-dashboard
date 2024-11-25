
(function($) {  
	"use strict";

	var signup = {
		formElm: $('#signupForm'),
		submit: function(){
			this.formElm.on('submit',function(e){
				e.preventDefault();
				if(signup.formElm.valid()){
					console.log('Submit Called.');
				}
			});
		},
		validate: function(){
			this.formElm.validate({
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
					  minlength: 6,
					  required: true,
					},
					cpassword: {
					  minlength: 6,
					  equalTo: "#password",
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
					cpassword: {
					  required: "Please enter your confirm password",
					  minlength: "Confirm Password must be at least 6 characters long",
					},
				}
			});
		},
		init: function(){
			this.validate();
			this.submit();
		},
	};


	$(document).ready(function () {
		if($('#signupForm').length > 0){
			signup.init();
		}
	})
}) (jQuery)





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
});
