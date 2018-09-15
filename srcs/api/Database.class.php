<?php

/* ************************************************************************** */
/*                                                                            */
/*  Database.class.php                                                        */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created: Thu Jan 01 01:00:00 1970                        by elhmn        */
/*   Updated: Sun Sep 16 00:13:21 2018                        by elhmn        */
/*                                                                            */
/* ************************************************************************** */

	class	Database
	{
		public static		$verbose = false;

		public	$host = null;
		public	$dbName = null;
		private	$conn = null;

		public function		Init()
		{
			$this->host = Config::GetInstance()->apiHost;
			$this->dbName = Config::GetInstance()->apiDBName;
		}

		//constructors
		public function		__construct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}
			$this->Init();
		}

		//destructor
		public function		__destructor()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " destructor called !" . PHP_EOL;
			}
		}

		//connect to the database
		public function		Connect()
		{

			$dsn = 'mysql:host=' . $this->host
				. ';dbname=' . $this->dbName;
			try
			{
				$this->conn = new PDO($dsn,
								Config::GetInstance()->dbUserName,
								Config::GetInstance()->dbPassword);
				if (!$this->conn)
				{
					internal_error("this->conn set to null", __FILE__, __LINE__);

					http_error(400,
						"Connection : failed : db = [{$this->dbName}]"
						." : host - [{$this->host}]"); // Debug
					return (null);
				}
				$this->conn->setAttribute(PDO::ATTR_ERRMODE,
					PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				internal_error("Connection : {$e->getMessage()}", __FILE__, __LINE__);
				http_error(400,
					"Connection : failed : db = [{$this->dbName}]"
					." : host - [{$this->host}]"); // Debug
				return (null);
			}
			return ($this->conn);
		}

		public function		Close()
		{
			if ($this->conn)
			{
				$this->conn->close();
				$this->conn = null;
			}
		}

	}
?>
