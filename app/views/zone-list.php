<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        $basePath = rtrim($baseUrl ?? BASE_URL ?? '', '/');
        if ($basePath === '/') {
            $basePath = '';
        }
        $base = htmlspecialchars($basePath, ENT_QUOTES);
    ?>
    <title>Zones de livraison</title>
    <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
</head>
<body class="app-shell">
<header class="topbar">
    <div class="topbar__inner">
        <div class="topbar__brand"><a href="<?= $base ?: '/accueil' ?>">AizA</a></div>
        <nav class="topbar__actions">
            <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
            <a class="topbar__link" href="<?= $base ?>/benefices">Rapport bénéfices</a>
        </nav>
    </div>
</header>
<div class="app-grid">
    <aside class="sidebar">
        <div class="sidebar__title">Navigation</div>
        <a class="sidebar__link" href="<?= $base ?: '/accueil' ?>">Accueil</a>
        <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
        <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
        <a class="sidebar__link is-active" href="<?= $base ?>/zones">Zones de livraison</a>
    </aside>
    <main class="page">
        <div class="container">
            <h1>Gestion des zones de livraison</h1>
            <?php if (!empty($message)): ?>
                <?php if (strpos($message, 'succès') !== false): ?>
                    <div class="alert success" style="background:#e0ffe0;color:#006600;padding:15px;margin-bottom:20px;border:1px solid #b2e6b2;border-radius:5px;">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php else: ?>
                    <div class="alert error" style="background:#ffe0e0;color:#900;padding:15px;margin-bottom:20px;border:1px solid #e6b2b2;border-radius:5px;">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <div style="margin-bottom: 20px;">
                <a class="btn btn-primary" href="/zones/add">Ajouter une zone</a>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom de la zone</th>
                        <th>Supplément (%)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($zones)): ?>
                        <tr>
                            <td colspan="4" style="text-align:center;color:#666;padding:20px;">
                                Aucune zone enregistrée pour le moment.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($zones as $zone): ?>
                            <tr>
                                <td><?= htmlspecialchars($zone['id']) ?></td>
                                <td><?= htmlspecialchars($zone['nom']) ?></td>
                                <td><?= htmlspecialchars(number_format($zone['pourcentage'], 2)) ?> %</td>
                                <td>
                                    <a class="btn btn-secondary" href="/zones/edit/<?= $zone['id'] ?>">
                                        Modifier
                                    </a>
                                    <a class="btn btn-danger" href="#" 
                                       onclick="return confirmDeleteZone(<?= $zone['id'] ?>);">
                                        Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <script>
        function confirmDeleteZone(id) {
            const code = prompt('⚠️ Pour supprimer cette zone, entrez le code de confirmation :\n(Toute affectation utilisant cette zone sera marquée comme "inexistante")');
            if (code === '9999') {
                window.location.href = '/zones/delete/' + id;
                return true;
            } else if (code !== null) {
                alert('❌ Code incorrect. La suppression a été annulée.');
            }
            return false;
        }
        </script>
    </main>
</div>
<footer class="footer-main">
    &copy; 2025 ETU003973-ETU004346
</footer>
</body>
</html>