<?php
session_start();
require 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'support') {
    header('Location: index.php');
    exit;
}

$query = $pdo->query("SELECT statut, COUNT(*) AS count FROM reclamations GROUP BY statut");
$data = $query->fetchAll(PDO::FETCH_ASSOC);

$labels = [];
$counts = [];
$total = 0;

foreach ($data as $row) {
    $labels[] = ucfirst($row['statut']);
    $counts[] = $row['count'];
    $total += $row['count'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        canvas {
            max-width: 600px;
            margin: 0 auto;
        }
        table {
            margin-top: 40px; /* Espacement du tableau par rapport au graphique */
            width: 60%;
            border-collapse: collapse;
            margin: 0 auto;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color:rgb(67, 92, 255);
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Statistiques des Réclamations</h2>
    <canvas id="chart"></canvas>

    <!-- Tableau des pourcentages -->
    <table>
        <thead>
            <tr>
                <th>Statut</th>
                <th>Pourcentage</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($counts as $index => $count): ?>
                <tr>
                    <td><?= $labels[$index] ?></td>
                    <td><?= number_format(($count / $total) * 100, 2) ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Réclamations',
                    data: <?= json_encode($counts) ?>,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                const percentage = tooltipItem.raw / tooltipItem.dataset._meta[Object.keys(tooltipItem.dataset._meta)[0]].total * 100;
                                return tooltipItem.label + ': ' + percentage.toFixed(2) + '%';
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = 0;
                            let dataArr = ctx.chart.data.datasets[0].data;
                            dataArr.map(data => {
                                sum += data;
                            });
                            let percentage = (value / sum) * 100;
                            return percentage.toFixed(2) + '%';
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 14
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
