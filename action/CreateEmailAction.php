<?php

require_once("action/CommonAction.php");
require_once("db/dbdomain.php");
require_once("db/dbtoken.php");
require_once('action/EmailPassScheme.php');

class CreateEmailAction extends CommonAction
{
	public $domain;

	public $token;

	public $domain_id=0;
	public function __construct()
	{
		$this->token = array();
		$this->domain = array();
		parent::__construct(CommonAction::$guestRank);
	}
	
	public function execute()
	{
		if(isset($_POST['femaildomain']) && isset($_POST['prefix']))
		{
			$edomain = $_POST['femaildomain'];
			$prefix = strtolower($_POST['prefix']);
		}
		else
		{
			$this->addNotification(Notification::$Error, 'Incorrect use!', true);
			header('location: email_form.php');
			exit();
		}
	
		$edomain = $_POST['femaildomain'];
		$edomain = strtolower($edomain);
		$this->domain = DBDomain::GetDomainByName($edomain);
		
		if(count($this->domain) == 0)
		{
			$this->addNotification(Notification::$Error, 'This domain doesn\'t exists !', true);
			header('location: email_form.php');
			exit();
		}
		
		$this->domain_id = $this->domain['domain_id'];
		
		$token = strtolower($_POST['token']);
		
		$tdata = DBToken::GetToken($token);
		
		if(count($tdata) == 0)
		{
			$this->addNotification(Notification::$Error, 'Invalid token!', true);
			header('location: email_form.php');
			exit();
		}
		
		if($tdata['domain_id'] != $this->domain_id || $tdata['email_id'] != 0)
		{
			$this->addNotification(Notification::$Error, 'Invalid token!', true);
			header('location: email_form.php');
			exit();
		}
		
		if(strcmp($_POST['password'],$_POST['passwordconfirm']) != 0)
		{
			$this->addNotification(Notification::$Error, 'Password mismatch!', true);
			header('location: email_form.php');
			exit();
		}
		
		//Prefix checkup
		$prefix_pattern = '/^[_a-z0-9\.\-]+$/';
		
		if(preg_match($prefix_pattern,$prefix) == 0)
		{
			$this->addNotification(Notification::$Error, 'You can only use alphanumeric character and - (dash), _ (underscore), . (dot)', true);
			header('location: email_form.php');
			exit();
		}
		
		$password = $_POST['password'];
		$email_addr = $prefix.'@'.$edomain;
		
		//Need to verify if that email already exist
		require_once("db/dbemail.php");
		
		$edata = DBEmail::GetEmailByEmail($email_addr);
		
		if(count($edata) != 0)
		{
			$this->addNotification(Notification::$Error, $email_addr.' already exists !', true);
			header('location: email_form.php');
			exit;
		}
		
		//Password generation for DoveCot
		$hasher = new PassScheme(EMAIL_PASS_SCHEME);
		$passhash = $hasher->getString($password);
		
		DBEmail::AddEmail($email_addr, $passhash);
		
		//Token Update, +EmailId
		$edata = DBEmail::GetEmailByEmail($email_addr);
		$eid = $edata['email_id'];
		$tid = $tdata['token_id'];
		
		DBToken::UseToken($eid, $tid);
		
		
		//EMAIL CREATION HERE !
		$this->addNotification(Notification::$Success, $prefix.'@'.$edomain.' created!', true);
		header('location: email_form.php');
		
	}
}