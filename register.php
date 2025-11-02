<?php
session_start();
include 'db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Co
    $check = $conn->query("SELECT * FROM users WHERE username='$username'");
    
    if ($check->num_rows > 0) {
        $message = "<p class='error'>Gebruikersnaam bestaat al!</p>";
    } else {
        if ($conn->query("INSERT INTO users (username, password) VALUES ('$username', '$password')")) {
            $message = "<p class='success'>Gebruiker succesvol geregistreerd!</p>";
            header("Refresh:2; url=login.php");
        } else {
            $message = "<p class='error'>Fout bij registreren!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="registeren.css">
</head>
<body>

<main class="register-sectie">
    <h1>Registreren</h1>

    <form method="POST">
        <input type="text" name="username" placeholder="Gebruikersnaam" required>
        <input type="password" name="password" placeholder="Wachtwoord" required>
        <button type="submit">Registreren</button>
    </form>

    <?= $message ?>
    
    <p>Al een account? <a href="login.php">Log hier in</a></p>
</main>

</body>
</html>
