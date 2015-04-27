<?php

require_once("db/dbconnection.php");

class DBToken
{
	public static function UseToken($emailid, $tokenid)
	{
		$connection = Connection::getConnection();
		$query = "UPDATE tokens SET email_id = ? WHERE token_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param('ii',$emailid,$tokenid);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}

	public static function GetTokenByDomain($did)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT t.token_id,t.domain_id,d.domain,t.token,t.email_id,e.email,t.stamp FROM tokens t LEFT JOIN emails e ON(e.email_id = t.email_id) INNER JOIN domains d ON(d.domain_id=t.domain_id) WHERE t.domain_id = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("i", $did);
		$statement->bind_result($tid,$did,$domain,$token,$eid,$email,$stamp);
		
		$statement->execute();
		$data = array();
		while($statement->fetch())
		{
			$data[] = array(
				'token_id' => $tid,
				'domain_id' => $did,
				'domain' => $domain,
				'email_id' => $eid,
				'token' => $token,
				'stamp' => $stamp,
				'email' => $email
			);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}

	public static function CreateToken($did, $nb = 50)
	{
		$charset = 'QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890';
		$i = 0;
		while($i < $nb)
		{
			$str = str_shuffle($charset);
			
			$istart = rand(0, strlen($str) - 16);
			
			$str = substr($str, $istart, 16);

			$t = DBToken::GetToken($str);
			
			if(count($t) == 0)
			{
				DBToken::AddToken($did, $str);
				$i++;
			}
			
		}
	}
	
	public static function GetToken($token)
	{
		$connection = Connection::getConnection();
		
		$query = "SELECT t.token_id,t.domain_id,d.domain,t.email_id,t.stamp FROM tokens t INNER JOIN domains d ON(d.domain_id=t.domain_id) WHERE t.token = ?";
		
		$statement = $connection->prepare($query);
		
		$statement->bind_param("s", $token);
		$statement->bind_result($tid,$did,$domain,$eid,$stamp);
		
		$statement->execute();
		$data = array();
		if($statement->fetch())
		{
			$data = array(
				'token_id' => $tid,
				'domain_id' => $did,
				'domain' => $domain,
				'email_id' => $eid,
				'stamp' => $stamp
			);
		}
		
		Connection::releaseConnection($connection);
		
		return $data;
	}
	
	public static function AddToken($did, $token)
	{
		$connection = Connection::getConnection();
		
		$query = "INSERT INTO tokens (domain_id,token,email_id,stamp) VALUES(?,?,0,?)";
		
		$statement = $connection->prepare($query);
		
		$stamp = time();
		
		$statement->bind_param("isi",$did,$token,$stamp);
		
		$statement->execute();
		
		Connection::releaseConnection($connection);
	}
}