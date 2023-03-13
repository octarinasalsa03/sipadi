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
          <a class="nav-link active" aria-current="page" href="<?= base_url('auth'); ?>">Home</a>
          <a class="logout nav-link" href="<?= base_url('auth'); ?>">Login</a>

      </div>
    </div>
  </div>
</nav>

<section style="background: rgb(255,166,0);
background: linear-gradient(0deg, rgba(255,166,0,0.9948354341736695) 15%, rgba(249,255,105,1) 50%);">
<div class="container-fluid min-vh-100 d-flex flex-column">
    <div class="row align-items-start mt-5 pt-5 row-home">     
        <div class="card border-0 col-lg-4 mt-5 mx-auto my-auto">
            <div class="card-body">
                <h6 class="mt-3 text-center"><b>REGISTER DOSEN</b></h6>
                <hr style="width:80%" class="mx-auto">
                
                <form method="post" class="mt-4">
                    <div class="mb-2 ms-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" />
                        <small class="text-danger"><?= form_error('name'); ?></small>
                    </div>
                    <div class="mb-2 ms-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
                        <small class="text-danger"><?= form_error('email'); ?></small>
                    </div>
                    <div class="mb-2 ms-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                        <small class="text-danger"><?= form_error('password'); ?></small>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn mt-2 px-5"><b>Submit</b></button>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</div>
</section>