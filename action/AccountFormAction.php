<?php
require_once("action/CommonAction.php");


class AccountFormAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct(CommonAction::$userRank);
	}
	
	public function execute()
	{
		
	}
}