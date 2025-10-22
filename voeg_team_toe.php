<?php
session_start();
if(!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit; 
}
include 'db_connect.php';

$message = '';

if(isset($_POST['opslaan'])){
    $naam = $_POST['naam'];
    $functie = $_POST['functie'];
    $beschrijving = $_POST['beschrijving'];

    // Corrected SQL statement
    $stmt = $conn->prepare("INSERT INTO team (naam, functie, beschrijving) VALUES (?,?,?)");
    $stmt->bind_param("sss", $naam, $functie, $beschrijving);

    if($stmt->execute()){
        $message = "<p style='color:green;'>Teamlid toegevoegd!</p>";
    } else {
        $message = "<p style='color:red;'>Fout bij toevoegen!</p>";
    }
}
?>


<h2>Nieuw teamlid Toevoegen</h2>
<form method="POST">
    <input type="text" name="naam" placeholder="Naam" required><br>
    <input type="text" name="functie" placeholder="Functie" required><br>
    <textarea name="beschrijving" placeholder="Beschrijving" required></textarea><br>
 
    <button type="submit" name="opslaan">Opslaan</button>
</form>

<?= $message ?>
