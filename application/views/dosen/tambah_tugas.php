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

        <form action="<?php base_url('dosen/tambah'); ?>" method="post" class="mt-4">
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Tipe Tugas</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <select class="form-select" id="tipe-tugas" name="tipe-tugas">
                            <option selected>Choose...</option>
                            <option value="Tugas">Tugas</option>
                            <option value="Kuis">Kuis</option>
                            <option value="UTS">UTS</option>
                            <option value="UAS">UAS</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5>Nama Tugas</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="tugas-ke" name="tugas-ke">
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-3">
                <div class="col">
                    <h5 class="mb-4">Bobot</h5>
                </div>
                <div class="col">
                    <div class="input-group">
                        <input type="text" class="form-control" id="bobot" name="bobot">
                    </div>
                </div>
            </div>

            <button type="submit" class="mb-2" style="background-color:orange !important; float:right;">Tambah</button>
        </form>
        <?php endforeach; ?>
    </div>
</div>