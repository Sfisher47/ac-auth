<?php

/* ************************************************************************** */
/*                                                                            */
/*  Config.class.php                                                          */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Sun Sep 16 00:16:47 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

	class		Config
	{
		public static		$verbose = false;

		public				$authHost = 'localhost'; // Default
		public				$apiHost = 'localhost'; // Default
		public				$dbUserName = 'root'; // Default
		public				$dbPassword = 'test'; // Default
		public				$apiDBName = 'actions_citoyennes'; // Default
		public				$authDBName = 'ac_authentication'; // Default
		public				$userTable = "Users"; // Default
		public				$tokenTable = "tokens"; // Default
		public				$tokenLength = 20; // Default
		public				$testApiKey = 'test'; // Default

		public				$methods = [
			'post',
		];

		public				$endPoints = [
			'login',
			'logout',
		];

		private static		$instance = null;
		public				$errorLogFileName = "./logs/error.log";
		public				$configFileName = "./config.json";

		private function		initConfigData()
		{
			$data = json_decode(file_get_contents($this->configFileName));
			$this->authHost = $data->authHost;
			$this->apiHost = $data->apiHost;
			$this->dbUserName = $data->dbUserName;
			$this->dbPassword = $data->dbPassword;
			$this->apiDBName = $data->apiDBName;
			$this->authDBName = $data->authDBName;
			$this->testApiKey = $data->testApiKey;
			$this->userTable = $data->userTable;
			$this->tokenTable = $data->tokenTable;
			$this->tokenLength = $data->tokenLength;
		}

		//constructor
		private function		__construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
			$this->initConfigData();
		}

		public static function			GetInstance()
		{
			if (Config::$instance === null)
			{
				if (!(Config::$instance = new Config()))
				{
					internal_error("Config::instance construction failed !",
						__FILE__, __LINE__);
					return (null);
				}
			}
			return (Config::$instance);
		}

		//destructor
		public function		__destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " desctructor called !" . PHP_EOL;
			}
		}
	};

?>
