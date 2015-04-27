<?php
require_once("db/dbconnection.php");
	
class DBUser
{
	public static function GetUserById($userid)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT user_id,username,password,email,rank,stamp FROM users WHERE user_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("i",$userid);
		
		$statement->bind_result($uid,$user,$pass,$email,$rank,$stamp);
		
		$statement->execute();
		
		$data = array();
		
		if($statement->fetch())
		{
			$data = DBUser::FillUser($uid,$user,$pass,$email,$rank,$stamp);
		}
		
		Connection::releaseConnection($connection);
		return $data;
	}
	
	public static function ChangePassword($userid, $newpass)
	{
		$connection = Connection::getConnection();
		
		$query = "UPDATE users SET password = ? WHERE user_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("si",$newpass,$userid);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}

	public static function UpdateRank($userid, $newrank)
	{
		$connection = Connection::getConnection();
		
		$query = "UPDATE users SET rank = ? WHERE user_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("ii", $newrank, $userid);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}

	public static function FillUser($userid,$username,$password,$email,$rank,$stamp)
	{
		$data = array(
			'user_id' => $userid,
			'username' => $username,
			'password' => $password,
			'email' => $email,
			'rank' => $rank,
			'stamp' => $stamp
		);
		
		return $data;
	}

	public static function GetAllUsers($start = 0, $count = 25)
	{
		$data = array();
		$connection = Connection::getConnection();
		
		$query = "SELECT user_id,username,password,email,rank,stamp FROM users ORDER BY user_id DESC LIMIT ?,?";
		
		$end = $start + $count;
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("ii", $start, $end);
		$statement->bind_result($userid,$username,$password,$email,$rank,$stamp);
		
		$statement->execute();
		
		while($statement->fetch())
		{
			$data[] = DBUser::FillUser($userid,$username,$password,$email,$rank,$stamp);
		}
		
		Connection::releaseConnection($connection);
	}
	
	public static function GetUserByName($username)
	{
		$username = strtolower($username);
		
		$connection = Connection::getConnection();
		
		$query = "SELECT user_id,username,password,email,rank,stamp FROM users WHERE username = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("s", $username);
		$statement->bind_result($userid,$username,$password,$email,$rank,$stamp);
		
		$statement->execute();
		$data = array();
		if($statement->fetch())
		{
			$data = DBUser::FillUser($userid,$username,$password,$email,$rank,$stamp);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}
	
	public static function AddUser($username, $password, $email, $rank = 1)
	{
		$username = strtolower($username);
		$email = strtolower($email);
		$data = DBUser::GetUserByNameOrEmail($username, $email);
		
		if(count($data) == 0)
		{
			$connection = Connection::getConnection();
			$stamp = time();
			$query = "INSERT INTO users (username,password,email,rank,stamp) VALUES(?,?,?,?,?)";
			
			$statement = $connection->prepare($query);
			
			$statement->bind_param("sssii",$username,$password,$email,$rank, $stamp);
			$statement->execute();
			
			Connection::releaseConnection($connection);
			
			return "SUCCESS";
		
		}
		else
		{
			if(strcmp($data['email'],$email) == 0)
			{
				return "EMAIL_EXIST";
			}
			else if(strcmp($data['username'],$username) == 0)
			{
				return "USER_EXIST";
			}
		}
	}
	
	public static function GetUserByNameOrEmail($username, $email)
	{
		$username = strtolower($username);
		$email = strtolower($email);
		
		$connection = Connection::getConnection();
		
		$query = "SELECT user_id,username,password,email,rank,stamp FROM users WHERE username = ? OR email = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("ss", $username, $email);
		$statement->bind_result($userid,$username,$password,$email,$rank,$stamp);
		
		$statement->execute();
		$data = array();
		if($statement->fetch())
		{
			$data = DBUser::FillUser($userid,$username,$password,$email,$rank,$stamp);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
		
	}
}