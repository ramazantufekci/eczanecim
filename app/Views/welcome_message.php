<?php $this->extend("base.html");?>
<?php $this->section("block");?>
 <div class="form-inline form-group">
    <label for="ilcesec">ilçe seç</label>
    <select class="form-control" id="ilcesec">
	<?php foreach($results as $result)
		{
		echo "<option value=\"{$result->tr_isim}\">{$result->isim}</option>";
		}?>
	{% for key,ilce in ilceler%}
		{% if ilcej_tr == key %}
			<option value="{{key}}" selected>{{ilce}}</option>
		{% else %}
			<option value="{{key}}">{{ilce}}</option>
		{% endif %}
	{%endfor%}
	</select>
	  <button type="submit" id="eczaneGetir" class="btn btn-primary">Eczane bul</button>
  </div>
<?php $this->endSection();?>
{% block linkListe %}
<div class="row">
	<div class="col-xs-12 col-md-3">
		<div class="list-group">
			{% for key,ilce in ilceler%}
				<a href="/nobetci/eczane/{{key}}" class="list-group-item list-group-item-info">{{ilce}}</a>
			{%endfor%}
		</div>
	</div>
</div>

<?php //$this->extend("footer.php");
?>
