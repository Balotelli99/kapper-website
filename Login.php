<?php
session_start();
include 'db_connect.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            $_SESSION['user_id'] = $user['id'];
            header("Location: behandelingen_overzicht.php"); // Hier kun je een dashboard maken
            exit;
        } else {
            $error = "Wachtwoord fout!";
        }
    } else {
        $error = "Gebruiker niet gevonden!";
    }
}
?>

<h2>Login</h2>
<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

<?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
