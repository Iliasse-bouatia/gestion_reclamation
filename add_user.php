<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'support') {
    header('Location: index.php');
    exit;
}

// Gestion de l'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Validation des champs
    if (empty($username) || empty($password) || empty($role)) {
        $message = "Tous les champs doivent être remplis.";
    } else {
        // Hachage du mot de passe avec MD5
        $hashedPassword = md5($password);

        // Insertion dans la base de données
        try {
            $query = $pdo->prepare("INSERT INTO utilisateurs (username, password, role) VALUES (?, ?, ?)");
            $query->execute([$username, $hashedPassword, $role]);
            $message = "Utilisateur ajouté avec succès.";
        } catch (Exception $e) {
            $message = "Erreur lors de l'ajout de l'utilisateur: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(248, 246, 141);
            padding: 20px;
        }
        .form-container {
            margin: 0 auto;
            max-width: 500px;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
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
            background-color: rgb(128, 181, 255);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: rgb(121, 165, 255);
        }
        .message {
            text-align: center;
            font-size: 14px;
            color: green;
        }
        .error {
            text-align: center;
            font-size: 14px;
            color: red;
        }
        .return-btn {
            margin-top: 10px;
            background-color: rgb(255, 120, 120);
        }
        .return-btn:hover {
            background-color: rgb(255, 99, 99);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ajouter un Utilisateur</h2>

        <!-- Affichage du message de confirmation ou d'erreur -->
        <?php if (isset($message)): ?>
            <div class="<?= strpos($message, 'Erreur') !== false ? 'error' : 'message' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout d'utilisateur -->
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="role">Rôle</label>
                <select name="role" id="role" required>
                    <option value="client">Utilisateur</option>
                </select>
            </div>
            <button type="submit" name="add_user">Ajouter</button>
        </form>

        <!-- Bouton de retour -->
        <form action="admin.php" method="GET">
            <button type="submit" class="return-btn">Retour à Gestion</button>
        </form>
    </div>
</body>
</html>
