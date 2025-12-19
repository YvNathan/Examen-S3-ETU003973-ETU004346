<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <?php if (!empty($app) && ($nonce = $app->get('csp_nonce'))): ?>
        <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'nonce-<?= htmlspecialchars($nonce) ?>'">
    <?php endif; ?>
</head>
<body class="app-shell">
<?php
    $base = rtrim($baseUrl ?? '', '/');
    if ($base === '/') {
        $base = '';
    }
    $base = htmlspecialchars($base, ENT_QUOTES);
?>

<header class="topbar">
    <div class="topbar__inner">
        <div class="topbar__brand"><a href="<?= $base ?: '/app' ?>"></a></div>
        <nav class="topbar__actions">
            <a class="topbar__link" href="<?= $base ?>/livraisons/nouveau">+ Nouvelle livraison</a>
            <a class="topbar__link" href="<?= $base ?>/benefices">Rapport bénéfices</a>
        </nav>
    </div>
</header>

<div class="app-grid">
    <aside class="sidebar">
        <div class="sidebar__title">Navigation</div>
        <a class="sidebar__link is-active" href="<?= $base ?: '/app' ?>">Accueil</a>
        <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
        <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
    </aside>

    <main class="page">
        <div class="container">
            
            <div class="logo-container">
                <img src="/assets/images/Logo.png" alt="Rojo Logistique">
            </div>
            
            <h1 class="welcome-title">Bienvenue sur Rojo Logistique</h1>
            
            <div class="menu-grid">
                
                <a class="menu-card success" href="<?= $base ?>/livraisons/nouveau">
                    <div class="menu-card-icon">📦</div>
                    <div class="menu-card-title">Nouvelle livraison</div>
                    <div class="menu-card-description">Créer une nouvelle livraison</div>
                </a>
                
                <a class="menu-card primary" href="<?= $base ?>/statut">
                    <div class="menu-card-icon">🚚</div>
                    <div class="menu-card-title">Statuts</div>
                    <div class="menu-card-description">Voir les statuts des livraisons</div>
                </a>
                
                <a class="menu-card info" href="<?= $base ?>/benefices">
                    <div class="menu-card-icon">📊</div>
                    <div class="menu-card-title">Rapport de bénéfices</div>
                    <div class="menu-card-description">Analyser les performances</div>
                </a>
                
            </div>
            
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