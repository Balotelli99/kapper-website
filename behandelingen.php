<?php
// Verbinding met database
$conn = new mysqli("localhost", "root", "", "kapperwebshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['id'])) {
    $id = (int)$_GET['id']; // haal id uit URL en maak er een getal van
} else {
    $id = 0; // standaardwaarde als id niet bestaat
}



$sql = "SELECT * FROM behandelingen WHERE id=$id";
$result = $conn->query($sql);

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo "<h1>" . $row['naam'] . "</h1>";
    echo "<p>" . $row['beschrijving'] . "</p>";
    echo "<p>Prijs: €" . $row['prijs'] . "</p>";
    if($row['afbeelding']) {
        echo "<img src='" . $row['afbeelding'] . "' alt='" . $row['naam'] . "'>";
    }
} else {
    echo "Behandeling niet gevonden.";
}







