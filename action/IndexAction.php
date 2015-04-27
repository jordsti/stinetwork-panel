<?php

require_once("action/CommonAction.php");


class IndexAction extends CommonAction
{
	public function __construct()
	{
		parent::__construct(CommonAction::$guestRank);
	}
	
	public function execute()
	{
	
	}
}