<div class="col-9 ps-5 py-3" id="main-content">


    <h2 class="text-center">Analisis Real</h2>

    <?php
        foreach ($kelas as $kl) : ?>

        <div class="row align-items-start mt-5 mb-4">
            <div class="col">
                <p>Semester <?php echo $kl->semester ?></p>
                <p><?php echo $kl->hari ?>, <?php echo $kl->waktu ?></p>
            </div>
            <div class="col">
                <div class="btn-group-vertical" style="float: right;">
                    <button class="mb-2" style="background-color:orange !important;">Absensi</button>
                    <button class="mb-2" style="background-color:orange !important;">Tugas</button>
                    <button style="background-color:orange !important;">Penanggungjawab</button>
    
                </div>
            </div>
        </div>
    
        <hr>
    
        <div class="row mt-4 mb-3">
            <div class="col">
                <h4><?php echo $tugas['nama_tugas'] ?></h4>
            </div>
        </div>
        
        <form action="<?php base_url('dosen/tambah_nilai'); ?>" method="post" class="mt-4">
            <?php foreach ($mhskelas as $mk) : ?>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5 ><?php echo $mk->nama ?></h5>
                </div>
                <div class="col">
                    <input type="number" class="form-control" id="nilai" name="nilai[]">
                </div> 
                <input type="hidden" class="form-control" id="mhs_id" name="mhsid[]" value="<?php echo $mk->mahasiswa_id ?>"/>  
            </div>
            <?php endforeach; ?>

                <button type="submit" class="mb-2" style="background-color:orange !important; float:right;">Tambah</button>
        </form>
        <?php echo validation_errors(); ?>
    <?php endforeach; ?>
    </div>
    
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php if ($this->session->flashdata('success')) { ?>  
        Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        })
    <?php $this->session->unset_userdata('success'); ?>
    <?php } ?>
</script>