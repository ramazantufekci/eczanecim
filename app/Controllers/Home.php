<?php namespace App\Controllers;
use App\ThirdParty\Eczane;
class Home extends BaseController
{
	public function index()
	{
		$db = \Config\Database::connect();
		$result = $db->query("select * from ilceler");
		$data = ["results" => $result->getResult()];
		return view('welcome_message',$data);
	}

	//--------------------------------------------------------------------

}
