
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
	<style type="text/css">
		.main_content{
			/*padding-top: 20%;*/
			margin: 10% auto;
		}
		button.scan{
			border: 2px solid #007bff !important;
			border-radius: 1px !important;
		}
		button.scan:focus, button.scan:active{
			background: #007bff;
		}
		button:focus, button:active{
			box-shadow: none !important;
			outline: none !important;
			color: white;
		}
		.alert{
			width: 50%;
		}
		div.container, div.container-two{
			margin: 0 auto;
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
		@media only screen and (max-width: 600px) {
		body{
			padding-top: 20%;
		}
		  .main_content{
		  	width: 100%;
		  }
		  div.container, div.container-two{
		  	margin: 0 auto;
		  	width: 90vw;
		  }
		}
	</style>
</head>
<body onload="checkToken()">
	<a class="github-fork-ribbon" href="https://github.com/wdulpina/facebook-yahoo-checker" target="_blank" data-ribbon="Fork me on GitHub" title="Fork me on GitHub" style="position: fixed;">Fork me on GitHub</a>
	<div class="main_content">
		<h3 class="text-center">Facebook Yahoo Checker</h3>
	  	<center>
	  			<div class="alert alert-success">
	  		  		<strong>Success!</strong> You are now logged in successfully. Please wait.
	  			</div>
	  			<div class="alert alert-danger">
	  		  		<strong>Error!</strong> Login error or invalid password supplied.
	  			</div>
	  	</center>
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
			      <input class="form-check-input" type="checkbox" checked="false"> Before clicking login, make sure you read our <a href="#">terms and conditions.</a>
			    </label>
			  </div>
			  <button type="button" class="btn btn-outline-primary btn-block" id="facebook_login"><i class="fab fa-facebook-square"></i>&nbsp;Login with Facebook</button>
			<!-- </form> -->
		</div>
		<div class="container-two">
			<div class="row">
				<div class="col-6">Hi, <span class="uname badge badge-success"></span></div>
				<div class="col-6">Email: <span class="email badge badge-secondary"></span></div>
			</div>
			<div class="row">
				<div class="col-12">
					<button class="btn btn-block btn-primary" id="scan">Start Scanning</button>
					<button class="btn btn-block btn-secondary" id="logout">End Session</button>
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

	</div>
	<br><br><br>
</body>
<script>
	$('.form-check-input').prop('checked', false);
	$("#facebook_login").attr("disabled", true);
	$('.container-two').hide();
	$('.alert').hide();

	$(".form-check-input").click(function() {
	  $("#facebook_login").attr("disabled", !this.checked);
	});
	
	$('#facebook_login').click(function() {
		const u = $('#email').val();
		const p = $('#pwd').val();
		$('#facebook_login').html('<span class="spinner-grow spinner-grow-sm"></span>Logging you in..');
		$('#facebook_login').prop('disabled', true);
		$.ajax({
			method : 'POST',
			url : 'process.php',
			data : {
				u : u,
				p : p
			},
			success : function(response) {
				
				console.log(response);
				response = JSON.parse(response);
				if(response['code'] == 'ok'){
					$('.container').hide();
					$('.container-two').show();
					$('.alert-success').show();
					setTimeout(function() {
						$('.alert-success').hide();
						$('.alert-danger').hide();
					}, 2000);
					$('.uname').html(response['uname']);
					$('.email').html(response['email']);
					localStorage.setItem("accesstoken", response['access_token']);
					localStorage.setItem("name", response['name']);
					localStorage.setItem("email", response['email']);
				}else{
					$('.alert-danger').show();
					$('#facebook_login').prop('disabled', false);
					$('#facebook_login').html('<i class="fab fa-facebook-square"></i>&nbsp;Login with Facebook');
					setTimeout(function() {
						$('.alert-danger').hide();
					}, 2000);
				}
			}
		});
	})

	$('#scan').click(function() {
		$('.friendsList').html('');
		$.getJSON('cache.json', function(result) {
			$.each(result['data'], function(index, value) {
				var name = value['name'];
				$.ajax({
					method : 'GET',
					url : 'https://graph.facebook.com/'+ value['id'] +'?access_token=' + localStorage.getItem("accesstoken") + '',
					success : function(res) {
						console.log(res);
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
						location.reload();
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

	$('#logout').click(function() {
		$('#logout').html('<span class="spinner-grow spinner-grow-sm"></span>Logging you out..');
		$.ajax({
			method : 'GET',
			url : 'https://api.facebook.com/restserver.php?method=auth.expireSession&format=json&access_token=' + localStorage.getItem("accesstoken"),
			success : function(response) {
				console.log(response);
				if(response){
					localStorage.clear();
					location.reload();
				}
			}
		})
	});

	function checkToken() {
		if(window.localStorage.getItem("accesstoken") != 'undefined'){
			var token = localStorage.getItem("accesstoken");
			$('#hid').val(token);
			if(token != null){
				console.log(token);
				$('.container').hide();
				$('.container-two').show();
				$('.uname').html(window.localStorage.getItem("name"));
				$('.email').html(window.localStorage.getItem("email"));
			}
		}
	}

	function checkEmailIfVuln(email) {
		
	}
</script>
</html>