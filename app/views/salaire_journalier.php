<?php
/** @var array $salaires */
/** @var array $chauffeurs */
/** @var mixed $jour */
/** @var mixed $chauffeurId */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaire journalier</title>
    <link rel="stylesheet" href="/<?= Flight::get('flight.base_url') ?>/assets/styles.css">
</head>
<body>
<header>
    <div class="container">
        <nav>
            <a href="<?= Flight::get('flight.base_url') ?>/" class="logo">Cooperative</a>
            <ul class="menu">
                <li><a href="<?= Flight::get('flight.base_url') ?>/">Accueil</a></li>
                <li><a href="<?= Flight::get('flight.base_url') ?>/trajets/rentables">Trajets rentables</a></li>
                <li><a href="<?= Flight::get('flight.base_url') ?>/vehicules/par-jour">Véhicules par jour</a></li>
                <li><a href="<?= Flight::get('flight.base_url') ?>/pannes">Pannes</a></li>
                <li><a href="<?= Flight::get('flight.base_url') ?>/salaires/journalier">Salaire journalier</a></li>
            </ul>
        </nav>
    </div>
</header>
<main>
    <div class="container">
        <h1>Salaire journalier des chauffeurs</h1>

    <form method="get" action="<?= Flight::get('flight.base_url') ?>/salaires/journalier" class="filters">
        <label for="jour">Jour:</label>
        <input type="date" id="jour" name="jour" value="<?= htmlspecialchars($jour ?? '') ?>">

        <label for="chauffeur_id">Chauffeur:</label>
        <select name="chauffeur_id" id="chauffeur_id">
            <option value="">Tous</option>
            <?php foreach ($chauffeurs as $c): ?>
                <option value="<?= htmlspecialchars($c['id']) ?>" <?= ($chauffeurId == $c['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrer</button>
        <a href="<?= Flight::get('flight.base_url') ?>/salaires/journalier" style="margin-left: 0.5rem; padding: 0.45rem 0.75rem; background: #444; color: white; text-decoration: none; border-radius: 4px;">Réinitialiser</a>
    </form>

    <?php if (!empty($salaires)): ?>
        <table>
            <thead>
                <tr>
                    <th>Jour</th>
                    <th>Chauffeur</th>
                    <th>Salaire journalier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salaires as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['jour']) ?></td>
                        <td><?= htmlspecialchars($row['chauffeur_nom']) ?></td>
                        <td><?= number_format((float)$row['salaire_journalier'], 2, ',', ' ') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune donnée de salaire à afficher.</p>
    <?php endif; ?>
    </div>
</main>
</body>
</html>
