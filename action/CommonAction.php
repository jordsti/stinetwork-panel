<?php

require_once("action/Constants.php");
require_once("action/Notification.php");

session_start();
	
class CommonAction
{
	protected static $guestRank = 0;
	protected static $userRank = 1;
	protected static $projectAdmin = 2;
	protected static $adminRank = 3;

	public $menuitems;
	public $pagename;
	public $title;
	public $rank;
	public $error;
	public $errordata;
	public $notifications;
	public $formdata;
	public $user_id;
	
	
	public function GetRanksTitle()
	{
		$title = array(
			0 => 'Guest',
			1 => 'User',
			2 => 'Project Admin',
			3 => 'Admin',
		);
		
		return $title;
	}
	
	public function isProjectAdmin()
	{
		return ($this->rank >= CommonAction::$projectAdmin);
	}
	
	public function isAdmin()
	{
		return ($this->rank >= CommonAction::$adminRank);
	}
	
	public function getFormData($key)
	{
		if(array_key_exists($key))
		{
			return $this->formdata[$key];
		}
		else
		{
			return '';
		}
	}
	
	public function addNotification($type, $text, $session = false)
	{
		$n = new Notification();
		$n->type = $type;
		$n->message = $text;
		
		if($session)
		{
			if(isset($_SESSION['notifications']) && is_array($_SESSION['notifications']))
			{
				$_SESSION['notifications'][] = $n;
			}
			else
			{
				$_SESSION['notifications'] = array($n);
			}
		}
		else
		{
			$this->notifications[] = $n;
		}
	}
	
	public function __construct($neededRank = 0)
	{
		global $menu;
		$this->error = false;
		$this->errordata = array();
		$this->menuitems = $menu;
		$this->pagename = 'Home';
		$this->title = 'Home';
		$this->notifications = array();
		$this->formdata = array();
		
		if(isset($_SESSION['urank']))
		{
			$this->rank = $_SESSION['urank'];
			$this->user_id = $_SESSION['user_id'];
		}
		else
		{
			$this->rank = CommonAction::$guestRank;
			$this->user_id = 0;
		}
		
		if(isset($_SESSION['notifications']))
		{
			foreach($_SESSION['notifications'] as $n)
			{
				$this->notifications[] = $n; 
			}
			unset($_SESSION['notifications']);
		}
		
		if($this->rank < $neededRank)
		{
			//header('location: index.php');
			$this->error = true;
			$this->errordata[] = 'Your don\'t have the right to see this page !';
			
			require_once('error.php');
			
			exit;
		}
	}
	
	public function isLogged()
	{
		if($this->rank > CommonAction::$guestRank)
		{
			return true;
		}
		
		return false;
	}
}