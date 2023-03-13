<!-- <div class="content"> -->
<div class="col-9 py-3" id="main-content">


    <?php
    foreach ($kelas as $kl) : ?>
    <a href="<?php echo base_url("dosen/" . $kl->kode . "/" . $kl->id); ?>">
        <div class="card mt-4 card-kelas">
            <div class="card-body">
                <?php echo $kl->nama ?>
                <?php echo $kl->kode ?>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
    <br>
    
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