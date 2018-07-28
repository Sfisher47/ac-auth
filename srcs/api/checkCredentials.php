<?php

/* ************************************************************************** */
/*                                                                            */
/*  checkCredentials.php                                                      */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 28 10:07:00 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function		GetUserId($conn, $tableName, $data)
{
	if (!$conn)
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (-1);
	}
	//Check if email already exists
	$query = "SELECT id FROM $tableName WHERE email=:email AND password=:password";
	try
	{
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':email', $data->email);
		$stmt->bindParam(':password', $data->password);
		$stmt->execute();
		$ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1)
		{
			return ($ret[0]['id']);
		}
	}
	catch(Exception $e)
	{
		internal_error("stmt : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (-1);
	}
	return (-1);
}

function		IsGoodCredentials($db, $tableName)
{
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
		$data = json_decode('{
								"email" : "bmbarga@email.com",
								"password" : "password"
							}');
	}

	if (!$data)
	{
		internal_error("data set to null", __FILE__, __LINE__);
		return(-1);
	}
	$data = UserPostUtilities::SanitizeData($data);

	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (-1);
	}

	if (($id = GetUserId($conn, $tableName, $data)) < 0)
	{
		http_error(400, 'Wrong credentials');
		return (-1);
	}
	return ($id);
}

?>
