<div class="row " id="body-row">

  <div class="sidebar col" id="sidebar" style="background-color: rgba(249,255,105,1);">
      <!-- <a href="" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
        <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Selamat Datang!</span>
      </a> -->
      
        <h5 class="ms-5 mt-3"><?php echo $user['nama']; ?></h5>
        
      <?php if ($user['role'] == 1) : ?>
      <h6 class="ms-5 mt-3">Anda sebagai Mahasiswa</h6>
      <?php elseif ($user['role'] == 2) : ?>
      <h6 class="ms-5 mt-3"> Anda sebagai Dosen</h6>
      <?php elseif ($user['role'] == 3) : ?>
      <h6 class="ms-5 mt-3">Anda sebagai Admin</h6>
      <?php endif; ?>
      <hr>
      <ul class="nav nav-pills flex-column me-2 mb-auto">
      <?php if ($user['role'] == 1) : ?>
        <li class="nav-item">
          <a href="<?= base_url('mahasiswa/profil');?>" class="nav-link" aria-current="page">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
            Data Diri
          </a>
        </li>
        <li>
          <a href="<?= base_url('mahasiswa/kelas');?>" class="nav-link">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Kelas
          </a>
        </li>
      <?php endif; ?>
      <?php if ($user['role'] == 2) : ?>
        <li class="nav-item">
          <a href="<?= base_url('dosen/profil');?>" class="nav-link" aria-current="page">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
            Data Diri
          </a>
        </li>
        <li>
          <a href="<?= base_url('dosen/kelas');?>" class="nav-link">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Kelas
          </a>
        </li>
      <?php endif; ?>
      <?php if ($user['role'] == 3) : ?>
        <li class="nav-item">
          <a href="<?= base_url('admin/profil');?>" class="nav-link" aria-current="page">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
            Data Diri
          </a>
        </li>
        <li>
          <a href="<?= base_url('admin');?>" class="nav-link">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
            Kelas
          </a>
        </li>
      <?php endif; ?>
  
      </ul>
      <hr>
      
  </div>
<!-- </div> -->