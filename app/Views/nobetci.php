<?php $this->extend("base.html");?>
<?php
$this->section("title");
echo "İstanbul {$title_isim} Nöbetçi Eczane Listesi";
$this->endSection();
?>
<?php $this->section("block");?>
  <div class="form-inline form-group">
    <label for="ilcesec">ilçe seç</label>
    <select class="form-control" id="ilcesec">
    <?php foreach($results as $result)
		{
            if($ilce_sec==$result->tr_isim)
            {
                echo "<option value=\"{$result->tr_isim}\" selected>{$result->isim}</option>";                
            }else
            {
                echo "<option value=\"{$result->tr_isim}\">{$result->isim}</option>";
            }
		
        }
        ?>
        </select>
          <button type="submit" id="eczaneGetir" class="btn btn-primary">Eczane bul</button>
  </div>

 <?php 
    foreach($ec as $key=>$ecz)
    {
        echo "<address><strong>{$ecz["eczane_ad"]}</strong><br/>{$ecz["adres"]}{$ecz["tarif"]}<br /><label>Telefon:</label><a href=\"tel:+90{$ecz["eczane_tel"]}\">0{$ecz["eczane_tel"]}</a><br /><a href=\"https://www.google.com/maps/search/?api=1&query={$ecz["lat"]},{$ecz["lng"]}\">Harita da göster</a></address>";
    }?>
<?php $this->endSection();?>