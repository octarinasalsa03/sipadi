<nav class="navbar navbar-expand-lg navbar-light fixed-top mb-5">
  <div class="container">
      <a class="navbar-brand" href="<?= base_url('auth'); ?>">
      <img src="<?= base_url('assets/'); ?>img/logo unj.png" alt="Logo" height="50px">
        SIPADI
    </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link active" aria-current="page" href="">Home</a>
          <a class="logout nav-link" href="<?= base_url('auth/register'); ?>">Register</a>

      </div>
    </div>
  </div>
</nav>

<section 
style="background: rgb(255,166,0);
background: linear-gradient(0deg, rgba(255,166,0,0.9948354341736695) 15%, rgba(249,255,105,1) 50%);"
>
    <div class="container-fluid min-vh-100 d-flex flex-column">
        <div class="row align-items-start mt-5 row-home ms-2">
            <div class="col my-auto mx-3 p-4 mt-5">
            <br>
                <br>
                <br>
                <br>
                <h1>Sistem Peringatan Dini</h1>
            <h4 class="mt-5">Platform untuk memonitor perkembangan mahasiswa serta memberikan peringatan dini berdasarkan hasil yang diperoleh dalam mata kuliah di lingkungan Rumpun Matematika Universitas Negeri Jakarta</h4>
            </div>
            <div class="col" id="login-register my-auto">
            <div class="card border-0 col-lg-7 mt-5 mb-3 mx-auto my-auto" id="login-card">
                    <div class="card-body">
                    <div class="mt-3 text-center">
                        <h6><b>LOGIN</b></h6>
                    </div
                        <hr style="width:80%" class="mx-auto">
                        <form method="post" class="mt-4">
                            <div class="mb-2 ms-3">
                                <input type="emailsss" class="form-control" id="email" name="email" placeholder="Email" />
                                <small class="text-danger"><?= form_error('email'); ?></small>
                            </div>
                            <div class="mb-2 ms-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                                <small class="text-danger"><?= form_error('password'); ?></small>
                            </div>
                            <div class="text-center">
                            <button type="submit" class="btn mt-2 px-5"><b>Masuk</b></button>
                            </div>
                        </form>
                    </div>
                </div>
    
            </div>
        </div>

    </div>
</section>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        <?php if ($this->session->flashdata('success')) : ?>  
            Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "<?php echo $this->session->flashdata('success') ?>"
            })
        <?php $this->session->unset_userdata('success'); ?>
        <?php endif; ?>

        <?php if ($this->session->flashdata('failed')) : ?>  
            Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "<?php echo $this->session->flashdata('failed') ?>",
            })
        <?php $this->session->unset_userdata('failed'); ?>
        <?php endif; ?>
    </script>