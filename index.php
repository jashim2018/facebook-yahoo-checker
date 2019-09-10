
<!DOCTYPE html>
<html>
<head>
	<title>Facebook Yahoo Checker</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<style type="text/css">
	body{
		padding-top: 20%;
	}
		button{
			border: 2px solid #007bff !important;
			border-radius: 1px !important;
		}
		button:focus, button:active{
			box-shadow: none !important;
			outline: none !important;
			background: #007bff;
			color: white;
		}
		.alert{
			width: 50%;
		}
		div.container, div.container-two{
			width: 50%;
		}
		.friendsList{
			padding: 10px;
			border-radius: 5px;
			font-size: 15px;
			background: #eee;
			text-align: left !important;
			height: 450px;
			overflow-y: scroll;
		}
	</style>
</head>
<body>
	<center>
		<h1>Facebook Yahoo Checker</h1>
	  	<div class="alert alert-success">
	    	<strong>Success!</strong> You are now logged in successfully. Please wait.
	  	</div>
	  	<div class="alert alert-danger">
	    	<strong>Error!</strong> Login error or invalid password supplied.
	  	</div>
		<div class="container">
		 	<!-- <form action="/action_page.php"> -->
			  <div class="form-group">
			    <label for="email">Email address/Phone:</label>
			    <input type="text" class="form-control" id="email">
			  </div>
			  <div class="form-group">
			    <label for="pwd">Password:</label>
			    <input type="password" class="form-control" id="pwd">
			  </div>
			  <div class="form-group form-check">
			    <label class="form-check-label" style="font-size: 10px;">
			      <input class="form-check-input" type="checkbox"> Before clicking login, make sure you read our <a href="#">terms and conditions.</a>
			    </label>
			  </div>
			  <button type="button" class="btn btn-outline-primary btn-block waves-effect" id="facebook_login"><i class="fab fa-facebook-square"></i>&nbsp;Login with Facebook</button>
			<!-- </form> -->
			
			<input type="hidden" name="access_token" id="hid" value="">
		</div>
		<div class="container-two">
			<div class="row">
				<div class="col-6">Welcome, <span class="uname"></span></div>
				<div class="col-6">Email: <span class="email"></span></div>
			</div>
			<div class="row">
				<div class="col-12">
					<button class="btn btn-block btn-primary" id="scan">Start Scanning</button>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
					  <div class="friendsList">
					  	<center>
					  		<span class="text-info">Click the button to start.</span>
					  	</center>
					  </div>
					</div> 
				</div>
			</div>
		</div>
	</center>
	<br><br><br>
</body>
<script>
	$("#facebook_login").attr("disabled", true);
	$('.container-two').hide();
	$('.alert').hide();

	$(".form-check-input").click(function() {
	  $("#facebook_login").attr("disabled", !this.checked);
	});
	
	$('#facebook_login').click(function() {
		const u = $('#email').val();
		const p = $('#pwd').val();

		$.ajax({
			method : 'POST',
			url : 'process.php',
			data : {
				u : u,
				p : p
			},
			success : function(response) {
				response = JSON.parse(response);
				console.log(response);
				if(response['code'] == 'ok'){
					$('.container').hide();
					$('.container-two').show();
					$('.alert-success').show();
					setTimeout(function() {
						$('.alert-success').hide()
					}, 2000);
					$('.uname').html(response['uname']);
					$('.email').html(response['email']);
					$('#hid').val(response['access_token']);
				}else{
					$('.alert-danger').show();
				}
			}
		});
	})

	$('#scan').click(function() {
		var access_token = $('#hid').val();
		$('.friendsList').html('');
		$.getJSON('cache.json', function(result) {
			$.each(result['data'], function(index, value) {
				var name = value['name'];
				$.ajax({
					method : 'GET',
					url : 'https://graph.facebook.com/'+ value['id'] +'?access_token=' + access_token + '',
					success : function(res) {
						if(checkEmailIfYahoo(res['email'])){
							$('.friendsList').append('<span>Name: </span>' + res['name'] + '<br>');
							$('.friendsList').append('<span>Email: </span>' + res['email']+ '<br>');
							$('.friendsList').append('<span>Link: </span><a href="'+ res['link'] +'" target="_blank">' + res['link'] + '</a>'+ '<br>');
							$('.friendsList').append('Available for Yahoo Cloning? : ' + checkEmailIfVuln(res['email']) + '<hr>');
						}
						
					},
					error : function(err){
						console.log(err);
						alert('An error occurred.');
					}

				});
			});
		});
		
	});
	
	function checkEmailIfYahoo(email) {
		var response = false;
		var em_provider = email.split('@'); //must be yahoo after the '@' sign
		if(typeof email === 'undefined'){
			response = false;
		}

		if(em_provider[1] == 'yahoo.com' || em_provider[1] == 'yahoo.com.ph'){
			response = true;
		}

		return response;
	}

	function checkEmailIfVuln(email) {
		var response = '';
		


		return response;
	}
</script>
</html>