<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de Bénéfices</title>

    <link rel="stylesheet" href="/assets/styles.css">
</head>

<body class="app-shell">
    <?php
    $base = rtrim($baseUrl ?? '', '/');
    if ($base === '/') {
        $base = '';
    }
    $base = htmlspecialchars($base, ENT_QUOTES);
    ?>

    <header class="topbar">
        <div class="topbar__inner">
            <div class="topbar__brand"><a href="<?= $base ?: '/app' ?>">Rojo Logistique</a></div>
            <nav class="topbar__actions">
                <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
                <a class="topbar__link" href="<?= $base ?>/benefices/details">Détails livraisons</a>
            </nav>
        </div>
    </header>

    <div class="app-grid">
        <aside class="sidebar">
            <div class="sidebar__title">Navigation</div>
            <a class="sidebar__link" href="<?= $base ?: '/app' ?>">Accueil</a>
            <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
            <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
            <a class="sidebar__link is-active" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
            <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
        </aside>

        <main class="page">
            <div class="container">

                <div class="page-header">
                    <h1>Rapport de Bénéfices</h1>
                    <a href="<?= $base ?>/benefices/details" class="btn btn-info">Voir détails complets</a>
                </div>

                <div class="filters">
                    <form method="get" action="<?= $base ?>/benefices">
                        <div class="filter-group">
                            <label>Année</label>
                            <input type="number" name="annee" value="<?= htmlspecialchars($annee ?? '') ?>" min="2020" max="2099">
                        </div>

                        <div class="filter-group">
                            <label>Mois</label>
                            <select name="mois">
                                <option value="">-- Choisir --</option>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= ($mois ?? '') == $m ? 'selected' : '' ?>>
                                        <?= $m ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="filter-group">
                            <label>Jour</label>
                            <select name="jour">
                                <option value="">-- Choisir --</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                    <option value="<?= $d ?>" <?= ($jour ?? '') == $d ? 'selected' : '' ?>>
                                        <?= $d ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn">Filtrer</button>
                        <a href="<?= $base ?>/benefices" class="btn btn-secondary">Réinitialiser</a>
                    </form>
                </div>

                <?php if (!empty($benefices) && is_array($benefices)) : ?>

                    <table>
                        <thead>
                            <tr>
                                <?php if ($affichage === 'date'): ?>
                                    <th>Date</th>
                                <?php elseif ($affichage === 'mois'): ?>
                                    <th>Année</th>
                                    <th>Mois</th>
                                <?php else: ?>
                                    <th>Année</th>
                                <?php endif; ?>
                                <th>Livraisons</th>
                                <th>CA</th>
                                <th>Coûts</th>
                                <th>Bénéfice</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($benefices as $row): ?>
                                <tr>
                                    <?php if ($affichage === 'date'): ?>
                                        <td><?= htmlspecialchars($row['date']) ?></td>
                                    <?php elseif ($affichage === 'mois'): ?>
                                        <td><?= $row['annee'] ?></td>
                                        <td><?= $row['mois'] ?></td>
                                    <?php else: ?>
                                        <td><?= $row['annee'] ?></td>
                                    <?php endif; ?>

                                    <td><?= number_format($row['nb_livraisons']) ?></td>
                                    <td><?= number_format($row['ca_total'], 2) ?> €</td>
                                    <td><?= number_format($row['cout_total'], 2) ?> €</td>
                                    <td><?= number_format($row['benefice'], 2) ?> €</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <?php if ($affichage === 'date'): ?>
                                    <td>TOTAL</td>
                                <?php elseif ($affichage === 'mois'): ?>
                                    <td colspan="2">TOTAL</td>
                                <?php else: ?>
                                    <td>TOTAL</td>
                                <?php endif; ?>
                                <td><?= number_format($totaux['nb_livraisons'] ?? 0) ?></td>
                                <td><?= number_format($totaux['ca_total'] ?? 0, 2) ?> €</td>
                                <td><?= number_format($totaux['cout_total'] ?? 0, 2) ?> €</td>
                                <td><?= number_format($totaux['benefice'] ?? 0, 2) ?> €</td>
                            </tr>
                        </tfoot>
                    </table>

                <?php else : ?>
                    <p class="empty">Aucune donnée à afficher.</p>
                <?php endif; ?>

            </div>
        </main>
    </div>
 <footer class="footer-main">
    &copy; 2025 ETU003973-ETU004346 
  </footer>
</main>
</html>
    