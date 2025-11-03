<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "kapperwebshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbinding mislukt: " . $conn->connect_error);
}
?>

<?php
$behandelingen = $conn->query("SELECT * FROM behandelingen ORDER BY id ASC");
$teamleden = $conn->query("SELECT * FROM team ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sultan's Hairstyles</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>

<header>
  <nav>
    <a href="index.php" class="active">Home</a>
    <a href="afspraak.php">Afspraak</a>
    <a href="team.php">Het Team</a>
    <a href="#">Kosten</a>
    <a href="producten.html">Producten</a>
    <a href="#">Contact</a>
  </nav>
</header>

<main class="midden">
  <h1>Welkom bij Kapsalon Perfect Cut</h1>
  <p>Waar stijl, verzorging en ontspanning samenkomen.</p>
  <a href="afspraak.php" class="button">Maak een afspraak</a>
</main>

<main class="midden2">
  <h1>Over Sultan's Hairstyles</h1>
  <h2>Als je een goede kapper in Utrecht zoekt</h2>
  <p>Ons team combineert creativiteit en vakmanschap om jou elke dag een look te geven waar je zelfverzekerd mee de deur uitgaat.</p>
  <div class="midden2-fotos">
    <img src="afbeeldingen/image copy 3.png" alt="Opscheer">
    <img src="afbeeldingen/image copy 4.png" alt="Kleur">
    <img src="afbeeldingen/image copy 5.png" alt="Baard">
  </div>
</main>


<main class="behandelingen">
<h1>Onze Behandelingen</h1>
<div class="behandelingen-container">
  <?php
 if($behandelingen){
 while($b = $behandelingen->fetch_assoc()){
 echo "<div class='behandeling'>";  echo "<h2>".$b['naam']."</h2>";
 echo "<p>".$b['beschrijving']."</p>";
 echo "<p class='prijs'>Prijs: €".$b['prijs']."</p>";
  echo "<a href='behandelingen.php?id=".$b['id']."' class='button'>Maak Afspraak</a>";
      echo "</div>";
      }
    } else {
      echo "<p>Geen behandelingen beschikbaar.</p>";
    }
    ?>
  </div>
</main>


<main class="team">
  <h1>Het Team</h1>
  <div class="team-container">
    <?php
 if($teamleden){
  while($lid = $teamleden->fetch_assoc()){
  echo "<div class='teamlid'>";
 echo "<h2>".$lid['naam']."</h2>";
 if($lid['foto'] != "") {
   echo "<img src='".$lid['foto']."' alt='Foto van ".$lid['naam']."' class='team-foto'>";
        } else {
  echo "<img src='afbeeldingen/default.png' alt='Geen foto beschikbaar' class='team-foto'>";
        }
   echo "<h3>".$lid['functie']."</h3>";
  echo "<p>".$lid['beschrijving']."</p>";
  echo "<a href='team.php?id=".$lid['id']."' class='button'>Meer info</a>";
   echo "</div>";
      }
    } else {
      echo "<p>Geen teamleden beschikbaar.</p>";
    }
    ?>
  </div>
</main>


<footer><h3>Openingstijden</h3>
  <p>
 Maandag: 09:30 - 18:00<br>
 Dinsdag: 09:30 - 18:00<br>
 Donderdag: 09:30 - 18:00<br>
 Vrijdag: 09:30 - 20:00<br>
 Zaterdag: 12:00 - 17:00
  </p>

  <h3>Contact</h3>
  <p>
    Telefoon: 0123-456789<br>
    Email: info@perfectcut.nl<br>
    Adres: Hoofdstraat 123, 1234 AB Stad
  </p>

  <p class="footer-bottom">© 2025 Kapsalon Perfect Cut. Alle rechten voorbehouden.</p>
</footer>

</body>
</html>
