
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
	</style>
</head>
<body>
	<center>
		<h1>Title Goes Here</h1>
	  	<div class="alert alert-success">
	    	<strong>Success!</strong> You are now logged in successfully. Please wait.
	  	</div>
	  	<div class="alert alert-warning">
	    	<strong>Error!</strong> Please allow the app in order to use this application.
	  	</div>
	  	<div class="alert alert-danger">
	    	<strong>Error!</strong> Login cancelled by the user.
	  	</div>
		<div class="container">
			<button type="button" class="btn btn-outline-primary waves-effect" id="facebook_login"><i class="fab fa-facebook-square"></i>&nbsp;Login with Facebook</button>
			<input type="text" name="access_token" value="">
		</div>
	</center>
</body>
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '390782491641022',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v4.0'
    });
  };
</script>
<script type="text/javascript">
  $('#facebook_login').click( () => {

  	FB.login( (response) => {
  		console.log(response);
  	});

  	$('button').prop('disabled', true);
  	$('button').html('<span class="spinner-grow spinner-grow-sm"></span> Logging you in...');

  });
</script>
</html>