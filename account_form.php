<?php

require_once("action/AccountFormAction.php");

$action = new AccountFormAction();

$action->execute();

require_once("header.php");

?>
<div class="container-fuild">
	<div class="row-fluid">
		<div class="span3">
		</div>
		<div class="span8">
			<form method="POST" action="account_changepassword.php">
				<fieldset>
					<legend>Change account password</legend>
					<label>Current Password</label>
					<input name="curpassword" type="password">
					<label>New password</label>
					<input name="newpassword" type="password">
					<label>New password (Confirm)</label>
					<input name="newpasswordconfirm" type="password">
					<div class="form-actions">
						<button type="submit" class="btn btn-primary">Change</button>
					</div>
				</fieldset>
			
			</form>
		</div>
	</div>
</div>

<?php
require_once("footer.php");