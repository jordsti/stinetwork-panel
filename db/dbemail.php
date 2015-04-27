<?php
require_once("db/dbconnection.php");


class DBEmail
{

	public static function ChangePassword($emailid, $password)
	{
		$connection = Connection::getConnection();
		
		$query = "UPDATE emails SET password = ? WHERE email_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param('si',$password, $emailid);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}

	public static function RemoveEmail($emailid)
	{
		$connection = Connection::getConnection();
		
		$query = "DELETE FROM emails WHERE email_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("i",$emailid);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}

	public static function AddEmail($email,$password)
	{
		$connection = Connection::getConnection();
		
		$query = "INSERT INTO emails (email,password) VALUES (?,?)";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("ss",$email,$password);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}
	
	public static function GetEmailByEmail($email)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT email_id,email,password FROM emails WHERE email = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("s", $email);
		
		$statement->bind_result($id,$aemail,$pass);
		
		$statement->execute();
		
		$data = array();
		
		if($statement->fetch())
		{
			$data = array(
				'email_id' => $id,
				'email' => $email,
				'password' => $pass
			);
		}
		
		Connection::releaseConnection($connection);
		return $data;
	}
}