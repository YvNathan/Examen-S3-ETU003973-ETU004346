<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Cooperative</title>
    <link rel="stylesheet" href="<?= Flight::get('flight.base_url') ?>/assets/styles.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="<?= Flight::get('flight.base_url') ?>/" class="logo">Cooperative</a>
                <ul class="menu">
                    <li><a href="<?= Flight::get('flight.base_url') ?>/">Accueil</a></li>
                    <li><a href="<?= Flight::get('flight.base_url') ?>/trajets/rentables">Rentabilite</a></li>
                    <li><a href="<?= Flight::get('flight.base_url') ?>/vehicules/par-jour">Liste Vehicules</a></li>
                    <li><a href="<?= Flight::get('flight.base_url') ?>/salaires/journalier">Salaire journalier</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>

        <h1>Bienvenue sur notre cooperative</h1>

        <section class="product-list">
            <h2>Liste complète des parcours</h2>

            <table border="1" cellpadding="5">

                <tr >
                    <th class="table-header">Départ</th>
                    <th class="table-header">Arrivée</th>
                    <th class="table-header">Action</th>
                </tr>

                <?php foreach ($parcours as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['lieu_depart']) ?></td>
                        <td><?= htmlspecialchars($p['lieu_arrivee']) ?></td>
                        <td><a href="<?= Flight::get('flight.base_url') ?>/parcours/<?= htmlspecialchars($p['id']) ?>" style="text-decoration:none">Voir détail</a></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 Cooperative</p>
    </footer>
</body>
</html>
