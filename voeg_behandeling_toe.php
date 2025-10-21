<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit; }
include 'db_connect.php';

if(isset($_POST['opslaan'])){
    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $prijs = $_POST['prijs'];
    $afbeelding = null;

    if(!empty($_FILES['afbeelding']['name'])){
        $afbeelding = time() . "_" . basename($_FILES['afbeelding']['name']);
        move_uploaded_file($_FILES['afbeelding']['tmp_name'], "../uploads/" . $afbeelding);
    }

    $stmt = $conn->prepare("INSERT INTO behandelingen (naam, beschrijving, prijs, afbeelding) VALUES (?,?,?,?)");
    $stmt->bind_param("ssds",$naam,$beschrijving,$prijs,$afbeelding);
    $stmt->execute();
    echo "<p style='color:green;'>Behandeling toegevoegd!</p>";
}
?>

<h2>Nieuwe Behandeling Toevoegen</h2>
<form method="POST" enctype="multipart/form-data">
<input type="text" name="naam" placeholder="Naam" required><br>
<textarea name="beschrijving" placeholder="Beschrijving" required></textarea><br>
<input type="number" step="0.01" name="prijs" placeholder="Prijs" required><br>
<input type="file" name="afbeelding"><br>
<button type="submit" name="opslaan">Opslaan</button>
</form>
