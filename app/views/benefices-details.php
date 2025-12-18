<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des livraisons</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .container {
            max-width: 1600px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            font-size: 0.85rem;
        }

        th, td {
            padding: 0.65rem 0.5rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background: #343a40;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 0.25rem 0.6rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }

        .positive {
            color: #28a745;
            font-weight: bold;
        }

        .negative {
            color: #dc3545;
            font-weight: bold;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 1rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .empty {
            padding: 2rem;
            text-align: center;
            background: #f8f9fa;
            border-radius: 8px;
            color: #6c757d;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            margin: 0;
            color: #333;
        }

        .stats-summary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .stat-item h3 {
            font-size: 0.85rem;
            margin: 0 0 0.5rem 0;
            opacity: 0.9;
        }

        .stat-item .value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices" class="back-link">← Retour au rapport</a>

    <div class="page-header">
        <h1>📋 Détails complets des livraisons</h1>
    </div>

    <?php
    // Calcul des statistiques globales
    $totalLivraisons = count($benefices ?? []);
    $totalCA = 0;
    $totalCouts = 0;
    $totalBenefice = 0;

    if (!empty($benefices)) {
        foreach ($benefices as $row) {
            $totalCA += $row['chiffreAffaires'] ?? 0;
            $totalCouts += ($row['coutLivreur'] ?? 0) + ($row['coutVehicule'] ?? 0);
            $totalBenefice += ($row['chiffreAffaires'] ?? 0) - (($row['coutLivreur'] ?? 0) + ($row['coutVehicule'] ?? 0));
        }
    }

    $margeGlobale = $totalCA > 0 ? ($totalBenefice / $totalCA * 100) : 0;
    ?>

    <!-- Statistiques globales -->
    <?php if ($totalLivraisons > 0): ?>
    <div class="stats-summary">
        <div class="stat-item">
            <h3>Total Livraisons</h3>
            <div class="value"><?= number_format($totalLivraisons) ?></div>
        </div>
        <div class="stat-item">
            <h3>CA Total</h3>
            <div class="value"><?= number_format($totalCA, 2) ?> €</div>
        </div>
        <div class="stat-item">
            <h3>Coûts Totaux</h3>
            <div class="value"><?= number_format($totalCouts, 2) ?> €</div>
        </div>
        <div class="stat-item">
            <h3>Bénéfice Total</h3>
            <div class="value"><?= number_format($totalBenefice, 2) ?> €</div>
        </div>
        <div class="stat-item">
            <h3>Marge Moyenne</h3>
            <div class="value"><?= number_format($margeGlobale, 1) ?> %</div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($benefices)): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Colis</th>
                    <th class="text-right">Poids (Kg)</th>
                    <th class="text-right">Prix/Kg</th>
                    <th class="text-right">CA</th>
                    <th class="text-right">Coût véhicule</th>
                    <th class="text-right">Salaire livreur</th>
                    <th class="text-right">Coût total</th>
                    <th class="text-right">Bénéfice</th>
                    <th class="text-right">Marge</th>
                    <th>Livreur</th>
                    <th>Véhicule</th>
                    <th>Date paiement</th>
                    <th class="text-center">Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($benefices as $row): 
                    $ca = $row['chiffreAffaires'] ?? 0;
                    $coutTotal = ($row['coutLivreur'] ?? 0) + ($row['coutVehicule'] ?? 0);
                    $benefice = $ca - $coutTotal;
                    $marge = $ca > 0 ? ($benefice / $ca * 100) : 0;
                ?>
                <tr>
                    <td><?= htmlspecialchars($row['idLivraison']) ?></td>
                    <td><?= htmlspecialchars($row['dateLivraison']) ?></td>
                    <td><?= htmlspecialchars($row['colis']) ?></td>
                    <td class="text-right"><?= number_format($row['poids_Kg'], 2) ?></td>
                    <td class="text-right"><?= number_format($row['prixKg'], 2) ?> €</td>
                    <td class="text-right"><?= number_format($ca, 2) ?> €</td>
                    <td class="text-right"><?= number_format($row['coutVehicule'], 2) ?> €</td>
                    <td class="text-right"><?= number_format($row['coutLivreur'], 2) ?> €</td>
                    <td class="text-right"><?= number_format($coutTotal, 2) ?> €</td>
                    <td class="text-right <?= $benefice >= 0 ? 'positive' : 'negative' ?>">
                        <?= number_format($benefice, 2) ?> €
                    </td>
                    <td class="text-right <?= $marge >= 0 ? 'positive' : 'negative' ?>">
                        <?= number_format($marge, 1) ?> %
                    </td>
                    <td><?= htmlspecialchars($row['livreur']) ?></td>
                    <td><?= htmlspecialchars($row['vehicule']) ?></td>
                    <td><?= htmlspecialchars($row['datePaiement'] ?? '-') ?></td>
                    <td class="text-center">
                        <span class="badge <?= $row['statut'] === 'Livré' ? 'badge-success' : 'badge-danger' ?>">
                            <?= htmlspecialchars($row['statut']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="empty">
        Aucune livraison terminée à afficher.
    </div>
    <?php endif; ?>

</div>
</body>
</html>