<nav class="navbar fixed-top navbar-expand-lg navbar-light">
    <div class="container">
        <?php if ($user['role'] == 1) : ?>
            <a class="navbar-brand" href="<?= base_url('mahasiswa'); ?>">
            <img src="<?= base_url('assets/'); ?>img/logo unj.png" alt="Logo" height="50px">
            SIPADI
        </a>
        <?php endif; ?>
        <?php if ($user['role'] == 2) : ?>
            <a class="navbar-brand" href="<?= base_url('dosen'); ?>">
            <img src="<?= base_url('assets/'); ?>img/logo unj.png" alt="Logo" height="50px">
            SIPADI
        </a>
        <?php endif; ?>
        <?php if ($user['role'] == 3) : ?>
            <a class="navbar-brand" href="<?= base_url('admin'); ?>">
            <img src="<?= base_url('assets/'); ?>img/logo unj.png" alt="Logo" height="50px">
            SIPADI
        </a>
        <?php endif; ?>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ms-auto ml-auto">
                <?php if ($user['role'] == 1) : ?>
                    <a class="nav-link active" aria-current="page" href="<?= base_url('mahasiswa'); ?>">Home</a>
                <?php endif; ?>
                <?php if ($user['role'] == 2) : ?>
                    <a class="nav-link active" aria-current="page" href="<?= base_url('dosen'); ?>">Home</a>
                <?php endif; ?>
                <?php if ($user['role'] == 3) : ?>
                    <a class="nav-link active" aria-current="page" href="<?= base_url('admin'); ?>">Home</a>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="logout nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://img.icons8.com/small/96/000000/user-male-circle.png" style="width: 30px !important;" />
                        <?php echo $user['nama'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                        <?php if ($user['role'] == 1) : ?>
                            <li><a class="dropdown-item" href="<?= base_url('mahasiswa/profil'); ?>">Profil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Logout</a></li>
                        <?php endif; ?>
                        <?php if ($user['role'] == 2) : ?>
                            <li><a class="dropdown-item" href="<?= base_url('dosen/kelas'); ?>">Profil</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Logout</a></li>
                        <?php endif; ?>
                        <?php if ($user['role'] == 3) : ?>
                            <li><a class="dropdown-item" href="<?= base_url('auth/logout'); ?>">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
            </div>
        </div>
    </div>
</nav>