<section id="sidebar">
    <a href="#" class="brand">
        <i class="fa-solid fa-shield-halved"></i>
        <span class="text">Espace&nbsp;admin</span>
    </a>
    <ul class="side-menu top">
        <li class="<?= $page == 'abs' ? 'active' : '' ?>">
            <a href="homeController.php">
                <i class="fa-solid fa-list-check position-relative"></i>
                <span class="text">Abcenses</span>
            </a>
        </li>
        <li class="<?= $page == 'gest' ? 'active' : '' ?>">
            <a href="adminsController.php">
                <i class="fa-solid fa-user"></i>
                <span class="text">Gestionnaires</span>
            </a>
        </li>
        <li class="<?= $page == 'form' ? 'active' : '' ?>">
            <a href="formateursController.php">
                <i class="fa-solid fa-user-tie"></i>
                <span class="text">Formateurs</span>
            </a>
        </li>
        <li class="<?= $page == 'fill' ? 'active' : '' ?>">
            <a href="fillController.php">
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="text">Fillieres</span>
            </a>
        </li>
        <li class="<?= $page == 'grp' ? 'active' : '' ?>">
            <a href="groupeController.php">
                <i class="fa-solid fa-users-rectangle"></i>
                <span class="text">Groupes</span>
            </a>
        </li>
        <li class="<?= $page == 'stg' ? 'active' : '' ?>">
            <a href="stagiairesController.php">
                <i class="fa-solid fa-user-group"></i>
                <span class="text">Stagiaires</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="../../models/security.php?logout=logout" onclick="return confirm('sure?')" class="logout">
                <i class="fa-solid fa-arrow-right-from-bracket" style="transform: rotate(180deg);"></i>
                <span class="text">Logout</span>
            </a>
        </li>
    </ul>
</section>