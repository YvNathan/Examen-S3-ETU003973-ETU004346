<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannes véhicules</title>
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
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <h1>Pannes véhicules</h1>

        <form method="get" action="<?= Flight::get('flight.base_url') ?>/pannes" style="margin: 1rem 0;">
            <label for="idVehicule">Filtrer par véhicule:</label>
            <select id="idVehicule" name="idVehicule">
                <option value="">-- Tous les véhicules --</option>
                <?php foreach ($vehiculesUniques as $vehicule): ?>
                    <option value="<?= $vehicule['idVehicule'] ?>" <?= isset($idVehicule) && $idVehicule == $vehicule['idVehicule'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($vehicule['immatriculation'] . ' - ' . $vehicule['modele']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Filtrer</button>
            <?php if (!empty($idVehicule)): ?>
                <a href="<?= Flight::get('flight.base_url') ?>/pannes" style="margin-left: 0.5rem; padding: 0.45rem 0.75rem; background: #444; color: white; text-decoration: none; border-radius: 4px;">Réinitialiser</a>
            <?php endif; ?>
        </form>

        <?php if (!empty($pannes)): ?>
            <table border="1" cellpadding="5">
                <tr>
                    <th>Immatriculation</th>
                    <th>Modèle</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                    <th>Description</th>
                    <th>Statut</th>
                </tr>
                <?php foreach ($pannes as $panne): 
                    $dateFin = $panne['date_fin'] ? new DateTime($panne['date_fin']) : null;
                    $statut = $dateFin ? 'Réparée' : 'En cours';
                ?>
                    <tr>
                        <td><?= htmlspecialchars($panne['immatriculation']) ?></td>
                        <td><?= htmlspecialchars($panne['modele']) ?></td>
                        <td><?= htmlspecialchars($panne['date_debut']) ?></td>
                        <td><?= $panne['date_fin'] ? htmlspecialchars($panne['date_fin']) : '---' ?></td>
                        <td><?= htmlspecialchars($panne['description'] ?? 'Aucune description') ?></td>
                        <td style="color: <?= $dateFin ? 'green' : 'red' ?>"><?= $statut ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucune panne enregistrée.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2025 Cooperative</p>
    </footer>
</body>
</html>
