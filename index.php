<?php

	require_once("action/IndexAction.php");
	
	$action = new IndexAction();
	
	$action->execute();
	
	require_once("header.php");
	
?>
	<div class="jumbotron">
		<h2>StiNetwork</h2>
		<p class="lead">We're hosting many projects some are public those aren't at the moment !</p>
	</div>
	
	<div class="row-fluid marketing">
		<div class="span6">
			<h4>Sti::Code</h4>
			<p>StiCode is a website for developper and programmer. They give you a free SVN repository for each of your open source project. StiCode is currently in open beta. You can sign-up and create a new project and invite some committer into it. StiCode is still in developper, so don't be surprise about changes !</p>
			<a class="btn btn-medium btn-success" href="http://www.sticode.com/">StiCode</a>
		</div>
		
		<div class="span6">
			<h4>O3 Production</h4>
			<p>Media prodution compagny. Their website is still in construction...</p>
		</div>
		
	</div>
<?php
require_once("footer.php");