<?php

require_once("db/dbconnection.php");


class DBProject
{
	public static function GetProjectByUser($userid)
	{
		$data = array();
		// FillProject($projid, $projname, $userid, $desc, $url, $stamp, $username = '')
		
		$connection = Connection::getConnection();
		
		$query = "SELECT project_id,user_id,projname,description,url,stamp FROM projects WHERE user_id = ?";
		
		$statement = $connection->prepare($query);
		$statement->bind_param("i", $userid);
		$statement->bind_result($pid, $uid, $pname, $desc, $url, $stamp);
		$statement->execute();
		
		if($statement->fetch())
		{
			$data = DBProject::FillProject($pid, $pname, $uid, $desc, $url, $stamp);
		}
		
		Connection::releaseConnection($connection);
		return $data;
	}

	public static function GetProjects($start = 0, $count = 50)
	{
		$end = $start + $count;
		$connection = Connection::getConnection();
		
		$query = "SELECT p.project_id,p.user_id,u.username,p.projname,p.description,p.url,p.stamp FROM projects p INNER JOIN users u ON (u.user_id=p.user_id) ORDER BY project_id DESC LIMIT ?,?";
		
		$statement = $connection->prepare($query);
		$statement->bind_param("ii", $start, $end);
		$statement->bind_result($projid,$userid,$username,$projname,$desc,$url,$stamp);
		$statement->execute();
		
		$data = array();
		while($statement->fetch())
		{
			$data[] = DBProject::FillProject($projid, $projname, $userid, $desc, $url, $stamp, $username);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}

	public static function FillProject($projid, $projname, $userid, $desc, $url, $stamp, $username = '')
	{
		$data = array(
			'project_id' => $projid,
			'projname' => $projname,
			'user_id' => $userid,
			'username' => $username,
			'description' => $desc,
			'url' => $url,
			'stamp' => $stamp
		);
		
		return $data;
	}

	public static function GetProjectByName($projname)
	{
		$data = array();
		
		$connection = Connection::getConnection();
		
		$query = "SELECT p.project_id,p.user_id,u.username,p.projname,p.description,p.url,p.stamp FROM projects p INNER JOIN users u ON (u.user_id=p.user_id) WHERE projname = ?";
		
		$statement = $connection->prepare($query);
		$statement->bind_param("s", $projname);
		$statement->bind_result($projid,$userid,$username,$pname,$desc,$url,$stamp);
		$statement->execute();
		
		if($statement->fetch())
		{
			$data = DBProject::FillProject($projid, $pname, $userid, $desc, $url, $stamp, $username);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}
	
	public static function AddProject($projname, $userid)
	{
		$p = DBProject::GetProjectByName($projname);
		
		
		if(count($p) != 0)
		{
			return "PROJECT_EXISTS";
		}
		
		$connection = Connection::getConnection();
		
		$query = "INSERT INTO projects (user_id,projname,description,url,stamp) VALUES(?,?,'','',?)";
		$stamp = time();
		$statement = $connection->prepare($query);
		
		$statement->bind_param('isi',$userid, $projname, $stamp);
		$statement->execute();
		
		Connection::releaseConnection($connection);
		
		return "SUCCESS";
	}
}