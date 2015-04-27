<?php

require_once("action/LoginAction.php");

$action = new LoginAction();

$action->execute();

require_once("header.php");
?>

<div class="midcontainer">
<?php require_once("login_form.php"); ?>
</div>
<?php
require_once("footer.php");
