<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statuts des livraisons</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body class="app-shell">
<?php
    $base = rtrim($baseUrl ?? '', '/');
    if ($base === '/') {
        $base = '';
    }
?>

<header class="topbar">
    <div class="topbar__inner">
        <div class="topbar__brand"><a href="<?= $base ?: '/app' ?>">Rojo Logistique</a></div>
        <nav class="topbar__actions">
            <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
            <a class="topbar__link" href="<?= $base ?>/benefices">Rapport bénéfices</a>
        </nav>
    </div>
</header>

<div class="app-grid">
    <aside class="sidebar">
        <div class="sidebar__title">Navigation</div>
        <a class="sidebar__link" href="<?= $base ?: '/app' ?>">Accueil</a>
        <a class="sidebar__link is-active" href="<?= $base ?>/statut">Statuts des livraisons</a>
        <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
        
    </aside>

    <main class="page">
<div class="container">
    <h1>Statuts des livraisons</h1>

    <?php if (!empty($listeStatut) && is_array($listeStatut)) : ?>
        <table>
            <thead>
            <tr>
                <th>Colis</th>
                <th>Destination</th>
                <th>Statut</th>
                <th>Date du statut</th>
                <th>Date paiement</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($listeStatut as $row) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['colis'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['adrDestination'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['statut'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['dateStatut'] ?? '') ?></td>

                    <td>
                        <?php if (strtolower($row['statut'] ?? '') === 'en attente') : ?>
                            <input type="date"
                                   name="datePaiement"
                                   form="form-confirmer-<?= $row['idLivraison'] ?>"
                                   class="date-input"
                                   required>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (strtolower($row['statut'] ?? '') === 'en attente') : ?>
                            <div class="actions">
                                <form id="form-confirmer-<?= $row['idLivraison'] ?>"
                                      method="post"
                                      action="<?= $base ?>/statut/achever">
                                    <input type="hidden"
                                           name="idLivraison"
                                           value="<?= htmlspecialchars($row['idLivraison'] ?? '') ?>">
                                    <button type="submit" class="btn">Confirmer</button>
                                </form>
                                <form method="post"
                                      action="<?= $base ?>/statut/annuler">
                                    <input type="hidden"
                                           name="idLivraison"
                                           value="<?= htmlspecialchars($row['idLivraison'] ?? '') ?>">
                                    <button type="submit" class="btn btn-danger">Annuler</button>
                                </form>
                            </div>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p class="empty">Aucun statut de livraison à afficher.</p>
    <?php endif; ?>
</div>
    </main>
</div>
</main>
</div>
    <footer class="footer-main">
        &copy; 2025 ETU003973-ETU004346 
    </footer>
</body>
</html>