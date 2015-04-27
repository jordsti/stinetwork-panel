<?php
	require_once("action/EmailFormAction.php");

	$action = new EmailFormAction();
	
	$action->execute();
	
	require_once("header.php");
?>
	<p class="lead">We are giving free email address to our hosted projects !</p>
	<div class="container-fluid">
	<script src="js/email.js"></script>
		<div class="row-fluid">
			<div class="span3">
				<p>You need a token to create a new email address, each token are specific to a domain.</p>
				<h4>Server Information</h4>
				<h5>Inbounds</h5>
				<ul>
					<li><strong>IMAP</strong></li>
					<li>Host : mail.sticode.com</li>
					<li>Post : 993</li>
					<li>User : name@domain.tld</li>
					<li>Security : SSL </li>
				</ul>
				<h5>Outbounds</h5>
				<ul>
					<li><strong>SMTP</strong></li>
					<li>Host : mail.sticode.com</li>
					<li>Post : 587</li>
					<li>User : name@domain.tld</li>
					<li><strong>Authentication required</strong></li>
					<li>Security : SSL </li>
				</ul>
			</div>
			
			<div class="span7">
				<form method="post" action="create_email.php">
					<fieldset>
						<input type="hidden" name="femaildomain" id="femaildomain" value="">
						<legend>Email Creation</legend>
						<label>Email Address</label>
						<div class="input-append">
							<input class="span8" id="appendedDropdownButton" type="text" name="prefix">
							<div class="btn-group">
							 <button name="emaildomain" id="emaildomain" class="btn dropdown-toggle" data-toggle="dropdown">
								@domain.tld
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
							<?php
							foreach($action->domains as $d)
							{
							?>
								<li><a onclick="selectEmailDomain('emaildomain','<?php echo $d['domain']; ?>');"><?php echo $d['domain']; ?></a></li>
							<?php
							}
							?>
							</ul>
							</div>
						</div>
						<label>Password</label>
						<input type="password" name="password">
						<label>Password (Confirm)</label>
						<input type="password" name="passwordconfirm">
						<label>Token</label>
						<input type="text" name="token" placeholder="16 characters code">
						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
					</fieldset>
				</form>
								<form method="post" action="change_emailpassword.php">
					<fieldset>
						<input type="hidden" id="femaildomain2" name="femaildomain2" value="">
						<legend>Change your password</legend>
						<label>Email Address</label>
						<div class="input-append">
							<input class="span8" id="appendedDropdownButton" type="text" name="prefix2">
							<div class="btn-group">
							 <button id="emaildomain2" name="emaildomain2" class="btn dropdown-toggle" data-toggle="dropdown">
								@domain.tld
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
							<?php
							foreach($action->domains as $d)
							{
							?>
								<li><a onclick="selectEmailDomain('emaildomain2','<?php echo $d['domain']; ?>');"><?php echo $d['domain']; ?></a></li>
							<?php
							}
							?>
							</ul>
							</div>
						</div>
						<label>Current Password</label>
						<input type="password" name="oldpassword">
						<label>New Password</label>
						<input type="password" name="newpassword">
						<label>New Password (Confirm)</label>
						<input type="password" name="newpasswordconfirm">
						<br>
						<div class="form-actions">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</fieldset>
				</form>
			</div>
			
		</div>
	</div>
<?php
	require_once("footer.php");