<?php
class PassScheme
{
	public $mode;

	public function __construct($mode)
	{
		$this->mode = $mode;
	}
	
	public function getString($password)
	{
		if(strcmp($this->mode, 'sha256') == 0)
		{
			$hasher = new Sha256PassScheme();
			return $hasher->getPassString($password);
		}
	}
}


abstract class EmailPassScheme
{
	public function __construct()
	{

	}
	
	abstract public function getPassString($password);
}


class Sha256PassScheme extends EmailPassScheme
{

	public function getPassString($password)
	{
		$hash = hash('sha256', $password);
		
		$dbstr = '{SHA256.HEX}'.$hash;
		
		return $dbstr;
	}
}