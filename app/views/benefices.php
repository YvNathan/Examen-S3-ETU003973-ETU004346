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

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        th {
            background: #f4f4f4;
            text-align: center;
        }

        td {
            text-align: center;
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
    </style>
</head>

<body>
<div class="container">

    <h1>Rapport de Bénéfices</h1>

    <p>
        <a class="back" href="<?= htmlspecialchars($baseUrl ?? '/') ?>">
            ← Retour à l'accueil
        </a>
    </p>

    <div class="filters">
        <form method="get" action="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices">
            <div class="filter-group">
                <label>Année</label>
                <input type="number" name="annee" value="<?= htmlspecialchars($annee ?? '') ?>" min="2020" max="2099">
            </div>

            <div class="filter-group">
                <label>Mois</label>
                <select name="mois">
                    <option value="">-- Tous --</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($mois ?? '') == $m ? 'selected' : '' ?>>
                            <?= $m ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Jour (1–31)</label>
                <select name="jour">
                    <option value="">-- Tous --</option>
                    <?php for ($d = 1; $d <= 31; $d++): ?>
                        <option value="<?= $d ?>" <?= ($jour ?? '') == $d ? 'selected' : '' ?>>
                            <?= $d ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn">Filtrer</button>
            <a href="<?= htmlspecialchars($baseUrl ?? '/') ?>/benefices" class="btn btn-secondary">Réinitialiser</a>
        </form>
    </div>

    <?php if (!empty($benefices) && is_array($benefices)) : ?>

        <table>
            <thead>
                <tr>
                    <?php if (isset($benefices[0]['jour']) && isset($benefices[0]['annee'])): ?>
                        <th>Année</th>
                        <th>Jour</th>
                    <?php elseif (isset($benefices[0]['mois'])): ?>
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
            <?php foreach ($benefices as $row) : ?>
                <tr>
                    <?php if (isset($row['jour']) && isset($row['annee'])): ?>
                        <td><?= htmlspecialchars($row['annee'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['jour'] ?? '') ?></td>
                    <?php elseif (isset($row['mois'])): ?>
                        <td><?= htmlspecialchars($row['annee'] ?? '') ?></td>
                        <td><?= htmlspecialchars(date('F', mktime(0,0,0,$row['mois'],1))) ?></td>
                    <?php else: ?>
                        <td><?= htmlspecialchars($row['annee'] ?? '') ?></td>
                    <?php endif; ?>
                    <td><?= htmlspecialchars(number_format($row['nb_livraisons'] ?? 0)) ?></td>
                    <td><?= htmlspecialchars(number_format($row['ca_total'] ?? 0, 2)) ?> €</td>
                    <td><?= htmlspecialchars(number_format($row['cout_total'] ?? 0, 2)) ?> €</td>
                    <td><?= htmlspecialchars(number_format($row['benefice'] ?? 0, 2)) ?> €</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

    <?php else : ?>
        <p class="empty">Aucune donnée à afficher.</p>
    <?php endif; ?>

</div>
</body>
</html>