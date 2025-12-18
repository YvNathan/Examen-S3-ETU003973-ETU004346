<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de Bénéfices</title>

    <link rel="stylesheet" href="/assets/styles.css">

    <style>
        .container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .back {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            margin: 0;
        }

        .filters {
            background: #f4f4f4;
            padding: 1.5rem;
            border-radius: 4px;
            margin-bottom: 2rem;
        }

        .filters form {
            display: flex;
            gap: 1rem;
            align-items: flex-end;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            margin-bottom: 0.3rem;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .filter-group input,
        .filter-group select {
            padding: 0.4rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        th {
            background: #f4f4f4;
            text-align: center;
            color: #333;
        }

        td {
            text-align: center;
            color: #333;
        }

        tfoot td {
            background: #e8f5e9;
            font-weight: bold;
            color: #1b5e20;
        }

        .empty {
            padding: 12px;
            background: #fffbe6;
            border: 1px solid #ffe58f;
            text-align: center;
        }

        .btn {
            padding: 0.5rem 1rem;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background: #218838;
        }

        .btn-secondary {
            background: #6c757d;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .btn-info {
            background: #17a2b8;
        }

        .btn-info:hover {
            background: #138496;
        }
    </style>
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
</body>

</html>