<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport de Bénéfices</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .filters {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .filters form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 0.9rem;
            margin-bottom: 0.3rem;
            color: #555;
            font-weight: 500;
        }

        .filter-group select,
        .filter-group input {
            padding: 0.6rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
            transition: background 0.2s;
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

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }

        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        th {
            background: #343a40;
            color: white;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
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

        .summary-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .summary-item h3 {
            font-size: 0.85rem;
            margin: 0 0 0.5rem 0;
            opacity: 0.9;
        }

        .summary-item .value {
            font-size: 1.5rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="<?= htmlspecialchars($baseUrl ?? '/') ?>" class="back-link">← Retour à l'accueil</a>

    <div class="page-header">
        <h1>📊 Rapport de Bénéfices</h1>
        <a href="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices/details" class="btn btn-info">
            Voir détails complets
        </a>
    </div>

    <!-- Filtres -->
    <div class="filters">
        <form method="get" action="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices">
            <div class="filter-group">
                <label>Période :</label>
                <select name="periode" id="periode" onchange="toggleFilters(this.value)">
                    <option value="jour" <?= ($periode ?? 'jour') === 'jour' ? 'selected' : '' ?>>Par jour</option>
                    <option value="mois" <?= ($periode ?? '') === 'mois' ? 'selected' : '' ?>>Par mois</option>
                    <option value="annee" <?= ($periode ?? '') === 'annee' ? 'selected' : '' ?>>Par année</option>
                </select>
            </div>

            <!-- Filtre pour jour spécifique -->
            <div class="filter-group" id="filter-jour" style="<?= ($periode ?? 'jour') === 'jour' ? '' : 'display:none' ?>">
                <label>Date :</label>
                <input type="date" name="jour" value="<?= htmlspecialchars($jour ?? '') ?>">
            </div>

            <!-- Filtres pour mois -->
            <div class="filter-group" id="filter-annee-mois" style="<?= ($periode ?? '') === 'mois' ? '' : 'display:none' ?>">
                <label>Année :</label>
                <input type="number" name="annee" value="<?= htmlspecialchars($annee ?? date('Y')) ?>" min="2020" max="2099">
            </div>

            <div class="filter-group" id="filter-mois" style="<?= ($periode ?? '') === 'mois' ? '' : 'display:none' ?>">
                <label>Mois :</label>
                <select name="mois">
                    <option value="">Tous les mois</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($mois ?? '') == $m ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Filtre pour année -->
            <div class="filter-group" id="filter-annee-only" style="<?= ($periode ?? '') === 'annee' ? '' : 'display:none' ?>">
                <label>Année :</label>
                <input type="number" name="annee" value="<?= htmlspecialchars($annee ?? date('Y')) ?>" min="2020" max="2099">
            </div>

            <button type="submit" class="btn">Filtrer</button>
            <a href="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices" class="btn btn-secondary">Réinitialiser</a>
        </form>
    </div>

    <script>
        function toggleFilters(periode) {
            document.getElementById('filter-jour').style.display = periode === 'jour' ? '' : 'none';
            document.getElementById('filter-annee-mois').style.display = periode === 'mois' ? '' : 'none';
            document.getElementById('filter-mois').style.display = periode === 'mois' ? '' : 'none';
            document.getElementById('filter-annee-only').style.display = periode === 'annee' ? '' : 'none';
        }
    </script>

    <!-- Calcul du récapitulatif -->
    <?php
    $totalLivraisons = 0;
    $totalCA = 0;
    $totalCouts = 0;
    $totalBenefice = 0;

    if (!empty($benefices)) {
        foreach ($benefices as $row) {
            $totalLivraisons += $row['nb_livraisons'] ?? 0;
            $totalCA += $row['ca_total'] ?? 0;
            $totalCouts += $row['cout_total'] ?? 0;
            $totalBenefice += $row['benefice'] ?? 0;
        }
    }
    ?>

    <!-- Carte récapitulative -->
    <?php if ($totalLivraisons > 0): ?>
    <div class="summary-card">
        <div class="summary-item">
            <h3>Total Livraisons</h3>
            <div class="value"><?= number_format($totalLivraisons) ?></div>
        </div>
        <div class="summary-item">
            <h3>Chiffre d'affaire</h3>
            <div class="value"><?= number_format($totalCA, 2) ?> €</div>
        </div>
        <div class="summary-item">
            <h3>Coûts totaux</h3>
            <div class="value"><?= number_format($totalCouts, 2) ?> €</div>
        </div>
        <div class="summary-item">
            <h3>Bénéfice</h3>
            <div class="value"><?= number_format($totalBenefice, 2) ?> €</div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tableau des bénéfices par période -->
    <h2>Bénéfices par <?= htmlspecialchars($periode ?? 'jour') ?></h2>

    <?php if (!empty($benefices)): ?>
    <table>
        <thead>
            <tr>
                <?php if ($periode === 'jour'): ?>
                    <th>Date</th>
                <?php elseif ($periode === 'mois'): ?>
                    <th>Année</th>
                    <th>Mois</th>
                <?php else: ?>
                    <th>Année</th>
                <?php endif; ?>
                <th class="text-center">Nb livraisons</th>
                <th class="text-right">Chiffre d'affaire</th>
                <th class="text-right">Coûts</th>
                <th class="text-right">Bénéfice</th>
                <th class="text-right">Marge (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($benefices as $row): 
                $benefice = $row['benefice'] ?? 0;
                $ca = $row['ca_total'] ?? 0;
                $marge = $ca > 0 ? ($benefice / $ca * 100) : 0;
            ?>
            <tr>
                <?php if ($periode === 'jour'): ?>
                    <td><?= htmlspecialchars($row['jour']) ?></td>
                <?php elseif ($periode === 'mois'): ?>
                    <td><?= htmlspecialchars($row['annee']) ?></td>
                    <td><?= date('F', mktime(0, 0, 0, $row['mois'], 1)) ?></td>
                <?php else: ?>
                    <td><?= htmlspecialchars($row['annee']) ?></td>
                <?php endif; ?>
                <td class="text-center"><?= number_format($row['nb_livraisons'] ?? 0) ?></td>
                <td class="text-right"><?= number_format($ca, 2) ?> €</td>
                <td class="text-right"><?= number_format($row['cout_total'] ?? 0, 2) ?> €</td>
                <td class="text-right <?= $benefice >= 0 ? 'positive' : 'negative' ?>">
                    <?= number_format($benefice, 2) ?> €
                </td>
                <td class="text-right <?= $marge >= 0 ? 'positive' : 'negative' ?>">
                    <?= number_format($marge, 1) ?> %
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="empty">
        Aucune donnée disponible pour la période sélectionnée.
    </div>
    <?php endif; ?>

</div>
</body>
</html>