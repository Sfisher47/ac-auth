<?php

/* ************************************************************************** */
/*                                                                            */
/*  createApiToken.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 16:15:18 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function		DoesTokenExist($conn, $tableName, $token)
{
	//Check if password already exists
	$queryToken = "SELECT token FROM $tableName WHERE token=:token AND id=$id";
	try
	{
		$stmtToken = $conn->prepare($queryToken);
		$stmtToken->bindParam(':token', $token);
		$stmtToken->execute();
		$ret = $stmtToken->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && $ret[0]['token'] === $token)
			return true;
	}
	catch(Exception $e)
	{
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

	echo "Lengths: Bytes: $tokenLength and Hex: " . strlen($hex) . PHP_EOL; // Debug
	var_dump($hex); // Debug
// 	var_dump($cstrong); // Debug
// 	echo PHP_EOL; // Debug
	return $hex;
}

function		StoreToken()
{
	echo __FUNCTION__ . PHP_EOL; // Debug
}

function		CreateApiToken($db)
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
		echo "Token exists already !" . PHP_EOL; // Debug
		return ;
	}
	echo "Token does not exists already !" . PHP_EOL; // Debug
	StoreToken();


	//check if token exist
	echo __FUNCTION__ . PHP_EOL; // Debug
}

?>
