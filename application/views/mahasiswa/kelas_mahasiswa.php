<div class="col-9 py-3" id="main-content">

    <?php
    foreach ($kelas_decode as $kl) : ?>

        <div class="card mt-4 card-kelas">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                        <a href="<?php echo base_url("mahasiswa/kelas_detail/" . $kl->kode . "/" . $kl->id); ?>">
                            <div>
                                <?php echo $kl->nama ?>
                                <?php echo $kl->kode ?>
                            </div>
                            <div>
                                <?php echo $kl->nama_dosen ?>
                            </div>
                            <div>
                                <?php echo $kl->hari ?>, <?php echo $kl->waktu ?>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <?php if ($kl->gabung == 0) : ?>
                            <a href="<?php echo base_url("mahasiswa/gabung_kelas/" . $kl->id); ?>"><button type="button" style="float:right;">Gabung</button></a>
                        <?php else : ?>
                            <a href="<?php echo base_url("mahasiswa/gabung_kelas/" . $kl->id); ?>"><button type="button" style="float:right; display: none;">Gabung</button></a>
                        <?php endif; ?>
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
        title: 'Berhasil!',
        })
    <?php $this->session->unset_userdata('success'); ?>
    <?php } ?>
</script>