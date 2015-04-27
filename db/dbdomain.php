<?php
require_once("db/dbconnection.php");

class DBDomain
{
	public static function GetDomainById($did)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT domain_id,domain,project_id,stamp FROM domains WHERE domain_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("i", $did);
		$statement->bind_result($did, $d, $projid, $s);
		$statement->execute();
		
		$data = array();
		
		if($statement->fetch())
		{
			$data = array(
				'domain_id' => $did,
				'domain' => $d,
				'stamp' => $s,
				'project_id' => $projid
			);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}

	public static function GetDomainByProject($projectid)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT domain_id,domain,stamp FROM domains WHERE project_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("i", $projectid);
		$statement->bind_result($did, $d, $s);
		$statement->execute();
		
		$data = array();
		
		while($statement->fetch())
		{
			$data[] = array(
				'domain_id' => $did,
				'domain' => $d,
				'stamp' => $s,
			);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}

	public static function DeleteDomain($domainid, $projectid)
	{
		$connection = Connection::getConnection();
		
		$query = "DELETE FROM domains WHERE domain_id = ? AND project_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("ii", $domainid, $projectid);
		$statement->execute();
		
		Connection::releaseConnection();
	}

	public static function AddDomain($domain, $projectid)
	{
		$data = DBDomain::GetDomainByName($domain);
		
		if(count($data) == 0)
		{
			$connection = Connection::getConnection();
			
			$query = "INSERT INTO domains (domain,project_id,stamp) VALUES(?,?,?)";
			
			$statement = $connection->prepare($query);
			$stamp = time();
			
			$statement->bind_param("sii", $domain, $projectid, $stamp);
			
			$statement->execute();
			
			Connection::releaseConnection($connection);
			
			return "SUCCESS";
		}
		
		return "DOMAIN_EXISTS";
	}
	
	public static function GetDomainByName($name)
	{
		$data = array();
		
		$connection = Connection::getConnection();
		
		$query = "SELECT domain_id,domain,project_id,stamp FROM domains WHERE domain = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("s", $name);
		$statement->bind_result($domainid, $domain, $projectid, $stamp);
		
		$statement->execute();
		
		if($statement->fetch())
		{
			$data = array(
				'domain_id' => $domainid,
				'domain' => $domain,
				'project_id' => $projectid,
				'stamp' => $stamp,
			);
		}
		
		Connection::releaseConnection($connection);
	
		return $data;
	}

	public static function GetDomains()
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT domain_id,domain,project_id,stamp FROM domains ORDER BY domain_id";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_result($domainid, $domain, $projectid, $stamp);
		
		$statement->execute();
		
		$data = array();
		
		while($statement->fetch())
		{
			$data[] = array(
				'domain_id' => $domainid,
				'domain' => $domain,
				'user_id' => $projectid,
				'stamp' => $stamp,
			);
		}
		
		Connection::releaseConnection($connection);
		return $data;
	}
}