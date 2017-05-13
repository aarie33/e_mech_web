<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Selamat Datang Administrator E-Mech</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
      <a class="navbar-brand" href="#">Selamat Datang Administrator E-Mech</a>
    </div>
  </div>
</nav>
<div class="container">
	<div class="row">
    	<div class="col-md-4"></div>
        <div class="col-md-4">
        	<div class="panel panel-primary">
                <div class="panel-heading"><center><b>Login Administrator</b></center></div>
                <form method="post" action="<?php echo site_url('admin/loginAdmin');?>">
                <div class="panel-body">
                    <input type="text" name="username" id="username" class="form-control" required placeholder="Username" /><br>
                    <input type="password" name="password" class="form-control" required placeholder="Password" />
				</div>
                <div class="panel-footer">
                	<div class="col-md-5"></div>
                	<input type="submit" name="btnLogin" value="Login" class="btn btn-md btn-success" />
				</div>
                </form>
			</div>
		</div>
        <div class="col-md-4"></div>
	</div>
    <?php if(isset($_SESSION['ps_admin'])){ echo $_SESSION['ps_admin'];}?>
</div>

<script>
$(function(){
	$('#username').focus();
});
</script>
</body>
</html>