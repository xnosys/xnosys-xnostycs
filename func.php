<?php
	
	return function () {
		
		$clean = function ($host, $port, $char, $name, $user, $pass) {
			
			$connection = null;
			
			try {
				
				$connection = new \PDO(
					'mysql:host='.$host.';'.((strlen($port)) ? 'port='.intval($port).';' : '').'charset='.((strlen($char)) ? $char : 'utf8').';',
					$user,
					$pass,
					array(
						\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_EMULATE_PREPARES => false
					)
				);
				
				$statement = $connection->prepare('DROP DATABASE IF EXISTS '.$name.';');
				$result = $statement->execute(array()) ? true : false;
				$statement = null;
				if (!$result) {
					return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				}
				
				$connection = null;
				
			} catch (\PDOException $err) {
				
				$connection = null;
				
				return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				
			}
			
			return array(null);
			
		};
		
		$reset = function ($host, $port, $char, $name, $user, $pass) {
			
			$connection = null;
			
			try {
				
				$connection = new \PDO(
					'mysql:host='.$host.';'.((strlen($port)) ? 'port='.intval($port).';' : '').'charset='.((strlen($char)) ? $char : 'utf8').';',
					$user,
					$pass,
					array(
						\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_EMULATE_PREPARES => false
					)
				);
				
				$statement = $connection->prepare('DROP DATABASE IF EXISTS '.$name.';');
				$result = $statement->execute(array()) ? true : false;
				$statement = null;
				if (!$result) {
					return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				}
				
				$statement = $connection->prepare('CREATE DATABASE IF NOT EXISTS '.$name.';');
				$result = $statement->execute(array()) ? true : false;
				$statement = null;
				if (!$result) {
					return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				}
				
				$connection = null;
				
			} catch (\PDOException $err) {
				
				$connection = null;
				
				return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				
			}
			
			return array(null);
			
		};
		
		$exec = function ($host, $port, $char, $name, $user, $pass, $query, $params) {
			
			$connection = null;
			
			try {
				
				$connection = new \PDO(
					'mysql:host='.$host.';dbname='.$name.';'.((strlen($port)) ? 'port='.intval($port).';' : '').'charset='.((strlen($char)) ? $char : 'utf8').';',
					$user,
					$pass,
					array(
						\PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
						\PDO::ATTR_EMULATE_PREPARES => false
					)
				);
				
				$statement = $connection->prepare($query);
				$result = $statement->execute($params) ? true : false;
				$statement = null;
				if (!$result) {
					return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				}
				
				$connection = null;
				
			} catch (\PDOException $err) {
				
				$connection = null;
				
				return array('error: '.basename(__DIR__).'_'.basename(__FILE__, '.php').':'.__LINE__);
				
			}
			
			return array(null);
			
		};
		
		$new = function ($host, $port, $char, $name, $user, $pass) use ($reset, $clean, $exec) {
			
			$_host = $host;
			$_port = $port;
			$_char = $char;
			$_name = $name;
			$_user = $user;
			$_pass = $pass;
			
			return array(null, array(
				'test' => function ($this, $function, $app) use (&$_host, &$_port, &$_char, &$_name, &$_user, &$_pass, $reset) {
					list($error, $success) = $reset($_host, $_port, $_char, $_name, $_user, $_pass);
					if (!!$error) { return array($error); }
					list($error, $success) = $function($this, $app);
					if (!!$error) { return array($error); }
					return array(null);
				},
				'clean' => function () use (&$_host, &$_port, &$_char, &$_name, &$_user, &$_pass, $clean) {
					list($error, $success) = $clean($_host, $_port, $_char, $_name, $_user, $_pass);
					if (!!$error) { return array($error); }
					return array(null);
				},
				'exec' => function ($query, $params) use (&$_host, &$_port, &$_char, &$_name, &$_user, &$_pass, $exec) {
					list($error, $success) = $exec($_host, $_port, $_char, $_name, $_user, $_pass, $query, $params);
					if (!!$error) { return array($error); }
					return array(null);
				}
			));
			
		};
		
		return array(
			'new' => $new
		);
		
	};
	
?>