<?php

/* ************************************************************************** */
/*                                                                            */
/*  handlerequest.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Aug 26 11:46:05 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

function	HandleRequest($uri, $db)
{
	if (!($tokenDB = new DataBase()))
	{
		internal_error("tokenDB set to null", __FILE__, __LINE__);
		return (false);
	}
	$tokenDB->host = "ac.cirah.com:4000";
	$tokenDB->db_name = "ac_authentication";

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
		CreateApiToken($tokenDB, $id);
		return (true);
	}
	else if ($uri->endPoint === "logout")
	{
		RemoveApiToken($tokenDB);
		return (true);
	}
	http_error(400, "Wrong endPpoint !");
}

?>
