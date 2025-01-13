<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'client') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = $_POST['description'];
    $priorite = $_POST['priorite'];

    $query = $pdo->prepare("INSERT INTO reclamations (description, priorite) VALUES (?, ?)");
    $query->execute([$description, $priorite]);

    $success = "Réclamation soumise avec succès.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Réclamation</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(229, 255, 172); /* Un gris clair pour le fond */
        padding: 20px;
    }
    .form-container {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
        border: 1px solid #ddd;
    }
    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
        font-size: 24px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #555;
    }
    input, select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    input:focus, select:focus, textarea:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 8px rgba(76, 175, 80, 0.4);
        outline: none;
    }
    textarea {
        resize: vertical;
        height: 150px;
    }
    button {
        width: 100%;
        padding: 12px;
        background-color: rgb(80, 121, 255); /* Bleu foncé */
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 18px;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: rgb(0, 123, 255); /* Bleu plus foncé */
    }
    .success {
        color: green;
        font-size: 16px;
        text-align: center;
        margin-bottom: 15px;
        font-weight: bold;
    }
    .slogan {
        text-align: center;
        margin-top: 20px;
        font-size: 18px;
        color: #666;
        font-style: italic;
    }
    .logout-btn {
        padding: 12px;
        background-color: #FF4C4C; /* Rouge */
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        width: 100%;
        margin-top: 20px;
    }
    .logout-btn:hover {
        background-color: #e60000; /* Rouge foncé */
    }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="POST">
            <h2>Déposer une Réclamation</h2>
            <?php if (isset($success)): ?>
                <div class="success"><?= $success ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="priorite">Priorité</label>
                <select id="priorite" name="priorite">
                    <option value="faible">Faible</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="haute">Haute</option>
                </select>
            </div>
            <button type="submit">Soumettre</button>
        </form>
        
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
        
        <div class="slogan">
            <p>"Votre satisfaction, notre priorité!"</p>
        </div>
    </div>
</body>
</html>
