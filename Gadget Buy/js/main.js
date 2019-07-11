$(document).ready(function(){
	/*REGISTRATION FORM VALIDATION*/
	$('#s-form').on("submit", function(e){
		e.preventDefault();
		var name = $.trim($('#s-name').val()),
			email = $.trim($('#s-email').val()),
			phone = $.trim($('#s-phone').val()),
			password = $.trim($('#s-password').val()),
			message = $('#s-message');

		/*all the form is filed*/

		if ((name != "") && (email != "") && (phone != "") && (password != "")) {
			/*validate email*/
			if (hk_email(email)) {
				/*check phone number*/
				if (hk_phoneNo(phone)) {
					/*submit the form via ajax bro*/
					$.ajax({
						url: "./parse/signup_back.php",
						data: {name:name,email:email,phone:phone,password:password},
						type: "post",
						beforeSend: function(){
							message.html("<img src='images/ajax.gif'>");
						},
						complete: function(data){
							
							var json = $.parseJSON(data.responseText);		
							if (json.type == "error") {
								message.removeClass('text-green').addClass('text-red').html(json.message);
							}else{
								message.removeClass('text-red').addClass('text-green').html(json.message);
								window.location.reload();
							}
						}
					});
				}else{
					message.removeClass("text-green").addClass("text-red").text("Invalid Phone Number.");	
				}
			}else{
				message.removeClass("text-green").addClass("text-red").text("Invalid Email Address.");	
			}
		}else{
			message.removeClass("text-green").addClass("text-red").text("Fill in all the Fields.");
		}
	});


	/* LOGIN FORM VALIDATION*/
	$('#l-form').submit(function(e){
		e.preventDefault();
		var email = $('#l-email').val(),
			password = $('#l-password').val(),
			message = $('#l-message');

		if ((email != "") && (password != "")) {
			$.ajax({
				url: "./parse/login_back.php",
				data: {email:email,password:password},
				type: "post",
				beforeSend: function(){
					message.html("<img src='images/ajax.gif'>");
				},
				complete: function(data){
					var json = $.parseJSON(data.responseText);
					if (json.type == "error") {
						message.addClass('text-red').text(json.message);
					}else{
						message.removeClass("text-red").addClass('text-green').text(json.message);
						window.location.reload();
					}
				}
			});
		}else{
			message.addClass('text-red').text("Fill in all the fields");
		}
	});


	/* ADD TO CART */
	$("#add-to-cart").click(function(){
		var product_id = $('#p-id').val(),
			message = $("#add-to-cart-message");
		$.ajax({
			url: "./parse/add_to_cart.php",
			data: {product_id:product_id},
			type: "post",
			beforeSend: function(){
				message.html("<img src='images/ajax.gif'>");
			},
			complete: function(data){
				var json = $.parseJSON(data.responseText);
				if (json.type == "success") {
					message.removeClass('text-red').addClass('text-green').html(json.message);
					/*update cart count*/
					hk_update_cart_cout("#cart-count");
				}else{
					message.removeClass('text-green').addClass('text-red').html(json.message);
				}
			}
		});
	});

	/*remove from cart*/
	$('.remove-from-cart').click(function(){
		var cart_id = $(this).attr('id'),
			message = $('#cart-message');

		$.ajax({
			url: "./parse/remove_from_cart.php",
			type: "post",
			data: {cart_id:cart_id},
			beforeSend: function(){
				message.html("<img src='images/ajax.gif'>");
			},
			complete: function(data){
				var json = $.parseJSON(data.responseText);
				/*if remove was succesfull*/
				if (json.type == "success") {
					window.location.reload();
				}else{ /*if remove was failed*/
					message.addClass('text-red').html(json.message);
				}
			}
		});
	});

	/* place order validation */
	$('#place_order_form').submit(function(event){
		event.preventDefault();
		// get the value to input fields
		var name = $.trim($('#order_name').val()),
			email = $.trim($('#order_email').val()),
			mobile = $.trim($('#order_mobile').val()),
			city = $.trim($('#order_city').val()),
			pincode = $.trim($('#order_pincode').val()),
			address = $.trim($('#order_address').val()),
			message = $('#order_message'),
			product_id_stack = $.trim($('#product-id-stack').val());

			if ((name == "") || (email == "") || (mobile == "") || (city == "") || (pincode == "") || (address == "")) {
				message.addClass('text-red').html("Fill in all the fields.");
			}else{
				// validate email
				if (hk_email(email)) {
					//check for mobile no
					if (hk_phoneNo(mobile)) {
						/*check pincode*/
						if (pincode.length == 6) {
							/*send the request to the database*/
							$.ajax({
								url: "./parse/buy.php",
								data: {product_id_stack:product_id_stack,name:name,email:email,mobile:mobile,city:city,pincode:pincode,address:address},
								type: "post",
								beforeSend: function(){
									message.html("<img src='images/ajax.gif'>");
								},
								complete: function(data){
									var json = $.parseJSON(data.responseText);
									if (json.type == "success") {
										message.removeClass("text-red").addClass('text-green').html("Your Order Has Been Placed");
										/*send the user to user.php for orders details*/
										window.location = "user.php";									
									}else{
										message.addClass('text-red').html(json.message);
									}
								}
							});
						}else{
							message.addClass('text-red').html("Invalid Pincode.");
						}
					}else{
						message.addClass('text-red').html("Invalid mobile number");	
					}
				}else{
					message.addClass('text-red').html("Invalid email address.");
				}
			}
	});

	/*set the height of the admin-left*/
	var height = $(document).height();
	$('#admin-left').css("height", height);
});