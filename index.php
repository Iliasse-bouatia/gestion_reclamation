<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $role = $_POST['role'];

    $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = ? AND password = ? AND role = ?");
    $query->execute([$username, $password, $role]);
    $user = $query->fetch();

    if ($user) {
        $_SESSION['role'] = $role;
        $_SESSION['username'] = $username;
        header('Location: ' . ($role === 'client' ? 'formulaire.php' : 'admin.php'));
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(255, 253, 150);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color:rgb(128, 181, 255);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <form action="" method="POST">
            <h2>Login</h2>
            <?php if (isset($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Identifiant</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select id="role" name="role">
                    <option value="client">utilisateur</option>
                    <option value="support">admin</option>
                </select>
            </div>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
