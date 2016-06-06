<!DOCTYPE html>
<html>
<head>
<title>Autentificare</title>
<style type="text/css">
body {
  width: 50em;
}
.mesaj {
  color: red;
  font-weight: bold;
}
</style>
</head>
<body>
<?php 
	ini_set('max_execution_time', 10);
	//ma conectez la baza de date
	$conn = new mysqli("localhost", "Teo", "Mada", "myDB");
	if ($conn->connect_error) {die("Connection failed: " . $conn->connect_error);}

   // verificam daca s-a introdus codul trenului 
   $name = $_REQUEST["nume_utilizator"];
   if (!$name ) {
?> 
   <p class="mesaj">Numele nu exista!</p> 
<?php 
   } 
   $parola = $_REQUEST["parola"];
   if (!$parola ) {
?> 
   <p class="mesaj">Parola nu este corecta!</p> 
<?php 
   } 
   //verific daca numele si parola sunt ok
   $ok_nume=0;
   $ok_parola=0;
   $result= $conn->query("select * from utilizatori");
   while($row = $result->fetch_assoc()) {
    if($name == $row["nume_utilizator"])
    {
      $ok_nume=1;
      if($parola == $row["password"])
      {
        $ok_parola=1;
      }
    }    
   }
   if($ok_nume==0)
   {
	    echo "Numele de utilizator este scris gresit. Va rugam mai inregistrativa odata";
    }
   if($ok_parola==0)
   {
      echo "Parola este scrisa gresit. Va rugam mai inregistrativa odata";
    } 
    if($ok_nume==1 && $ok_parola==1)
      echo " Va multumim pentru inregistrare";
?>
<hr />

</body>
	
 