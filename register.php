<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

   
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($check->num_rows > 0) {
        $message = "<p style='color:red;'>Gebruikersnaam bestaat al!</p>";
    } else {
        if ($conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')")) {
            $message = "<p style='color:green;'>Gebruiker succesvol geregistreerd!</p>";
        } else {
            $message = "<p style='color:red;'>Fout bij registreren!</p>";
        }
    }
}
?>

<h2>Registreren</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Gebruikersnaam" required>
    <input type="password" name="password" placeholder="Wachtwoord" required>
    <button type="submit">Register</button>
</form>

<?= $message ?? '' ?>
