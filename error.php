<?php
	require_once('header.php');
?>

<h2>Some error(s) has occurred</h2>
	<ul>
		<?php
		foreach($action->errordata as $e)
		{
		?>
		<li><?php echo $e; ?></li>
		<?php
		}
		?>
	</ul>

<?php
	require_once('footer.php');