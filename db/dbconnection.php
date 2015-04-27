<?php

require_once("db/Constants.php");

class Connection
{
	public static function getConnection()
	{
		return new mysqli(DBServer, DBUser, DBPass, DBName);
	}
	
	public static function getEmailConnection()
	{
		return new mysqli(DBServer, DBEmailUser, DBEmailPass, DBEmailName);
	}
	
	public static function releaseConnection($connection)
	{
		$connection->close();
	}
}