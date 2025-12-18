<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/assets/styles.css">
    <style>
        .login-wrapper {
            max-width: 520px;
            margin: 0 auto;
        }
        .login-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            padding: 1.8rem;
        }
        .login-card h2 {
            margin: 0 0 0.5rem 0;
            color: #0f1f3a;
        }
        .login-card p {
            margin: 0 0 1.25rem 0;
            color: #4a5568;
        }
        .form-field { margin-bottom: 1rem; }
        .form-label { display: block; font-weight: 600; margin-bottom: 0.35rem; color: #243b53; }
        .form-input {
            width: 100%;
            padding: 0.65rem 0.75rem;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: #1f6feb;
            box-shadow: 0 0 0 3px rgba(31, 111, 235, 0.18);
            outline: none;
        }
        .login-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        .login-btn {
            background: linear-gradient(120deg, #1f6feb, #3f8cff);
            color: #ffffff;
            border: none;
            padding: 0.75rem 1.2rem;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 12px 28px rgba(31, 111, 235, 0.3);
            transition: transform 0.15s, box-shadow 0.15s;
        }
        .login-btn:hover { transform: translateY(-1px); box-shadow: 0 16px 30px rgba(31, 111, 235, 0.32); }
        .login-btn:active { transform: translateY(0); }
        .muted-link { color: #5a6c84; font-size: 0.95rem; text-decoration: none; }
        .muted-link:hover { text-decoration: underline; }
        .helper { font-size: 0.9rem; color: #718096; margin-top: 0.6rem; }
    </style>
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
        <a class="sidebar__link" href="<?= $base ?: '/app' ?>">Accueil</a>
        <a class="sidebar__link" href="<?= $base ?>/statut">Statuts des livraisons</a>
        <a class="sidebar__link" href="<?= $base ?>/livraisons/nouveau">Créer une livraison</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices">Rapport de bénéfices</a>
        <a class="sidebar__link" href="<?= $base ?>/benefices/details">Détails des livraisons</a>
        <a class="sidebar__link is-active" href="<?= $base ?>/login">Connexion</a>
    </aside>

    <main class="page">
        <div class="login-wrapper">
            <div class="login-card">
                <h2>Connexion</h2>
                <p>Accédez à votre espace de suivi des livraisons.</p>
                <form action="<?= $base ?>/login" method="post">
                    <div class="form-field">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-input" type="email" id="email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="password">Mot de passe</label>
                        <input class="form-input" type="password" id="password" name="password" required>
                    </div>
                    <div class="login-actions">
                        <button type="submit" class="login-btn">Se connecter</button>
                        <a class="muted-link" href="#">Mot de passe oublié ?</a>
                    </div>
                    <div class="helper">Astuce : cette page est une maquette. Branchez votre logique d'authentification ici.</div>
                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>
