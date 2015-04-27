<?php
require_once("action/CommonAction.php");
require_once("db/dbuser.php");

class AccountChangePasswordAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct(CommonAction::$userRank);
	}
	
	public function execute()
	{
		if(isset($_POST['curpassword']) &&
			isset($_POST['newpassword']) &&
			isset($_POST['newpasswordconfirm']) )
		{
			$curpass = $_POST['curpassword'];
			$newpass = $_POST['newpassword'];
			$newpassconfirm = $_POST['newpasswordconfirm'];
		}
		else
		{
			$this->addNotification(Notification::$Error, 'Incorrect use !', true);
			header('location: account_form.php');
			exit();
		}
		
		$udata = DBUser::GetUserById($this->user_id);
		
		if(count($udata) == 0)
		{
			$this->addNotification(Notification::$Error, 'Incorrect use !', true);
			header('location: account_form.php');
			exit();
		}
		
		$curpass = sha1($curpass);
		
		if(strcmp($curpass, $udata['password']) != 0)
		{
			$this->addNotification(Notification::$Error, 'Invalid password', true);
			header('location: account_form.php');
			exit();
		}

		
		if(strcmp($newpass,$newpassconfirm) != 0)
		{
			$this->addNotification(Notification::$Error, 'Password mismatch !', true);
			header('location: account_form.php');
			exit();
		}
		
		$newpass = sha1($newpass);
		
		DBUser::ChangePassword($this->user_id, $newpass);
		
		$this->addNotification(Notification::$Success, 'Password changed !', true);
		header('location: account_form.php');
		
	}
}