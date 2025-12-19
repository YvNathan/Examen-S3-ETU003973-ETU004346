<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bénéfices par véhicule</title>
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
        <a class="sidebar__link is-active" href="<?= $base ?>/benefices/vehicules">Bénéfices par véhicule</a>
        <a class="sidebar__link" href="<?= $base ?>/zones">Zones de livraison</a>
    </aside>

    <main class="page">
        <div class="container">
            <h1>Bénéfices par véhicule</h1>
            <?php if (!empty($vehicules)) : ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Immatriculation</th>
                            <th>Modèle</th>
                            <th class="text-right">Livraisons</th>
                            <th class="text-right">CA (Ar)</th>
                            <th class="text-right">Coûts (Ar)</th>
                            <th class="text-right">Bénéfice (Ar)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vehicules as $v): ?>
                            <tr>
                                <td><?= htmlspecialchars($v['immatriculation'] ?? '') ?></td>
                                <td><?= htmlspecialchars($v['modele'] ?? '') ?></td>
                                <td class="text-right"><?= number_format($v['nb_livraisons'] ?? 0) ?></td>
                                <td class="text-right"><?= number_format($v['chiffreAffaires'] ?? 0, 2) ?></td>
                                <td class="text-right"><?= number_format($v['coutRevient'] ?? 0, 2) ?></td>
                                <td class="text-right <?= ($v['benefice'] ?? 0) >= 0 ? 'positive' : 'negative' ?>">
                                    <?= number_format($v['benefice'] ?? 0, 2) ?>
                                </td>
                                <td>
                                    <a class="btn" href="<?= $base ?>/benefices/vehicules/<?= $v['idVehicule'] ?? '' ?>">Voir détails</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <p class="empty">Aucune donnée véhicule.</p>
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
