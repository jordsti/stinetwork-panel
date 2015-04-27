<?php

require_once("action/PanelIndexAction.php");

$action = new PanelIndexAction();

$action->execute();

require_once("header.php");

if(!$action->isLogged())
{
?>
	<div class="midcontainer container-fluid">
		<h5>You need an account to view the panel!</h5>
		<div class="row-fluid">
			<div class="span6">
			<?php 
			$_SESSION['redirect'] = 'panel.php';
			require_once("login_form.php"); 
			?>
			</div>
		</div>
	</div>
<?php
}
else if($action->isAdmin())
{
?>
	<div class="midcontainer container-fluid">
		<div class="row-fluid">
			<div class="span10">
				<form method="post" action="panel_addproject.php">
					<fieldset>
						<legend>Add a project</legend>
						<label>Name</label>
						<input type="text" placeholder="Project name" name="projname" id="projname">
						<label>Username</label>
						<input type="text" placeholder="Project Admin" name="username" id="username">
						<label>Project Admin Email</label>
						<input type="text" placeholder="admin@domain.tld" name="email" id="email">
						<label>Domain</label>
						<input type="text" placeholder="project.tld" name="domain" id="domain">
						<span class="help-block">An email will be sent to the project admin with his credentials, a password will be generated.</span>
						<button type="submit" class="btn">Create</button>
					</fieldset>
				</form>
			</div>
		</div>
		<h4>Project(s)</h4>
		<?php
			if(count($action->projects) == 0)
			{
			?>
			<h5>No project found...</h5>
			<?php
			}
			else
			{
				foreach($action->projects as $p)
				{
				?>
				<div class="row-fluid">
					<div class="span3"><?php echo $p['projname']; ?></div>
					<div class="span2"><?php echo $p['username']; ?></div>
					<div class="span8"><?php echo $p['url']; ?></div>
				</div>
				<?php
				}
			}
			?>
		
	</div>
<?php
}
else if($action->isProjectAdmin())
{
?>
	<div class="midcontainer container-fluid">
			<div class="row-fluid">
			<div class="span10">
				<form method="post" action="panel_adddomain.php">
					<fieldset>
						<legend>Add a domain</legend>
						<label>Domain</label>
						<input type="text" placeholder="project.tld" name="domain" id="domain"><br>
						<button type="submit" class="btn">Add</button>
					</fieldset>
				</form>
			</div>
		</div>
		<div class="row-fluid">
			<h4>My domain(s)</h4>
			<?php
			if(count($action->domains) == 0)
			{
			?>
			<h5>No domain found...</h5>
			<?php
			}
			else
			{
			?>
			<ul>
				<?php
				foreach($action->domains as $d)
				{
				?>
				<li><a href="panel_editdomain.php?did=<?php echo $d['domain_id']; ?>"><?php echo $d['domain']; ?></a></li>
				<?php
				}
				?>
			</ul>
			<?php
			}
			?>
			
		</div>
	</div>
<?php
}
?>



<?php
require_once("footer.php");