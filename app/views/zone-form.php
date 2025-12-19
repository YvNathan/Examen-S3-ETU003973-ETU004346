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
    <title><?= $action === 'add' ? 'Ajouter' : 'Modifier' ?> une zone</title>
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
            <a class="sidebar__link" href="<?= $base ?>/benefices/vehicules">Bénéfices par véhicule</a>
            <a class="sidebar__link is-active" href="<?= $base ?>/zones">Zones de livraison</a>
        </aside>
        <main class="page">
            <div class="container">
                <h1><?= $action === 'add' ? 'Ajouter' : 'Modifier' ?> une zone de livraison</h1>
                <?php if (!empty($message)): ?>
                    <div class="alert error" style="background:#ffe0e0;color:#900;padding:10px;margin-bottom:15px;">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="">
                    <div style="margin-bottom:15px;">
                        <label>Nom de la zone :<br>
                            <input type="text" name="nom" value="<?= htmlspecialchars($zone['nom'] ?? '') ?>" required style="width:300px;padding:8px;">
                        </label>
                    </div>
                    <div style="margin-bottom:15px;">
                        <label>Supplément (%) :<br>
                            <input type="number" step="0.01" name="pourcentage" value="<?= htmlspecialchars($zone['pourcentage'] ?? 0) ?>" required style="width:150px;padding:8px;">
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <?= $action === 'add' ? 'Ajouter' : 'Enregistrer les modifications' ?>
                    </button>
                    <a href="/zones" class="btn btn-secondary" style="margin-left:10px;">Annuler</a>
                </form>
            </div>
        </main>
    </div>
    <footer class="footer-main">
        &copy; 2025 ETU003973-ETU004346
    </footer>
</body>

</html>