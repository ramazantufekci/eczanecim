<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title><?php $title;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="description" content="istanbul'da ilçe ilçe nöbetçi eczane adres bilgileri" />
<meta name="author" content="Derya TÜFEKÇİ" />
<!-- css -->
<link href="/css/bootstrap.min.css" rel="stylesheet" />
<link href="/css/font-awesome.css" rel="stylesheet" />
<script src="/js/jquery.js"></script>
<script>
$(document).ready(function(){
        $("#eczaneGetir").click(function(){
                var ilce = $("#ilcesec").val();
                location.replace('/nobetci/eczane/'+ilce);
        });
});

</script>
</head>
<body>

