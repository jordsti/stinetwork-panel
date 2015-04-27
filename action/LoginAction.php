<?php
require_once("action/CommonAction.php");
require_once("db/dbuser.php");

class LoginAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct();
		
		if($this->isLogged())
		{
			if(isset($_SESSION['redirect']))
			{
				header('location: /'.$_SESSION['redirect']);
				exit;
			}
			else
			{
				header('location: index.php');
				exit;
			}
		}
	}
	
	public function execute()
	{
		$username = strtolower($_POST['username']);
		$password = sha1($_POST['password']);
		
		$u = DBUser::GetUserByName($username);
		
		if(count($u) != 0)
		{
			if(strcmp($password, $u['password']) == 0)
			{
				$n = new Notification();
				$n->type = Notification::$Success;
				$n->message = 'Welcome '.$u['username'].'!';
				$notification = array($n);
				$_SESSION['notifications'] = $notification;
				
				$_SESSION['urank'] = $u['rank'];
				$_SESSION['user_id'] = $u['user_id'];
				
				if(isset($_SESSION['redirect']))
				{
					header('location: '.$_SESSION['redirect']);
					exit;
				}
				else
				{
					header('location: index.php');
					exit;
				}
			}
			else
			{
				$n = new Notification();
				$n->type = Notification::$Error;
				$n->message = 'Invalid username/password combination';
				$this->notifications[] = $n;
			}
		}
		else
		{
				$n = new Notification();
				$n->type = Notification::$Error;
				$n->message = 'Invalid username/password combination';
				$this->notifications[] = $n;
		}
	}
}
