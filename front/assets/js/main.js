
(function($) {  
	"use strict";

	var signup = {
		formElm: $('#signupForm'),
		submit: function(){
			this.formElm.on('submit',function(e){
				e.preventDefault();
				if(signup.formElm.valid()){
					let formData = signup.formElm.serializeArray()
					formData.push({
						name: "action",
						value: "signup"
					})
					$.ajax({
						type: "POST",
						url: "/sign-up",
						data: formData,
						dataType: "json",
						success: function(result){
						   	console.log(result);
							// if(result.success){
							// 	$('#submitbtn')
							// 	.html("Successfully Signed Up!!")
							// 	.removeClass("bg-gradient-dark")
							// 	.addClass("bg-success")
							// 	.addClass("text-white");
							// }else{
							// 	$('#submitbtn')
							// 	.html("Oops!! Error!!")
							// 	.removeClass("bg-gradient-dark")
							// 	.addClass("bg-danger")
							// 	.addClass("text-white");
							// }
						   	if(!isJson(result)){
								result = $.parseJSON(result);
						   	}
							// result = $.parseJSON(result);
							if(result.success){
								$('#submitbtn')
								.html("Successfully Signed Up!!")
								.removeClass("bg-gradient-dark")
								.addClass("bg-success")
								.addClass("text-white");

								$('#submitbtn').parent().find('.form-error').css('display', 'none').html('');
							}else{
								$('#submitbtn')
								.html("Oops!! Error!!")
								.removeClass("bg-gradient-dark")
								.addClass("bg-danger")
								.addClass("text-white");

								$('#submitbtn').parent().find('.form-error').css('display', 'block').html(result.message);
							}
						}
					});
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

	var signin = {
		formElm: $('#signinForm'),
		submit: function(){
			this.formElm.on('submit',function(e){
				e.preventDefault();
				if(signin.formElm.valid()){
					let formData = signin.formElm.serializeArray()
					formData.push({
						name: "action",
						value: "signin"
					})
					$.ajax({
						type: "POST",
						url: "/sign-in",
						data: formData,
						dataType: "json",
						success: function(result){
						   	console.log(result);
							// if(result.success){
							// 	$('#submitbtn')
							// 	.html("Successfully Signed Up!!")
							// 	.removeClass("bg-gradient-dark")
							// 	.addClass("bg-success")
							// 	.addClass("text-white");
							// }else{
							// 	$('#submitbtn')
							// 	.html("Oops!! Error!!")
							// 	.removeClass("bg-gradient-dark")
							// 	.addClass("bg-danger")
							// 	.addClass("text-white");
							// }
						   	if(!isJson(result)){
								result = $.parseJSON(result);
						   	}
							// result = $.parseJSON(result);
							if(result.success){
								$('#submitbtn')
								.html("Successfully Signed In!!")
								.removeClass("bg-gradient-dark")
								.removeClass("bg-danger")
								.addClass("bg-success")
								.addClass("text-white");

								$('#submitbtn').parent().find('.form-error').css('display', 'none').html('');
							}else{
								$('#submitbtn')
								.html("Oops!! Error!!")
								.removeClass("bg-gradient-dark")
								.removeClass("bg-success")
								.addClass("bg-danger")
								.addClass("text-white");

								$('#submitbtn').parent().find('.form-error').css('display', 'block').html(result.message);
							}
						}
					});
					console.log('Submit Called.');
				}
			});
		},
		validate: function(){
			this.formElm.validate({
				rules: {
					email: {
					  required: true,
					  email: true,
					},
					password: {
					  minlength: 6,
					  required: true,
					}
				  },
				messages: {
					email: {
					  required: "Please enter your email",
					  email: "Please enter a valid email address",
					},
					password: {
					  required: "Please enter your password",
					  minlength: "Password must be at least 6 characters long",
					}
				}
			});
		},
		init: function(){
			this.validate();
			this.submit();
		},
	};


	function isJson(str) {
		if(typeof str === 'object'){
			return true;
		}else{
			try {
				JSON.parse(str);
			} catch (e) {
				console.log(e);
				return false;
			}
			return true;
		}
		
	}

	$(document).ready(function () {
		if($('#signupForm').length > 0){
			signup.init();
		}

		//Pa$$w0rd!
		if($('#signinForm').length > 0){
			signin.init();
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
