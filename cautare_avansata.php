<?php
define('URL','https://maps.googleapis.com/maps/api/geocode/xml?address=');
function getLatitude($oras){
  $data = file_get_contents(URL . $oras);
  $xml = simplexml_load_string($data);
  $latitude = $xml->result->geometry->location->lat;
  return floatval($latitude);
}
function getLongitude($oras){
  $data = file_get_contents(URL . $oras);
  $xml = simplexml_load_string($data);
  $longitude = $xml->result->geometry->location->lng;
  return floatval($longitude);
}
?>

<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="http://bootswatch.com/lumen/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="http://maps.googleapis.com/maps/api/js"></script>
</head>
<body>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="http://bit.ly/1X4CIYW">TroW</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="index.html"> Pagina Principală </a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"> Căutare <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="cautare_simpla.html"> Căutare Simplă </a></li>
          <li><a href="cautare_avansata.html"> Căutare Avansată </a></li>
        </ul>
      </li>
      <li><a href="despre.html"> Despre </a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><a href="inregistrare.html"><span class="glyphicon glyphicon-user"></span> Înregistrați-vă </a></li>
      <li><a href="autentificare.html"><span class="glyphicon glyphicon-log-in"></span> Autentificați-vă </a></li>
    </ul>
  </div>
</nav>
</br>
<div class="jumbotron text-center">
<h1> Mai jos aveți rezultatele căutării dumneavoastră: </h1>
<?php
$mysql = new mysqli("localhost", "Teo", "Mada", "myDB");
$statie_plecare = htmlspecialchars($_REQUEST["statie_plecare"]);
$statie_plecare = ucfirst($statie_plecare);
$escala = htmlspecialchars($_REQUEST["escala"]);
$escala = ucfirst($escala);
$statie_sosire = htmlspecialchars($_REQUEST["statie_sosire"]);
$statie_sosire = ucfirst($statie_sosire);
echo "<h3></br> Cu plecare din: " . $statie_plecare . "</h3>";
$res = $mysql->query("select id_tren, statie_plecare, ora_plecare, statie_sosire, ora_sosire from drumuri where statie_plecare like '$statie_plecare%' and statie_sosire like '$escala%' order by ora_plecare");
$string=          
  '<table class="table table-striped table-hover table-responsive table-bordered">
    <thead>
      <tr>
        <th><h3 class="text-center">Numărul Trenului</h3></th>
        <th><h3 class="text-center">Stația de Plecare</h3></th>
        <th><h3 class="text-center">Ora Plecării</h3></th>
        <th><h3 class="text-center">Stația de Sosire</h3></th>
        <th><h3 class="text-center">Ora Sosirii</h3></th>
      </tr>
    </thead>
    <tbody>
';
    while($row = $res->fetch_assoc()) {
        $string.=
        "<tr><td><a>".$row["id_tren"]."</a></td>".
        "<td>".$row["statie_plecare"]."</td>".
        "<td>".$row["ora_plecare"]."</td>".
        "<td>".$row["statie_sosire"]."</td>".
        "<td>".$row["ora_sosire"]."</td></tr>"
        ;
    }
    $string.="
    </tbody>
  </table>";
    echo $string;
?>  
</div>
<div class="jumbotron text-center">
<?php
echo "<h3></br> Cu plecare din: " . $escala . "</h3>";
$res = $mysql->query("select id_tren, statie_plecare, ora_plecare, statie_sosire, ora_sosire from drumuri where statie_plecare like '$escala%' and statie_sosire like '$statie_sosire%' order by ora_plecare");
$string=          
  '<table class="table table-striped table-hover table-responsive table-bordered">
    <thead>
      <tr>
        <th><h3 class="text-center">Numărul Trenului</h3></th>
        <th><h3 class="text-center">Stația de Plecare</h3></th>
        <th><h3 class="text-center">Ora Plecării</h3></th>
        <th><h3 class="text-center">Stația de Sosire</h3></th>
        <th><h3 class="text-center">Ora Sosirii</h3></th>
      </tr>
    </thead>
    <tbody>
';
    while($row = $res->fetch_assoc()) {
        $string.=
        "<tr><td><a>".$row["id_tren"]."</a></td>".
        "<td>".$row["statie_plecare"]."</td>".
        "<td>".$row["ora_plecare"]."</td>".
        "<td>".$row["statie_sosire"]."</td>".
        "<td>".$row["ora_sosire"]."</td></tr>"
        ;
    }
    $string.="
    </tbody>
  </table>";
    echo $string;
?>
</div>

<script>
var iasi_latitude = parseFloat('<?php echo getLatitude($statie_plecare); ?>');
var iasi_longitude = parseFloat('<?php echo getLongitude($statie_plecare); ?>');
var iasi=new google.maps.LatLng(iasi_latitude, iasi_longitude);

var escala_latitude = parseFloat('<?php echo getLatitude($escala); ?>');
var escala_longitude = parseFloat('<?php echo getLongitude($escala); ?>');
var escala=new google.maps.LatLng(escala_latitude, escala_longitude);

var bacau_latitude = parseFloat('<?php echo getLatitude($statie_sosire); ?>');
var bacau_longitude = parseFloat('<?php echo getLongitude($statie_sosire); ?>');
var bacau=new google.maps.LatLng(bacau_latitude, bacau_longitude);

var center_latitude = (iasi_latitude + bacau_latitude + escala_latitude) / 3;
var center_longitude = (iasi_longitude + bacau_longitude + escala_longitude) / 3;
var center=new google.maps.LatLng(center_latitude, center_longitude);
function initialize()
{
var mapProp = {
  center:center,
  zoom:7,
  disableDefaultUI:true,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var myTrip=[iasi,escala,bacau];
var flightPath=new google.maps.Polyline({
  path:myTrip,
  strokeColor:"#0000FF",
  strokeOpacity:0.8,
  strokeWeight:2
  });

flightPath.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<div class="page-header">
<div class="jumbotron" id="googleMap" style="width:100%;height:100%;position:absolute"></div>
</div>

</body>
</html>
