<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'support') {
    header('Location: index.php');
    exit;
}

// Gestion de la mise à jour du statut
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $statut = $_POST['statut'];

    $query = $pdo->prepare("UPDATE reclamations SET statut = ? WHERE id = ?");
    $query->execute([$statut, $id]);
}

// Gestion de la suppression d'une réclamation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = $pdo->prepare("DELETE FROM reclamations WHERE id = ?");
    $query->execute([$id]);
}

// Récupération des réclamations
$query = $pdo->query("SELECT * FROM reclamations");
$reclamations = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Réclamations</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: rgb(248, 246, 141);
        padding: 20px;
    }
    .table-container {
        margin: 0 auto;
        max-width: 900px;
        background: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: center;
        font-size: 16px;
    }
    th {
        background-color: rgb(56, 149, 255);
        color: white;
        font-weight: bold;
    }
    td {
        background-color: rgb(255, 255, 255);
        color: #333;
    }
    td:hover {
        background-color: #f1f1f1;
    }
    button {
        padding: 8px 16px;
        background-color: rgb(141, 175, 248);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }
    button:hover {
        background-color: #FF4500;
    }
    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }
    .logout-btn {
        padding: 10px 20px;
        background-color: #FF4C4C;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }
    .logout-btn:hover {
        background-color: #e60000;
    }
    </style>
</head>
<body>
    <div class="table-container">
        <h2>Liste des Réclamations</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Priorité</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reclamations as $reclamation): ?>
                <tr>
                    <td><?= $reclamation['id'] ?></td>
                    <td><?= $reclamation['description'] ?></td>
                    <td><?= ucfirst($reclamation['priorite']) ?></td>
                    <td><?= ucfirst($reclamation['statut']) ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $reclamation['id'] ?>">
                            <select name="statut">
                                <option value="ouverte" <?= $reclamation['statut'] === 'ouverte' ? 'selected' : '' ?>>Ouverte</option>
                                <option value="en cours" <?= $reclamation['statut'] === 'en cours' ? 'selected' : '' ?>>En cours</option>
                                <option value="résolue" <?= $reclamation['statut'] === 'résolue' ? 'selected' : '' ?>>Résolue</option>
                            </select>
                            <button type="submit" name="update">Mettre à jour</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?= $reclamation['id'] ?>">
                            <button type="submit" name="delete" style="background-color: #FF4C4C;">Supprimer</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Lien vers les statistiques -->
        <a href="stats.php"><button>Voir les Statistiques</button></a>

        <!-- Lien vers la page d'ajout d'utilisateur -->
        <a href="add_user.php"><button>Ajouter un utilisateur</button></a>

        <!-- Formulaire de déconnexion -->
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Se déconnecter</button>
        </form>
    </div>
</body>
</html>
