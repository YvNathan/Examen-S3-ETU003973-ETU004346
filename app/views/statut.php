<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statuts des livraisons</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .container { max-width: 960px; margin: 2rem auto; padding: 0 1rem; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background: #f4f4f4; text-align: left; }
        .empty { padding: 12px; background: #fffbe6; border: 1px solid #ffe58f; }
        .back { display:inline-block; margin-bottom:1rem; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Statuts des livraisons</h1>
        <p><a class="back" href="/">← Retour à l’accueil</a></p>

        <?php if (isset($listeStatut) && is_array($listeStatut) && count($listeStatut) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Colis</th>
                        <th>Destination</th>
                        <th>Statut</th>
                        <th>Date du statut</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($listeStatut as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['descrip'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['adrDestination'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['statut'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['dateStatut'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="empty">Aucun statut de livraison à afficher.</p>
        <?php endif; ?>
    </div>
</body>
</html>