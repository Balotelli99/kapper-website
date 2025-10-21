<?php
// Verbinding met database
$conn = new mysqli("localhost", "root", "", "kapperwebsite");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Haal id uit URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Haal de behandeling op uit database
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
?>
<?php
$conn = new mysqli("localhost","root","","kapperwebsite");
$sql = "SELECT * FROM behandelingen";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
    echo "<div class='behandeling'>";
    echo "<h2>{$row['naam']}</h2>";
    echo "<p>{$row['beschrijving']}</p>";
    echo "<p class='prijs'>Prijs: €{$row['prijs']}</p>";
    echo "<a href='behandeling.php?id={$row['id']}' class='button'>Maak Afspraak</a>";
    echo "</div>";
}
?>

