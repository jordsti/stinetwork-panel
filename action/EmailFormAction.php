<?php
	require_once("action/CommonAction.php");
	require_once("db/dbdomain.php");
	
class EmailFormAction extends CommonAction
{
	public $domains;

	public function __construct()
	{
		parent::__construct();
	}
	
	public function execute()
	{
		$this->domains = DBDomain::GetDomains();
		
		$this->pagename = 'Email';
		$this->title = 'Email';
	}
}