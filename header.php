<!DOCTYPE html>
<html>
	<head>
		<title>StiNetwork - <?php echo $action->title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	
		<style type="text/css">
			.jumbotron {
				margin: 60px 0;
				text-align: center;
			}
			
			.marketing
			{
				width: 70%;
				margin: auto;
			}
			
			.midcontainer
			{
				width: 70%;
				margin: auto;
			}
			
			.notification-container
			{
				width: 50%;
				margin: auto;
				margin-top: 50px;
			}

		</style>
	</head>
	
	<body>
	<script src="http://code.jquery.com/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
		<div class="navbar navbar-inverse navbar-static-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="brand" href="#">StiNetwork</a>
					<ul class="nav">
						<?php
						foreach($action->menuitems as $n => $u)
						{
							if($action->pagename == $n)
							{
							?>
							<li class="active"><a href="<?php echo $u; ?>"><?php echo $n; ?></a></li>
							<?php
							}
							else
							{
							?>
							<li><a href="<?php echo $u; ?>"><?php echo $n; ?></a></li>
							<?php
							}
						}
						if($action->isLogged())
						{
						?>
							<li><a href="account_form.php">My Account</a></li>
							<li><a href="logout.php">Log Out</a></li>
						<?php
						}
						
						?>
					</ul>
				</div>
			</div>
		</div>
	<?php
		if(count($action->notifications) != 0)
		{
		?>
			<div class="notification-container">
			<?php
			foreach($action->notifications as $n)
			{
				echo $n->getHTML();
			}
			?>
			</div>
			<?php
		}
	?>