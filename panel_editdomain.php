<?php
require_once("action/PanelEditDomainAction.php");

$action = new PanelEditDomainAction();

$action->execute();

require_once("header.php");
?>
<div class="midcontainer container-fluid">

	<h3>Edit domain<h3>
	<h3><?php echo $action->domain['domain']; ?></h3>
	<h4>Email token<h4>
	<form class="form-inline" method="post" action="panel_createtoken.php">
		<label>Create</label> <input type="text" name="nbtokens" id="nbtokens" value="25"> <label>tokens</label>
		<input type="hidden" name="domainid" value="<?php echo $action->domain_id; ?>">
		<button type="submit" class="btn">Go!</button>
	</form>
	<h5>Existing token(s)</h5>
	<?php
	if(count($action->tokens) == 0)
	{
	?>
	<h6>None!</h6>
	<?php
	}
	else
	{
	?>
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="span2">Id</div>
			<div class="span2">Is used?</div>
			<div class="span3">Token</div>
			<div class="span5">Associated Email</div>
		</div>
		<?php
			foreach($action->tokens as $t)
			{
				$use = 'Yes';
				$email = '';
				if($t['email_id'] == 0)
				{
					$use = 'No';
				}
				else
				{
					$email = $t['email'];
				}
			
			?>
			<div class="row-fluid">
				<div class="span2"><?php echo $t['token_id']; ?></div>
				<div class="span2"><?php echo $use; ?></div>
				<div class="span3"><?php echo $t['token']; ?></div>
				<div class="span5"><?php echo $email; ?></div>
			</div>
			<?php
			}
		?>
	</div>
	<?php
	}
	?>
</div>
<?php
require_once("footer.php");