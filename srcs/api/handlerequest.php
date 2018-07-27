<?php

/* ************************************************************************** */
/*                                                                            */
/*  handlerequest.php                                                         */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 15:03:35 2018                        by bmbarga      */
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

	if (!IsGoodCredentials($db, Config::$table))
		return ;
	$tokenDB = new DataBase();
	$tokenDB->dbname = 'ac_authentication';
	CreateApiToken($tokenDB);

	echo __FUNCTION__ . PHP_EOL; // Debug
}

?>
