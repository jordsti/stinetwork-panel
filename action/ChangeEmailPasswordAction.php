<?php
require_once("action/CommonAction.php");
require_once("db/dbemail.php");
require_once('action/EmailPassScheme.php');

class ChangeEmailPasswordAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct(CommonAction::$guestRank);
	}
	
	public function incorrectUse()
	{
		$this->addNotification(Notification::$Error, 'Incorrect use !', true);
		header('location: email_form.php');
		exit();
	}
	
	public function execute()
	{
		if(isset($_POST['femaildomain2']))
		{
			$edomain = strtolower($_POST['femaildomain2']);
		}
		else
		{
			$this->incorrectUse();
		}
		
		if(isset($_POST['prefix2']))
		{
			$prefix = strtolower($_POST['prefix2']);
		}
		else
		{
			$this->incorrectUse();
		}
		
		$oldpass = '';
		$newpass = '';
		
		if(isset($_POST['oldpassword']) && isset($_POST['newpassword']))
		{
			$oldpass = $_POST['oldpassword'];
			$newpass = $_POST['newpassword'];
		}
		else
		{
			$this->incorrectUse();
		}
		
		if(strcmp($_POST['newpassword'],$_POST['newpasswordconfirm']) != 0)
		{
			$this->addNotification(Notification::$Error, 'Password mismatch !', true);
			header('location: email_form.php');
			exit();
		}
		
		$email_addr = strtolower($prefix.'@'.$edomain);
		
		$edata = DBEmail::GetEmailByEmail($email_addr);
		
		if(count($edata) == 0)
		{
			$this->addNotification(Notification::$Error, 'Invalid email address !', true);
			header('location: email_form.php');
			exit();
		}
		
		$oldpasshash = $edata['password'];
		
		$hasher = new PassScheme(EMAIL_PASS_SCHEME);
		$oldpass = $hasher->getString($oldpass);
		
		if(strcmp($oldpass,$oldpasshash) != 0)
		{
			$this->addNotification(Notification::$Error, 'Incorrect password', true);
			header('location: email_form.php');
			exit();
		}
		
		$newpass = $hasher->getString($newpass);
		
		DBEmail::ChangePassword($edata['email_id'], $newpass);
		
		$this->addNotification(Notification::$Success, $email_addr.' password changed with success !', true);
		header('location: email_form.php');

	}
}