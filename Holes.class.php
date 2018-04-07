<?php

class Holes
{
	private $firebaseRef;

	// Beging of Holes class
	function __construct($action, $param = null)
	{	

		define("URL", 'https://dg-soft-holes.firebaseio.com/');
		define("TOKEN", 'LdPotb0yv6av7LQiei1UzzDCj9v2ai3kLceGiLVM');
		define("PATH", '/');

		$this->firebaseRef = new \Firebase\FirebaseLib(URL, TOKEN);

		if(method_exists(__CLASS__, $action))
			try
			{
				$this->$action($param); 
			}
			catch(Exception $e)
			{
				$this->listing();
			}
	}

	// Private functions

	private function lists()
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
		return $this->firebaseRef->delete(PATH."/Holes/".$id);
	}


	// Public functions

	public function listing()
	{
		echo self::lists();
	}

	public function addNew($hole)
	{
		echo self::create($hole);
	}

	public function deleteHole($id)
	{
		echo self::delete($id);
	}
}
