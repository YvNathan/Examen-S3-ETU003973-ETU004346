<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trajets les plus rentables par jour</title>
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
        <h1>Trajets les plus rentables par jour</h1>
      
        <form method="get" action="<?= Flight::get('flight.base_url') ?>/trajets/rentables" style="margin: 1rem 0;">
            <label for="jour">Filtrer par jour:</label>
            <input type="date" id="jour" name="jour" value="<?= isset($jour) && $jour ? htmlspecialchars($jour) : '' ?>">
            <button type="submit">Affihcher detail Par date </button>
            <?php if (!empty($jour)): ?>
                <button type="submit"><a href="<?= Flight::get('flight.base_url') ?>/trajets/rentables" style="margin-left: 0.5rem; color : white ; text-decoration: none;">Afficher les plus rentable</a></button>
            <?php endif; ?>
        </form>

        <?php if (!empty($trajetsParJour)): ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>Jour</th>
                    <th>Départ</th>
                    <th>Arrivée</th>
                    <th>Bénéfice</th>
                </tr>
                <?php foreach ($trajetsParJour as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['jour']) ?></td>
                        <td><?= htmlspecialchars($trajet['lieu_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['lieu_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['benefice']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucun trajet n'a encore été enregistré.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Cooperative</p>
    </footer>
</body>
</html>
