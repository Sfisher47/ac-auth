<?php

/* ************************************************************************** */
/*                                                                            */
/*  checkCredentials.php                                                      */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 15:02:49 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function		DoesPasswordMatch($conn, $data, $tableName, $id)
{
	//Check if password already exists
	$queryPassword = "SELECT password FROM $tableName WHERE password=:password AND id=$id";
	try
	{
		$stmtPassword = $conn->prepare($queryPassword);
		$stmtPassword->bindParam(':password', $data->password);
		$stmtPassword->execute();
		$ret = $stmtPassword->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && $ret[0]['password'] === $data->password)
			return true;
	}
	catch(Exception $e)
	{
		internal_error("stmtPassword : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (false);
	}
	return (false);
}

function		DoesMailExist($conn, $data, $tableName)
{
	//Check if email already exists
	$queryEmail = "SELECT email FROM $tableName WHERE email=:email";
	try
	{
		$stmtEmail = $conn->prepare($queryEmail);
		$stmtEmail->bindParam(':email', $data->email);
		$stmtEmail->execute();
		$ret = $stmtEmail->fetchAll(PDO::FETCH_ASSOC);
		if (count($ret) === 1 && $ret[0]['email'] === $data->email)
			return true;
	}
	catch(Exception $e)
	{
		internal_error("stmtEmail : " . $e->getMessage(),
					__FILE__, __LINE__);
		return (false);
	}
	return (false);
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
								"email" : "elhmn@email.com",
								"password" : "password"
							}');
	}

	if (!$data)
	{
		internal_error("data set to null", __FILE__, __LINE__);
		return(false);
	}
	$data = UserPostUtilities::SanitizeData($data);

	if (!($conn = $db->Connect()))
	{
		internal_error("conn set to null", __FILE__, __LINE__);
		return (false);
	}

	if (!($id = DoesMailExist($conn, $data, $tableName))
		|| !DoesPasswordMatch($conn, $data, $tableName, $id))
	{
		http_error(400, 'Wrong credentials');
		return false;
	}
	return true;
}

?>
