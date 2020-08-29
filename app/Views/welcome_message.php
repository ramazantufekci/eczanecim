<?php $this->extend("base.html");?>
<?php $this->section("title");
echo "İstanbul Nöbetçi Eczane Listesi";
$this->endSection();?>
<?php $this->section("block");?>
 <div class="form-inline form-group">
    <label for="ilcesec">ilçe seç</label>
    <select class="form-control" id="ilcesec">
	<?php foreach($results as $result)
		{
		echo "<option value=\"{$result->tr_isim}\">{$result->isim}</option>";
		}?>
	</select>
	  <button type="submit" id="eczaneGetir" class="btn btn-primary">Eczane bul</button>
  </div>
  <div class="row">
		<div class="col-xs-12 col-md-3">
			<div class="list-group">
				<?php foreach($results as $result)
				{
					echo "<a href=\"/nobetci/eczane/{$result->tr_isim}\" class=\"list-group-item list-group-item-info\">{$result->isim}</a>";
				}?>
					
			</div>
		</div>
	</div>
<?php $this->endSection();?>

