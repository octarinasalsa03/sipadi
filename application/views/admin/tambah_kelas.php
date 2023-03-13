<div class="col-9 ps-5 py-3" id="main-content">

        <form action="<?php base_url('admin/tambah_kelas'); ?>" method="post" class="mt-4">
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Semester</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="semester" name="semester" />
                    </div>
                    <small class="text-danger"><?= form_error('semester'); ?></small>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Kode Seksi</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="kodeseksi" name="kodeseksi" />
                    </div>
                    <small class="text-danger"><?= form_error('kodeseksi'); ?></small>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Hari</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="hari" name="hari" />
                    </div>
                    <small class="text-danger"><?= form_error('hari'); ?></small>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5 class="mb-4">Jam</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="time" class="form-control" id="waktu" name="waktu" />
                        <small class="text-danger"><?= form_error('waktu'); ?></small>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Dosen Pengajar</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <select class="form-select" id="dosen" name="dosen">
                            <option selected>Pilih dosen...</option>
                            <?php
                            foreach ($dosens as $dosen) : ?>
                                <option value="<?php echo $dosen->id ?>"><?php echo $dosen->nama ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <small class="text-danger"><?= form_error('dosen'); ?></small>
                </div>
            </div>

            <button type="submit" class="mb-2" style="background-color:orange !important; float:right;">Tambah</button>
        </form>
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