<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de réinitialisation</title>
    <?php
        $basePath = rtrim($baseUrl ?? BASE_URL ?? '', '/');
        if ($basePath === '/') {
            $basePath = '';
        }
        $base = htmlspecialchars($basePath, ENT_QUOTES);
    ?>
    <link rel="stylesheet" href="<?= $base ?>/assets/styles.css">
    <style>
        .confirmation-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        }

        .confirmation-box {
            background: white;
            padding: 3rem;
            border-radius: 8px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            text-align: center;
        }

        .confirmation-box h1 {
            color: #dc3545;
            margin-bottom: 1rem;
            font-size: 1.8rem;
        }

        .warning-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dc3545;
        }

        .confirmation-box p {
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.6;
            font-size: 1rem;
        }

        .confirmation-box .alert {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 2rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .code-input-group {
            margin: 2rem 0;
            text-align: left;
        }

        .code-input-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .code-input-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
            text-align: center;
            letter-spacing: 2px;
        }

        .code-input-group input:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 5px rgba(220, 53, 69, 0.3);
        }

        .error-message {
            color: #dc3545;
            margin-top: 0.5rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="confirmation-box">
            <div class="warning-icon">⚠️</div>
            <h1>Attention !</h1>
            <p>Vous êtes sur le point de réinitialiser la base de données.</p>
            <div class="alert">
                <strong>Cette action est irréversible.</strong> Toutes les données suivantes seront supprimées :
                <ul style="text-align: left; margin: 0.5rem 0; padding-left: 1.5rem;">
                    <li>Toutes les livraisons</li>
                    <li>Les statuts de livraison</li>
                    <li>Les affectations</li>
                </ul>
            </div>
            <p>Êtes-vous sûr de vouloir continuer ?</p>
            
            <form method="post" action="<?= $base ?>/reinit/execute" style="margin: 0;">
                <div class="code-input-group">
                    <label for="secret-code">Entrez le code secret pour confirmer :</label>
                    <input type="password" id="secret-code" name="secret_code" placeholder="••••" maxlength="4" required>
                    <div class="error-message" id="error-message">Code incorrect</div>
                </div>
                
                <div class="button-group">
                    <button type="submit" class="btn btn-danger">Réinitialiser</button>
                    <a href="<?= $base ?>/accueil" class="btn btn-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const code = document.getElementById('secret-code').value;
            if (code !== '9999') {
                e.preventDefault();
                document.getElementById('error-message').classList.add('show');
                document.getElementById('secret-code').value = '';
                document.getElementById('secret-code').focus();
            }
        });
    </script>
</body>
</html>
