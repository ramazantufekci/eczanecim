<?php namespace App\ThirdParty;
header('Content-type: text/html; charset=utf-8');
class Eczane
{
        private $postUrl = "https://www.istanbuleczaciodasi.org.tr/nobetci-eczane/index.php";
        private $requestHeaders = ["User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0"];
        private $key = "";
        private $ilceler = array();
        public $data=array();
        public function __construct()
        {
                $this->key = self::Getir($this->postUrl);
                self::ilceGetir();
        }
        private function seo($s) {
                 $tr = array('ş','Ş','i','ı','I','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',':',',');
                 $eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','');
                 $s = str_replace($tr,$eng,$s);
                 $s = strtolower($s);
                 $s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
                 $s = preg_replace('/\s+/', '-', $s);
                 $s = preg_replace('|-+|', '-', $s);
                 $s = preg_replace('/#/', '', $s);
                 $s = str_replace('.', '', $s);
                 $s = trim($s, '-');
                 return $s;
        }
        private function ilceGetir()
        {
                $message = "jx=1&islem=get_ilce&il=34&h=".$this->key;
                $data = json_decode(self::Getir($this->postUrl,$post=true,$message));
                /**
                *ilceleri veri tabanına kaydetmek için oluşturuldu.
                */
                //$db = new PDO("sqlite:kamil.db");
                foreach($data->ilceler as $ilce)
                {
                        $seo = self::seo($ilce->ilce);
                        $this->ilceler[$seo] = $ilce->ilce;
                        /*$sql = "INSERT INTO ilceler(isim,tr_isim) VALUES(:isim,:tr_isim)";
                        $smt = $db->prepare($sql);
                        $smt->execute([':isim'=>$ilce->ilce,':tr_isim'=>$seo]);*/
                }
        }

        public function getIlce($ilce=null)
        {
                if($ilce!=null)
                {
                        return $this->ilceler[$ilce];
                }else
                {
                        return $this->ilceler;
                }

        }
        private function Getir($url,$post=false,$message=null)
        {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //curl_setopt($ch,CURLOPT_VERBOSE,true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $this->requestHeaders);
                if($post)
                {
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
                        array_push($this->requestHeaders,"Accept:application/json, text/javascript, */*; q=0.01");
                        array_push($this->requestHeaders,"Content-Type: application/x-www-form-urlencoded; charset=UTF-8");
                        array_push($this->requestHeaders,"Referer: https://www.istanbuleczaciodasi.org.tr/nobetci-eczane/");
                        array_push($this->requestHeaders,"X-Requested-With: XMLHttpRequest");
                }
                else
                {
                        $response = curl_exec($ch);
                        curl_close($ch);
                        preg_match_all("#<input type=\"hidden\" name=\"h\" id=\"h\" value=\"([a-z0-9]+)\"/>#",$response,$response);
                        return $response[1][0];
                }
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
        }

        public function eczaneGetir($deneme)
        {
                if(preg_match("#[a-zA-Z]+#", $deneme)){
                $message = "jx=1&islem=get_ilce_eczane&ilce=".$deneme."&h=".$this->key;
                                $data = json_decode(self::Getir($this->postUrl,$post=true,$message));
                                //$db = new PDO("sqlite:kamil.db");
                                $db = \Config\Database::connect();
                foreach ($data->eczaneler as $value) {
                    /*echo "<address><strong>".$value->eczane_ad."</strong><br/>".$value->adres."<br />".$value->tarif."<br /><label>Telefon:</label><a href=\"tel:0".$value->eczane_tel."\"> 0".$value->eczane_tel."</a><br /><a href=\"https://www.google.com/maps/search/?api=1&query=".$value->lat.",".$value->lng."\">Harita da göster</a></address>";*/
                                        $ilcc = $db->query('SELECT id FROM ilceler where isim="'.$deneme.'"');
                                        //var_export($data);
                                        $kamil = $ilcc->getResultObject();
                                        $sicl = $db->query('SELECT sicil from eczaneler where sicil='.$value->sicil);
                                        $this->data[] =array("sicil"=>$value->sicil,"eczane_ad"=>$value->eczane_ad,"eczane_tel"=>$value->eczane_tel,"tarif"=>$value->tarif,"adres"=>$value->adres,"lat"=>$value->lat,"lng"=>$value->lng);
                                        if(($sicl->getResultObject())===false)
                                        {
                                                $sql = 'INSERT INTO eczaneler(sicil,eczane_ad,eczane_tel,tarif,adres,lat,lng,ilce_id) VALUES(:sicil,:eczane_ad,:eczane_tel,:tarif,:adres,:lat,:lng,:ilce_id)';
                                                $smt = $db->prepare($sql);
                                                $smt->execute([':sicil'=>$value->sicil,
                                                ':eczane_ad'=>$value->eczane_ad,
                                                ':eczane_tel'=>$value->eczane_tel,
                                                ':tarif'=>$value->tarif,
                                                ':adres'=>$value->adres,
                                                ':lat'=>$value->lat,
                                                ':lng'=>$value->lng,
                                                ':ilce_id'=>$kamil->id]);
                                        }

                }
                                $db = null;
                                return $this->data;
            }
        }
}
