<?php
$mysql = new mysqli("localhost", "root", "root", "myDB");

$statie_plecare = $_GET["statie_plecare"];
echo $statie_plecare . "<br/>";

$sql = "select * from drumuri where statie_plecare like $statie_plecare";
$results = $mysql->query($sql);
while($result = $results->fetch_assoc()){
	echo $result["statie_plecare"] . " " . $result["statie_sosire"] . "<br/>";
}	
?>