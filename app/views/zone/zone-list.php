<h1>Gestion des zones de livraison</h1>
<a href="/zones/add">Ajouter une zone</a>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($zones as $zone): ?>
            <tr>
                <td><?= htmlspecialchars($zone['id']) ?></td>
                <td><?= htmlspecialchars($zone['nom']) ?></td>
                <td>
                    <a href="/zones/edit/<?= $zone['id'] ?>">Modifier</a> |
                    <a href="/zones/delete/<?= $zone['id'] ?>" onclick="return confirm('Supprimer cette zone ?');">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
