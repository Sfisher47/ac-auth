<?php

/* ************************************************************************** */
/*                                                                            */
/*  createApiToken.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 28 13:12:50 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function		DoesTokenExist($conn, $tableName, $token)
{
	//Check if password already exists
	$queryToken = "SELECT token FROM $tableName WHERE token='$token'";
	try
	{
		$stmtToken = $conn->prepare($queryToken);
		$stmtToken->execute();
		$ret = $stmtToken->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && $ret[0]['token'] === $token)
			return true;
	}
	catch(Exception $e)
	{
		$stmtToken->debugDumpParams();
		internal_error("stmtToken : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (false);
	}
	return (false);
}

function		GenerateToken()
{
	$bytes = openssl_random_pseudo_bytes(Config::$tokenLength, $cstrong);
	$hex   = bin2hex($bytes);
	return $hex;
}

function		StoreToken($conn, $tableName, $token, $id)
{
	if (!$conn)
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (-1);
	}
	//Check if password already exists
	$query = "INSERT INTO $tableName".
		" SET
			token = :token,
			userid = :id,
			expirationdate = CURRENT_TIMESTAMP + INTERVAL 5 DAY
		";
	try
	{
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':token', $token);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}
	catch(Exception $e)
	{
		internal_error("stmt : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (false);
	}
	return (true);
}

function		CreateApiToken($db, $id)
{
	if (!$db)
	{
		internal_error("db set to null", __FILE__, __LINE__);
		return(false);
	}
	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (false);
	}

	$token = GenerateToken();
	if (DoesTokenExist($conn, 'tokens', $token))
	{
		return (CreateApiToken($db, $id));
	}
	if (!StoreToken($conn, Config::$tokenTable, $token, $id))
	{
		http_error(400, 'Token generation failed');
		return (false);
	}
	//send token as response
	echo '{"token":"'.$token.'"}';
	return (true);
}

?>
