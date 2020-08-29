<?php namespace App\Controllers;
use App\ThirdParty\Eczane;
class Nobetci extends BaseController
{
    public function eczane($ec)
    {
        $db = \Config\Database::connect();
        $eczan = new Eczane();
        $result = $db->query("select * from ilceler where tr_isim=\"{$ec}\"");
        $isim = ($result->getResult())[0]->isim;
        $result = $db->query("select * from ilceler");
        $data = ["results" => $result->getResult()];
        $data["ilce_sec"]= $ec;
        $data["title_isim"] = $isim;
        $data["ec"]=$eczan->eczaneGetir($isim);
        echo view("nobetci",$data);
    }
}