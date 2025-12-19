<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails des livraisons</title>
    <?php
    $basePath = rtrim($baseUrl ?? BASE_URL ?? '', '/');
    if ($basePath === '/') {
        $basePath = '';
    }
    $base = htmlspecialchars($basePath, ENT_QUOTES);
    ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
    <style>
        .container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .back {
            display: inline-block;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.85rem;
        }

        th,
        td {
            padding: 0.65rem 0.5rem;
            text-align: left;
            border: 1px solid #ddd;
            color: #333;
        }

        th {
            background: #f4f4f4;
            font-weight: 600;
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

        .empty {
            padding: 12px;
            background: #fffbe6;
            border: 1px solid #ffe58f;
            text-align: center;
        }

        .stats-summary {
            background: #f4f4f4;
            padding: 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .stat-item h3 {
            font-size: 0.85rem;
            margin: 0 0 0.5rem 0;
            color: #666;
        }

        .stat-item .value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .table-wrapper {
            overflow-x: auto;
        }
    </style>
</head>

<body class="app-shell">
    <header class="topbar">
        <div class="topbar__inner">
            <div class="topbar__brand"><a href="<?= $base ?: '/accueil' ?>"></a></div>
            <nav class="topbar__actions">
                <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
                <a class="topbar__link" href="<?= $base ?>/accueil">Réinitialiser</a>
            </nav>
        </div>
    </header>

    <div class="app-grid">
        <aside class="sidebar">
            <div class="sidebar__title">Navigation</div>
            <a class="sidebar__link" href="<?= $base ?: '/accueil' ?>">Accueil</a>
            <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
            <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
            <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
            <a class="sidebar__link is-active" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
            <a class="sidebar__link" href="<?= $base ?>/benefices/vehicules">Bénéfices par véhicule</a>
            <a class="sidebar__link" href="<?= $base ?>/zones">Zones de livraison</a>
        </aside>

        <main class="page">
            <div class="container">
                <h1>Détails des livraisons</h1>

                <?php if (!empty($totaux) && $totaux['nb_livraisons'] > 0): ?>
                    <div class="stats-summary">
                        <div class="stat-item">
                            <h3>Total Livraisons</h3>
                            <div class="value"><?= number_format($totaux['nb_livraisons']) ?></div>
                        </div>
                        <div class="stat-item">
                            <h3>CA Total (Ar)</h3>
                            <div class="value"><?= number_format($totaux['ca_total'], 2) ?></div>
                        </div>
                        <div class="stat-item">
                            <h3>Coûts Totaux (Ar)</h3>
                            <div class="value"><?= number_format($totaux['cout_total'], 2) ?></div>
                        </div>
                        <div class="stat-item">
                            <h3>Bénéfice Total (Ar)</h3>
                            <div class="value"><?= number_format($totaux['benefice'], 2) ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($benefices) && is_array($benefices)) : ?>
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Colis</th>
                                <th class="text-right">Poids (Kg)</th>
                                <th class="text-right">Prix/Kg (Ar)</th>
                                <th>Zone</th>
                                <th class="text-right">Suppl. (%)</th>
                                <th class="text-right">Montant suppl. (Ar)</th>
                                <th class="text-right">CA (Ar)</th>
                                <th class="text-right">Coût véhicule (Ar)</th>
                                <th class="text-right">Salaire livreur (Ar)</th>
                                <th class="text-right">Coût total (Ar)</th>
                                <th class="text-right">Bénéfice (Ar)</th>
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
                                $prixKg = $row['prixKg'] ?? 0;
                                $poids = $row['poids_Kg'] ?? 0;
                                $pourcentage = $row['supplement_pourcentage'] ?? 0;
                                $prixBase = $prixKg * $poids;
                                $montantSupplement = $prixBase * ($pourcentage / 100);
                            ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['dateLivraison'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['colis'] ?? '') ?></td>
                                    <td class="text-right"><?= number_format($poids, 2) ?></td>
                                    <td class="text-right"><?= number_format($prixKg, 2) ?></td>
                                    <td><?= htmlspecialchars($row['zone_livraison'] ?? '-') ?></td>
                                    <td class="text-right"><?= number_format($pourcentage, 2) ?> %</td>
                                    <td class="text-right"><?= number_format($montantSupplement, 2) ?></td>
                                    <td class="text-right"><?= number_format($ca, 2) ?></td>
                                    <td class="text-right"><?= number_format($row['coutVehicule'] ?? 0, 2) ?></td>
                                    <td class="text-right"><?= number_format($row['coutLivreur'] ?? 0, 2) ?></td>
                                    <td class="text-right"><?= number_format($coutTotal, 2) ?></td>
                                    <td class="text-right <?= $benefice >= 0 ? 'positive' : 'negative' ?>">
                                        <?= number_format($benefice, 2) ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['livreur'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['vehicule'] ?? '') ?></td>
                                    <td><?= htmlspecialchars($row['datePaiement'] ?? '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= ($row['statut'] ?? '') === 'Livré' ? 'badge-success' : 'badge-danger' ?>">
                                            <?= htmlspecialchars($row['statut'] ?? '') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <p class="empty">Aucune livraison à afficher.</p>
            <?php endif; ?>

    </div>
    </main>
    </div>
    </main>
    </div>
    <footer class="footer-main">
        &copy; 2025 ETU003973-ETU004346
    </footer>
</body>

</html>