<?php

/* ************************************************************************** */
/*                                                                            */
/*  handlerequest.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sat Jul 28 13:27:08 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function	HandleRequest($uri, $db)
{
	if (!$uri)
	{
		internal_error("uri set to null",
						__FILE__, __LINE__);
		return (false);
	}

	if ($uri->endPoint === "login")
	{
		if (($id = IsGoodCredentials($db, Config::$table)) < 0)
			return ;
		$tokenDB = new DataBase();
		$tokenDB->db_name = "ac_authentication";
		CreateApiToken($tokenDB, $id);
		return (true);
	}
	else if ($uri->endPoint === "logout")
	{
		http_error(400, "Work in progress !");
		return (true);
	}
	http_error(400, "Wrong endPpoint !");
}

?>
