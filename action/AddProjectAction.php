<?php
require_once("action/CommonAction.php");
require_once("db/dbuser.php");
require_once("db/dbproject.php");
require_once("db/dbdomain.php");

class AddProjectAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct(CommonAction::$adminRank);
	}
	
	public function execute()
	{
		$username = strtolower($_POST['username']);
		$domain = strtolower($_POST['domain']);
		$projname = $_POST['projname'];
		$email = strtolower($_POST['email']);
		$str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789";
		
		$u = DBUser::GetUserByName($username);
		
		if(count($u) != 0)
		{
			$n = new Notification();
			$n->type = Notification::$Error;
			$n->message = 'This user already exists !';
			$this->notifications[] = $n;
			$_SESSION['notifications'] = array($n);
			header('location: panel.php');
			exit();
		}
		
		
		$pass = str_shuffle($str);
		//send this password
		$pass = substr($pass,0,12);
		$hpass = sha1($pass);
		
		$rs = DBUser::AddUser($username, $hpass, $email, CommonAction::$projectAdmin);
		
		if(strcmp($rs, 'SUCCESS') != 0)
		{			
			$n = new Notification();
			$n->type = Notification::$Error;
			$n->message = 'This email already exists !';
			$this->notifications[] = $n;
			$_SESSION['notifications'] = array($n);
			header('location: panel.php');
			exit();
		}
		
		$u = DBUser::GetUserByName($username);
		
		$uid = $u['user_id'];
		
		$rs = DBProject::AddProject($projname, $uid);
		
		if(strcmp($rs, 'SUCCESS') != 0)
		{			
			$n = new Notification();
			$n->type = Notification::$Error;
			$n->message = 'This project already exists !';
			$this->notifications[] = $n;
			$_SESSION['notifications'] = array($n);
			header('location: panel.php');
			exit();
		}
		
		$p = DBProject::GetProjectByName($projname);
		
		$pid = $p['project_id'];
		
		$rs = DBDomain::AddDomain($domain, $pid);
		
		if(strcmp($rs, 'SUCCESS') != 0)
		{			
			$n = new Notification();
			$n->type = Notification::$Error;
			$n->message = 'This domain already exists !';
			$this->notifications[] = $n;
			$_SESSION['notifications'] = array($n);
			header('location: panel.php');
			exit();
		}
		
		if(SENDMAIL)
		{
			$txtmsg = 'Hi, '.$username.'\r\n'.
					  'a new account has been created for your project : '.$projname.'\r\n'.
					  'on stinetwork.info .\r\n'.
					  'You have been assigned has a project manager for this project.\r\n'.
					  'Username: '.$username.'\r\n'.
					  'Password: '.$pass.'\r\n'.
					  'http://www.stinetwork.info \r\n';
			$htmlmsg = str_replace('\r\n','<br>', $txtmsg);	
		
			$form = 'no-reply@stinetwork.info';
			$to = $email;
			
			require_once("phpmailer/class.phpmailer.php");
			
			$mailer = new PHPMailer(false);
			
			$mailer->IsSMTP();
			
			$mailer->Host = 'localhost';
			$mailer->Port = 587;
			
			$mailer->SetFrom($form, 'StiNetwork');
			$mailer->AddAddress($to, $username);
			$mailer->Subject = 'StiNetwork account creation';
			$mailer->AltBody = $txtmsg;
			$mailer->MsgHTML($htmlmsg);
			
			$mailer->Send();
			
			//Send a email
		}
		else
		{
			$fp = fopen('email.txt', 'w');
			fwrite($fp, $pass);
			fclose($fp);
		}
		
		$n = new Notification();
		$n->type = Notification::$Success;
		$n->message = 'Project created with success!';

		$_SESSION['notifications'] = array($n);
		header('location: panel.php');
		exit();
	}
}