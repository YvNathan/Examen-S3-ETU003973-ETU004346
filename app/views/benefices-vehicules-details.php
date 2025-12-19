<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails véhicule</title>
    <?php
        $basePath = rtrim($baseUrl ?? BASE_URL ?? '', '/');
        if ($basePath === '/') { $basePath = ''; }
        $base = htmlspecialchars($basePath, ENT_QUOTES);
    ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
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
        <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices/vehicules">Bénéfices par véhicule</a>
        <a class="sidebar__link" href="<?= $base ?>/zones">Zones de livraison</a>
        <a class="sidebar__link is-active" href="#">Détails véhicule</a>
    </aside>

    <main class="page">
        <div class="container">
            <h1>Détails du véhicule #<?= htmlspecialchars($idVehicule) ?></h1>

            <?php if (!empty($details)) : ?>
                <div class="stats-summary">
                    <div class="stat-item">
                        <h3>Livraisons</h3>
                        <div class="value"><?= number_format($totaux['nb'] ?? 0) ?></div>
                    </div>
                    <div class="stat-item">
                        <h3>CA (Ar)</h3>
                        <div class="value"><?= number_format($totaux['ca'] ?? 0, 2) ?></div>
                    </div>
                    <div class="stat-item">
                        <h3>Coûts Totaux (Ar)</h3>
                        <div class="value"><?= number_format(($totaux['coutVehicule'] ?? 0) + ($totaux['coutLivreur'] ?? 0), 2) ?></div>
                    </div>
                    <div class="stat-item">
                        <h3>Bénéfice (Ar)</h3>
                        <div class="value <?= ($totaux['benefice'] ?? 0) >= 0 ? 'positive' : 'negative' ?>">
                            <?= number_format($totaux['benefice'] ?? 0, 2) ?>
                        </div>
                    </div>
                </div>

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
                                <th>Date paiement</th>
                                <th class="text-center">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $row):
                                $ca = $row['chiffreAffaires'] ?? 0;
                                $cv = $row['coutVehicule'] ?? 0;
                                $cl = $row['coutLivreur'] ?? 0;
                                $benef = $ca - ($cv + $cl);
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
                                <td class="text-right"><?= number_format($cv, 2) ?></td>
                                <td class="text-right"><?= number_format($cl, 2) ?></td>
                                <td class="text-right"><?= number_format($cv + $cl, 2) ?></td>
                                <td class="text-right <?= $benef >= 0 ? 'positive' : 'negative' ?>">
                                    <?= number_format($benef, 2) ?>
                                </td>
                                <td><?= htmlspecialchars($row['livreur'] ?? '') ?></td>
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
            <?php else: ?>
                <p class="empty">Aucune livraison pour ce véhicule.</p>
            <?php endif; ?>
        </div>
    </main>
</div>
</body>
</html>
    <footer class="footer-main">
        &copy; 2025 ETU003973-ETU004346 
    </footer>
