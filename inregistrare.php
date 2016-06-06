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

   // verificam daca s-a introdus numele corect 
   $name = htmlspecialchars($_REQUEST["nume_utilizator"]);
   if (!$name ) {
?> 
   <p class="mesaj">Numele nu este corect!</p> 
<?php 
   } 
   //verificam daca s-a introdus email
   $email = htmlspecialchars($_REQUEST["email"]);
   if (!$email ) {
?> 
   <p class="mesaj">Emailul nu este corect!</p> 
<?php 
   } 
   //verificam parola introdusa sa fie corecta
   $ok_pass=0;
   $parola = htmlspecialchars($_REQUEST["parola"]);
   if (!$parola ) {
?> 
   <p class="mesaj">Parola nu este corecta!</p> 
<?php 
   } 

   $parola_repetata=htmlspecialchars($_REQUEST["parola_repetata"]);
   if (!$parola_repetata ) {
?> 
   <p class="mesaj">Parola nu este corecta!</p> 
<?php 
   } 
   else{
    if($parola_repetata!=$parola){
      $ok_pass=1;
  ?> 
    <p class="mesaj">Parola nu coincide cu prima introdusa!</p> 
  <?php 
      }
   }

   if($ok_pass==0)
   {
   //verific daca numele exista deja
   $ok=0;
   $result= $conn->query("select * from utilizatori");
   while($row = $result->fetch_assoc()) {
    if($name == $row["nume_utilizator"])
    {
      echo "Numele de utilizator exista deja.";
      $ok=1;
    }
   }
   if($ok==0)
   {
      $sql = $conn->prepare("insert into utilizatori values (NULL, ?, ?, ?)");
      $sql->bind_param('sss',$name,$parola,$email);
      $sql->execute();
    }
  }
?>
<hr />
</body>
  
 