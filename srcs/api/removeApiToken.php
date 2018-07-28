<?php

/* ************************************************************************** */
/*                                                                            */
/*  removeApiToken.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 28 19:01:18 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function RemoveTokenFromDB($conn, $tableName, $token)
{
	$query = "DELETE FROM $tableName WHERE token='$token'";

	try
	{
		$stmt = $conn->prepare($query);
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

function RemoveApiToken($db)
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

	if (!$GLOBALS['ac_script'])
	{
		$data = json_decode(file_get_contents("php://input"));
		if (!$data)
		{
			internal_error("data set to null", __FILE__, __LINE__);
			http_error(204); //No Content
			return (-1);
		}
	}
	else
	{
		$data = json_decode('{"token":"1f3958b8357deaac420a2961cfa04d69d10201f3"}');
	}

	print_r($data);
	if (!$data)
	{
		internal_error("data set to null", __FILE__, __LINE__);
		return(-1);
	}
	$data->token = htmlspecialchars(strip_tags(($data->token)));
	RemoveTokenFromDB($conn, 'tokens', $data->token);
	return (true);
}

?>
