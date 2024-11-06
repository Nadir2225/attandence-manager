<nav class="d-flex justify-content-between align-items-center">
    <img class='menu' src="../../view/assets/menu.png" width="30px">
    <div class="rounded-circle d-flex justify-content-center align-items-center" style="color: white; background-color: <?= $currentUser->color ?>; width: 30px; height: 30px; cursor: pointer;" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="<?= ucfirst(strtolower($currentUser->prenom)) , ' ' , ucfirst(strtolower($currentUser->nom)) ?>"><?= strtoupper($currentUser->prenom[0]) ?></div>
</nav>