<?php

require_once("action/CommonAction.php");
require_once("db/dbdomain.php");
require_once("db/dbproject.php");
require_once("db/dbtoken.php");

class PanelEditDomainAction extends CommonAction
{
	public $domain;
	public $project;
	public $tokens;
	public $project_id=0;
	public $domain_id=0;
	public function __construct()
	{
		$this->tokens = array();
		$this->project = array();
		$this->domain = array();
		parent::__construct(CommonAction::$projectAdmin);
	}
	
	public function execute()
	{
		if(isset($_GET['did']))
		{
			$this->domain_id = $_GET['did'];
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
			$this->domain = DBDomain::GetDomainById($this->domain_id);
			$this->tokens = DBToken::GetTokenByDomain($this->domain_id);

			if(count($this->domain) == 0)
			{
				$this->addNotification(Notification::$Error, 'No domain found!',true);
				header('location: panel.php');
				exit();
			}
			else if($this->domain['project_id'] != $this->project_id)
			{
				$this->addNotification(Notification::$Error, 'Invalid domain!',true);
				header('location: panel.php');
				exit();
			}
		}
	}
}