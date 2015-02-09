<?php
	session_start();
?>
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
			<?php if(!isset($_SESSION['username'])): ?>
			<div class="col-xs-6 pull-right">
				<form class="form-inline" role="form">
				  <div class="form-group">
				    <label class="sr-only" for="InputUsername">Username</label>
				    <input type="text" name="username" class="form-control" id="InputUsername" placeholder="Username">
				  </div>
				  
				  <div class="form-group">
				    <label class="sr-only" for="InputPassword">Password</label>
				    <input type="password" name="password" class="form-control" id="InputPassword" placeholder="Password">
				  </div>
				  
				  <a class="btn btn-info login">Log in</a>
				  <a href="register" class="btn btn-default">Register</a>
				</form>
			</div>
			<?php else: ?>
				Welcome: <span><?=$_SESSION['username']?></span> <a href="/logout" class="btn btn-danger pull-right">Logout</a>
			<?php endif; ?>
		</div>

		<div class="row">

			<div class="col-xs-2">
				<ul class="list-group">
					<li class="list-group-item"><a href="/home">HOME</a></li>
					<li class="list-group-item"><a href="/post/create">New Post</a></li>					
				</ul>
			</div>
			
			<div class="col-xs-10">	
				<h3>Home</h3>
				<div id="posts">
					
				</div>
			</div>

		</div>

	</div>

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script>
		$(document).ready(function(e){
			
			var data = new Object;
			data.action = "home";

			$.post("/process/func.php",data,function(returned){
				$.each(returned,function(ind, val){
					if(val.title == "Nothing")
					{
						$("#posts").html("<h1>"+val.body+"</h1>");
					}
					else
					{
						$("#posts").append("<h3>"+val.title+"</h3><p>"+val.post+"</p>");
					}
				})
			},'json');
						
			$(".login").click(function(){
				var frm = $("form").serialize();
				$.post("/process/func.php",frm+"&action=login",function(returned){
					if(returned == "good")
					{
						window.location.href = "index.php";
					}
				},'json');
			});
		});
	</script>
</body>
</html>