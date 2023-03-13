<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/'); ?>css/style.css">

    <title>SPD</title>
    
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light fixed-top mb-5">
  <div class="container">

      <a class="navbar-brand" href="">Sistem Peringatan Dini</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav ms-auto">
          <a class="nav-link active" aria-current="page" href="">Home</a>
          <a class="logout nav-link" href="<?= base_url('/register'); ?>">Register</a>

      </div>
    </div>
  </div>
</nav>

<div style="background: rgb(255, 166, 0);
	background: linear-gradient(
		0deg,
		rgba(255, 166, 0, 0.9948354341736695) 15%,
		rgba(247, 255, 44, 1) 50%
	);">
<div class="row align-items-start mt-5 row-home">
            <div class="col text-center my-auto mx-3 p-4 mt-5">
                
                <br>
                <br>
                <br>
                <h3 class="mt-5">Platform untuk memonitor perkembangan mahasiswa serta memberikan peringatan dini berdasarkan hasil yang diperoleh dalam mata kuliah di lingkungan komputer universitas negeri jakarta</h3>
                </div>
            <div class="col" id="login-register my-auto">
            
            <div class="card col-lg-7 mt-5 mx-auto my-auto" id="login-card">
                <div class="card-body text-center">
                    <h6 class="mt-3"><b>LOGIN</b></h6>
                    <hr style="width:80%" class="mx-auto">
                    <form action="<?php base_url('register/'); ?>" method="post" class="mt-4">
                        <div class="mb-2 ms-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" />
                        </div>
                        <div class="mb-2 ms-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                        </div>
                        <button type="submit" class="btn mt-2 px-5"><b>Masuk</b></button>
                    </form>
                </div>
            </div>
    
        </div>

    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>
</html>