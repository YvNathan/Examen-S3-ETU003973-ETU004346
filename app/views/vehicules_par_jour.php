<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Véhicules par jour</title>
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
            </ul>
        </nav>
    </div>
</header>

<main>
    <h1>Véhicules par jour</h1>

    <form method="get" action="<?= Flight::get('flight.base_url') ?>/vehicules/par-jour">
        <label for="jour">Filtrer par jour :</label>
        <input type="date" id="jour" name="jour" value="<?= isset($jour) && $jour ? htmlspecialchars($jour) : '' ?>">
        <button type="submit">Afficher</button>
        <?php if (!empty($jour)): ?>
            <button type="submit"><a href="<?= Flight::get('flight.base_url') ?>/vehicules/par-jour" class="btn" style="text-decoration: none; color: white;">Réinitialiser</a></button>
        <?php endif; ?>
    </form>

    <?php if (!empty($vehiculesParJour)): ?>
      <table>
    <thead>
        <tr>
            <th>Jour</th>
            <th>Véhicule</th>
            <th>Chauffeur</th>
            <th>Km effectués</th>
            <th>Recette</th>
            <th>Carburant</th>
            <th>Bénéfice</th>
            <th>Nb trajets</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vehiculesParJour as $vehicule): ?>
            <tr>
                <td><?= htmlspecialchars($vehicule['jour']) ?></td>
                <td class="vehicule">
                    <span class="modele"><?= htmlspecialchars($vehicule['modele']) ?></span>
                    <span class="immatriculation">(<?= htmlspecialchars($vehicule['immatriculation']) ?>)</span>
                </td>
                <td><?= htmlspecialchars($vehicule['chauffeur_nom']) ?></td>
                <td><?= htmlspecialchars($vehicule['km_effectues']) ?></td>
                <td><?= htmlspecialchars($vehicule['montant_recette']) ?></td>
                <td><?= htmlspecialchars($vehicule['montant_carburant']) ?></td>
                <td><?= htmlspecialchars($vehicule['benefice']) ?></td>
                <td><?= htmlspecialchars($vehicule['nombre_trajets']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <?php else: ?>
        <p>Aucune donnée véhicule pour le moment.</p>
    <?php endif; ?>
</main>

<footer>
    <p>&copy; 2025 Cooperative</p>
</footer>

</body>
</html>
