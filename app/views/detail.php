<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du parcours</title>
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
            </ul>
        </nav>
    </div>
</header>

<main>
    <h1>Trajets et parcours</h1>

    <h2>Détail du parcours</h2>

    <?php if ($parcours): ?>
        <p class="parcours-details">
            <strong>Départ :</strong> <?= htmlspecialchars($parcours['lieu_depart']) ?><br>
            <strong>Arrivée :</strong> <?= htmlspecialchars($parcours['lieu_arrivee']) ?><br>
            <strong>Distance :</strong> <?= htmlspecialchars($parcours['distance']) ?> km
        </p>

        <hr>

        <h3>Liste des trajets</h3>

        <table>
            <thead>
                <tr>
                    <th>Date début</th>
                    <th>Véhicule</th>
                    <th>Chauffeur</th>
                    <th>Recette</th>
                    <th>Carburant</th>
                    <th>Bénéfice</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trajets as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['date_debut']) ?></td>
                        <td><?= htmlspecialchars($t['modele']) ?> (<?= htmlspecialchars($t['immatriculation']) ?>)</td>
                        <td><?= htmlspecialchars($t['chauffeur_nom']) ?></td>
                        <td><?= htmlspecialchars($t['recette']) ?></td>
                        <td><?= htmlspecialchars($t['carburant']) ?></td>
                        <td><?= htmlspecialchars($t['benefice']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p class="no-data">Aucun parcours trouvé.</p>
    <?php endif; ?>

</main>

<footer>
    <p>&copy; 2025 Cooperative</p>
</footer>

</body>
</html>
