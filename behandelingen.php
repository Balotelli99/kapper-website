<?php
$conn = new mysqli("localhost","root","","kapperwebshop");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM team WHERE id=$id";
$result = $conn->query($sql);


// Afspraak met behandelingen van dit teamlid
$sql2 = "SELECT * FROM behandelingen";
$res2 = $conn->query($sql2);
if($res2->num_rows > 0){
   
    

    echo "</select>";
    echo "<input type='text' name='naam' placeholder='Jouw naam' required>";
    echo "<input type='email' name='email' placeholder='Jouw email' required>";
    echo "<input type='datetime-local' name='datum' required>";
    echo "<input type='submit' name='afspraak' value='Afspraak maken'>";
    echo "</form>";
}

if(isset($_POST['afspraak'])){
    $behandeling_id = $_POST['behandeling_id'];
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $datum = $_POST['datum'];
    $stmt = $conn->prepare("INSERT INTO afspraken (behandeling_id, team_id, naam, email, datum) VALUES (?,?,?,?,?)");
    $stmt->bind_param("iisss",$behandeling_id, $id, $naam, $email, $datum);
    $stmt->execute();
    echo "<p>Afspraak succesvol!</p>";
}
