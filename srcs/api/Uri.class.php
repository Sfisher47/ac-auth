<?php

/* ************************************************************************** */
/*                                                                            */
/*  Uri.class.php                                                             */
/*                                                                            */
/*   By: elhmn <www.elhmn.com>                                                */
/*             <nleme@live.fr>                                                */
/*                                                                            */
/*   Created:                                                 by elhmn        */
/*   Updated: Fri Jul 27 10:08:25 2018                        by bmbarga      */
/*                                                                            */
/* ************************************************************************** */

	class		Uri
	{
		public static		$verbose = false;

		public	$method;
		public	$url;

		//constructor
		public function		__construct($uri, $method)
		{
			if (self::$verbose)
			{
				echo __CLASS__. " constructor called !" . PHP_EOL;
			}

			if (!is_string($uri))
			{
				internal_error('uri', __FILE__, __LINE__);
				return null;
			}
			$this->ExtractUrlData($uri);
			$this->method = $method;
		}

		//destructor
		public function		__destruct()
		{
			if (self::$verbose)
			{
				echo __CLASS__. " desctructor called !" . PHP_EOL;
			}
		}

		public function		ExtractUrlData($uri)
		{
			$data_arr = null;

			if (!is_string($uri))
			{
				internal_error('uri', __FILE__, __LINE__);
				return (0);
			}
			$data_arr = explode('/', $uri);
			$data_arr = array_filter($data_arr);
			$data_arr = array_values($data_arr);
			$this->url = $data_arr;
		}

		public function		__toString()
		{
			return (__CLASS__ ." : \n{"
				. "\n\tmethod = [$this->method]"
				."\n}\n"
			);
		}
	};

?>
