<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statuts des livraisons</title>

    <link rel="stylesheet" href="/assets/styles.css">

    <style>
        .container {
            max-width: 960px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: middle;
        }

        th {
            background: #f4f4f4;
            text-align: center;
        }

        td {
            text-align: center;
        }

        .empty {
            padding: 12px;
            background: #fffbe6;
            border: 1px solid #ffe58f;
            text-align: center;
        }

        .back {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .date-input {
            width: 150px;
            padding: 0.4rem;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 6px;
        }

        .btn {
            padding: 0.5rem 1rem;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn:hover {
            background: #218838;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .actions form {
            margin: 0;
        }
    </style>
</head>

<body>
<div class="container">

    <h1>Statuts des livraisons</h1>

    <p>
        <a class="back" href="<?= htmlspecialchars($baseUrl ?? '/') ?>">
            ← Retour à l'accueil
        </a>
    </p>

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
                    <td><?= htmlspecialchars($row['descrip'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['adrDestination'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['statut'] ?? '') ?></td>
                    <td><?= htmlspecialchars($row['dateStatut'] ?? '') ?></td>

                    <td>
                        <?php if (($row['statut'] ?? '') === 'En attente') : ?>
                            <input type="date"
                                   name="datePaiement"
                                   form="form-<?= $row['idLivraison'] ?>"
                                   class="date-input"
                                   required>
                        <?php else : ?>
                            -
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if (($row['statut'] ?? '') === 'En attente') : ?>
                            <div class="actions">

                                <form id="form-<?= $row['idLivraison'] ?>"
                                      method="post"
                                      action="/statut/achever">

                                    <input type="hidden"
                                           name="idLivraison"
                                           value="<?= htmlspecialchars($row['idLivraison'] ?? '') ?>">

                                    <button type="submit" class="btn">
                                        Confirmer
                                    </button>
                                </form>

                                <form method="post" action="/statut/annuler">

                                    <input type="hidden"
                                           name="idLivraison"
                                           value="<?= htmlspecialchars($row['idLivraison'] ?? '') ?>">

                                    <button type="submit" class="btn btn-danger">
                                        Annuler
                                    </button>
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
</body>
</html>
