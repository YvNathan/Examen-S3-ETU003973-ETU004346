<h1><?= ($action === 'edit' ? 'Modifier' : 'Ajouter') ?> une zone de livraison</h1>
<form method="post">
    <label for="nom">Nom de la zone :</label>
    <input type="text" name="nom" id="nom" value="<?= isset($zone) ? htmlspecialchars($zone['nom']) : '' ?>" required>
    <br><br>
    <button type="submit">Enregistrer</button>
    <a href="/zones">Annuler</a>
</form>
