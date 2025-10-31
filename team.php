<?php
$conn = new mysqli("localhost","root","","kapperwebshop");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM team WHERE id=$id";
$result = $conn->query($sql);

$teamlid = null;
if($result && $result->num_rows > 0){
    $teamlid = $result->fetch_assoc();
}

$sql2 = "SELECT * FROM behandelingen";
$res2 = $conn->query($sql2);
$behandelingen = [];
if($res2 && $res2->num_rows > 0){
    while($row = $res2->fetch_assoc()){
        $behandelingen[] = $row;
    }
}

$afspraakMessage = "";
if(isset($_POST['afspraak'])){
    $behandeling_id = $_POST['behandeling_id'];
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $datum = $_POST['datum'];
    $stmt = $conn->prepare("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum) VALUES (?,?,?,?,?)");
    $stmt->bind_param("iisss",$behandeling_id, $id, $naam, $email, $datum);
    if($stmt->execute()){
        $afspraakMessage = "<p class='success'>Afspraak succesvol!</p>";
    } else {
        $afspraakMessage = "<p class='error'>Fout bij het maken van de afspraak!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Teamlid Details</title>
    <link rel="stylesheet" href="style/team.css"> 
</head>
<body>
    <div class="team-container">
        <div class="teamlid-info">
            <?php if($teamlid): ?>
                <h1><?= htmlspecialchars($teamlid['naam']) ?></h1>
                <h2><?= htmlspecialchars($teamlid['functie']) ?></h2>
                <p><?= htmlspecialchars($teamlid['beschrijving']) ?></p>
                <?php if($teamlid['foto']): ?>
                    <img src="<?= htmlspecialchars($teamlid['foto']) ?>" alt="<?= htmlspecialchars($teamlid['naam']) ?>">
                <?php endif; ?>
            <?php else: ?>
                <p>Teamlid niet gevonden.</p>
            <?php endif; ?>
        </div>

        <?php if(count($behandelingen) > 0 && $teamlid): ?>
            <div class="afspraak-sectie">
                <h2>Maak een afspraak</h2>
                <?= $afspraakMessage ?>
                <form method="POST">
                    <label for="behandeling_id">Behandeling kiezen:</label>
                    <select name="behandeling_id" id="behandeling_id" required>
                        <?php foreach($behandelingen as $b): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['naam']) ?> (€<?= htmlspecialchars($b['prijs']) ?>)</option>
                        <?php endforeach; ?>
                    </select>

                    <label for="naam">Jouw naam:</label>
                    <input type="text" name="naam" id="naam" placeholder="Jouw naam" required>

                    <label for="email">Jouw email:</label>
                    <input type="email" name="email" id="email" placeholder="Jouw email" required>

                    <label for="datum">Datum en tijd:</label>
                    <input type="datetime-local" name="datum" id="datum" required>

                    <button type="submit" name="afspraak">Afspraak maken</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
