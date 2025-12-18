<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .container { 
            max-width: 1000px; 
            margin: 2rem auto; 
            padding: 0 1rem; 
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .logo-container img {
            width: 250px;
            height: 250px;
            object-fit: contain;
        }
        
        .welcome-title {
            text-align: center;
            margin-bottom: 3rem;
            color: #0f1f3a;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }
        
        .menu-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
            text-decoration: none;
            color: white;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
        }
        
        .menu-card.primary {
            background: linear-gradient(135deg, #1f6feb 0%, #3f8cff 100%);
        }
        
        .menu-card.success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }
        
        .menu-card.info {
            background: linear-gradient(135deg, #17a2b8 0%, #20c9e0 100%);
        }
        
        .menu-card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .menu-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .menu-card-description {
            font-size: 0.95rem;
            opacity: 0.9;
        }
        
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
            }
            
            .logo-container img {
                width: 180px;
                height: 180px;
            }
        }
    </style>
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
</body>
</html>