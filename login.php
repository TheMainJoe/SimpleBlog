<!DOCTYPE html>
<html>
<head>
	<title>Blog</title>
	<link rel="stylesheet" href="/css/bootstrap.css">
</head>
<body>

	<div class="container">
		<div class="row">
			<div class="col-xs-6">
				<h2>Blog</h2>
			</div>						
		</div>

		<div class="row">

			<div class="col-xs-2">
				<ul class="list-group">
					<li class="list-group-item"><a href="/home">HOME</a></li>
					<li class="list-group-item"><a href="/post/create">New Post</a></li>					
				</ul>
			</div>
			
			<div class="col-xs-10">
				<h3>Login</h3>
				<form class="form-horizontal" role="form">
				  <div class="form-group">
				    <label for="InputUsername" class="col-sm-2 control-label">Username</label>
				    <div class="col-sm-10">
				      <input type="text" name="username" class="form-control" id="InputUsername" placeholder="Username">
				    </div>
				  </div>

				  <div class="form-group">
				    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				    <div class="col-sm-10">
				      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
				    </div>
				  </div>
				  
				  <div class="form-group">
				    <div class="col-sm-offset-2 col-sm-10">
				      <a class="btn btn-success login">Login</a>
				      <a href="/register" class="btn btn-default">Register</a>
				      <a href="/home" class="btn btn-default">Cancel</a>
				    </div>
				  </div>
				</form>
			</div>

		</div>

	</div>

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script>
		$(document).ready(function(e){					
			$(".login").click(function(){
				var frm = $("form").serialize();
				$.post("/process/func.php",frm+"&action=login",function(returned){
					if(returned == "good")
					{
						window.location.href = "/home";
					}
				},'json');
			});
		});
	</script>
</body>
</html>