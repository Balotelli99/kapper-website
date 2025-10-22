<?php
session_start();
include 'db_connect.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Controleer of gebruiker al bestaat
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $error = "Gebruikersnaam bestaat al!";
    } else {
        // Voeg nieuwe gebruiker toe aan database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        if($stmt->execute()){
            $success = "Gebruiker succesvol geregistreerd!";
        } else {
            $error = "Fout bij registreren!";
        }
    }
}
?>

<h2>Registreren</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="register">Register</button>
</form>

<?php 
if(isset($error)) echo "<p style='color:red;'>$error</p>"; 
if(isset($success)) echo "<p style='color:green;'>$success</p>"; 
?>
