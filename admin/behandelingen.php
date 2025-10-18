<?php
include 'db_connect.php'; // connectie met database

// Query alle behandelingen
$stmt = $pdo->query("SELECT * FROM behandelingen");

while ($row = $stmt->fetch()) {
    echo "<div>";
    echo "<h2>" . htmlspecialchars($row['naam']) . "</h2>";
    echo "<p>" . htmlspecialchars($row['beschrijving']) . "</p>";
    echo "<p>Prijs: €" . number_format($row['prijs'], 2, ',', '.') . "</p>";
    echo '<a href="behandeling_detail.php?id=' . $row['id'] . '">Maak afspraak</a>';
    echo "</div>";
}
?>
