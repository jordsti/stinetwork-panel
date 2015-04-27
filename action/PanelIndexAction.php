<?php
require_once('action/CommonAction.php');
require_once('db/dbproject.php');
require_once('db/dbdomain.php');

class PanelIndexAction extends CommonAction
{
	public $projects;
	public $domains;

	public function __construct()
	{
		parent::__construct();
		$this->projects = array();
		$this->domains = array();
	}
	
	public function execute()
	{
		$this->pagename = 'Panel';
		$this->title = 'Panel';
		
		if($this->isAdmin())
		{
			$this->projects = DBProject::GetProjects();
			$this->domains = DBDomain::GetDomains();
		}
		else if($this->isProjectAdmin())
		{
			$this->projects = DBProject::GetProjectByUser($this->user_id);
			if(count($this->projects) != 0)
			{
				$this->domains = DBDomain::GetDomainByProject($this->projects['project_id']);
			}
		}
	}
}