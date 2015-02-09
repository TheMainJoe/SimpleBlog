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
				    <label class="sr-only" for="exampleInputEmail2">Username</label>
				    <input type="text" name="username" class="form-control" id="exampleInputEmail2" placeholder="Username">
				  </div>
				  
				  <div class="form-group">
				    <label class="sr-only" for="exampleInputPassword2">Password</label>
				    <input type="password" name="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
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
				<h3>Post</h3>
				<div id="posts" style="display:none;">
					
				</div>

				<div id="create" style="display:none;">
					<h3>New Post</h3>				
					<form class="new">
					  <div class="form-group">				    
					    <input type="text" class="form-control" name="title" placeholder="Enter Title">
					  </div>			  				    
					  <textarea class="form-control" name="post" rows="5"></textarea>				  
					  				  
					  <a class="btn btn-default add">Submit</a>
					</form>
				</div>

				<div id="edit" style="display:none;">
					<h3>Edit Post</h3>				
					<form class="changed">
					  <div class="form-group">				    
					    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title">
					  </div>			  				    
					  <textarea class="form-control" name="post" id="post" rows="5"></textarea>				  
					  <input type="hidden" name="pid" value="<?=$_GET['pid']?>">
					  <input type="hidden" name="action" value="editPost">				  
					  <a class="btn btn-default edit">Submit</a>
					</form>
				</div>
				<?php if(!isset($_SESSION['username'])): ?>
					<a href="/login" class="btn btn-info ePost" style="display:none">Edit Post</a>
				<?php else: ?>
					<a href="/post/<?=$_GET['pid']?>/edit" class="btn btn-info ePost" style="display:none">Edit Post</a>
				<?php endif; ?>	
				
			</div>

		</div>

	</div>

	<script src="/js/jquery.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script>
		$(document).ready(function(e){
			<?php if( isset($_GET['pa']) == "create" ): ?>
				<?php if( isset($_SESSION['username']) ){ ?>
					$("#create").show();
				<?php }else{ header("Location:/login"); } ?>
			
			<?php elseif ( isset($_GET['pae']) == "edit" ): ?>								
				post();
				$("#edit").show();
			<?php elseif ( isset($_GET['pid']) ): ?>
				$("#posts").show();
				post();
				$(".ePost").show();
			<?php endif; ?>

			function post(){
				var data = new Object;
				data.action = "viewPost";
				data.pid = "<?=$_GET['pid']?>";
				
				$.post("/process/func.php",data,function(returned){					
					console.log(returned);
					$.each(returned,function(ind, val){
						if(val.title == "Nothing")
						{
							$("#posts").html("<h1>"+val.body+"</h1>");
						}
						else
						{		
							<?php if ( isset($_GET['pae']) == "edit" ): ?>
								$("#title").val(val.title);
								$("#post").val(val.body);
							<?php endif; ?>				
							$("#posts").append("<h3>"+val.title+"</h3><p>"+val.body+"</p>");
						}
					})
				},'json');
			}
						
			$(".login").click(function(){
				var frm = $("form").serialize();
				$.post("/process/func.php",frm+"&action=login",function(returned){					
					console.log(returned);
					if(returned == "good")
					{
						window.location.href = "/home";
					}
				},'json');
			});

			$(document).on("click",".add",function(){
				var frm = $(".new").serialize();
				$.post("/process/func.php",frm+"&action=addPost",function(ret){
					window.location.href = "/home";
				},'json');
			});

			$(document).on("click",".edit",function(){
				var frm = $(".changed").serialize();				
				$.post("/process/func.php",frm,function(ret){
					location.reload();
				},'json');
			});

		});
	</script>
</body>
</html>