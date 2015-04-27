<?php

require_once("action/CommonAction.php");
require_once("db/dbdomain.php");
require_once("db/dbproject.php");
require_once("db/dbtoken.php");

class PanelAddDomainAction extends CommonAction
{

	public $project_id=0;
	
	public function __construct()
	{
		parent::__construct(CommonAction::$projectAdmin);
	}
	
	public function execute()
	{
		if(isset($_POST['domain']))
		{
			$this->domain = $_POST['domain'];
		}
		else
		{
			$this->addNotification(Notification::$Error, 'Incorrect use!',true);
			header('location: panel.php');
			exit();
		}
		
		$this->project = DBProject::GetProjectByUser($this->user_id);
		
		if(count($this->project) == 0)
		{
			//No project found
			$this->addNotification(Notification::$Error, 'No project found for this user!',true);
			header('location: panel.php');
			exit();
		}
		else
		{
			$this->project_id = $this->project['project_id'];

			$rs = DBDomain::AddDomain($this->domain, $this->project_id);
			
			if(strcmp($rs,"SUCCESS") != 0)
			{
				$this->addNotification(Notification::$Error, 'This domain already exist!',true);
				header('location: panel.php');
				exit();
			}
			
			$this->addNotification(Notification::$Success, $this->domain.' added !',true);
			header('location: panel.php');
			exit();
		}
	}
}