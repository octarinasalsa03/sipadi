<div class="col-9 py-3" id="main-content">

    <div class="mt-3">
        <a href="<?php echo base_url("admin/tambah_kelas/"); ?>"><button>Tambah Kelas</button></a>
    </div>

    <?php
    foreach ($kelas as $kl) : ?>

        <div class="card mt-3 card-kelas">
            <div class="card-body">
                <div class="row">
                    <div>
                        <?php echo $kl->nama ?>
                        <?php echo $kl->kode ?>
                    </div>
                    <div>
                        <?php echo $kl->waktu ?>
                    </div>
                    <div>
                        <?php echo $kl->nama_dosen ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
</div>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php if ($this->session->flashdata('success')) { ?>  
        Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        })
    <?php $this->session->unset_userdata('success'); ?>
    <?php } ?>
</script>