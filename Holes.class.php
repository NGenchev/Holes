<?php

class Holes
{
	private $firebaseRef;

	function __construct($action, $param = null)
	{	

		define("URL", 'https://dg-soft-holes.firebaseio.com/');
		define("TOKEN", 'LdPotb0yv6av7LQiei1UzzDCj9v2ai3kLceGiLVM');
		define("PATH", '/');

		// const URL = 'https://dg-soft-holes.firebaseio.com/';
		// const TOKEN = 'LdPotb0yv6av7LQiei1UzzDCj9v2ai3kLceGiLVM';
		// const PATH = '/';

		$this->firebaseRef = new \Firebase\FirebaseLib(URL, TOKEN);

		if(method_exists(__CLASS__, $action))
			if(isset($param) && $param != null)
				try
				{
					$this->$action($param);
				}
				catch(Exception $e)
				{
					$this->$action();
				}
			else
				$this->$action();
	}

	private function list()
	{
		return $this->firebaseRef->get(PATH . 'Holes/');
	}

	private function create($hole)
	{
		$hole = (array) json_decode($hole);
		$hole['created'] = time();

		$newId = file_put_contents("idList.json", json_encode(md5(time())));
		$id = json_decode(file_get_contents("idList.json"));

		return $this->firebaseRef->set(PATH . 'Holes/uniqid_'.$id, $hole);
	}

	private function delete($id)
	{
		return $this->firebaseRef->delete(PATH."/".$id);
	}

	public function listing()
	{
		echo self::list();
	}

	public function addNew($hole)
	{
		self::create($hole);
	}

	public function deleteHole($id)
	{
		self::delete($id);
	}
}