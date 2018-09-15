<?php

/* ************************************************************************** */
/*                                                                            */
/*  handlerequest.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Sep 16 00:39:58 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

function	HandleRequest($uri, $db)
{
	if (!($tokenDB = new DataBase()))
	{
		internal_error("tokenDB set to null", __FILE__, __LINE__);
		return (false);
	}

	$tokenDB->host = Config::Getinstance()->authHost;
	$tokenDB->dbName = Config::GetInstance()->authDBName;

	if (!$uri)
	{
		internal_error("uri set to null",
						__FILE__, __LINE__);
		return (false);
	}

	if ($uri->endPoint === "login")
	{
		if (($id = IsGoodCredentials($db, Config::GetInstance()->userTable)) < 0)
			return ;
		CreateApiToken($tokenDB, $id);
		return (true);
	}
	else if ($uri->endPoint === "logout")
	{
		if (RemoveApiToken($tokenDB))
			return (true);
		http_error(400, "Log out failed!");
		return (false);
	}
	http_error(400, "Wrong endPpoint !");
}

?>
