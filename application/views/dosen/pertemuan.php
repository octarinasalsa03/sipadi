<div class="col-9 ps-5 py-3" id="main-content">


    <?php
        foreach ($kelas as $kl) : ?>
            <h2 class="text-center"><?php echo $kl->nama ?></h2>


            <div class="row mt-5">
                <div class="col">
                    <p>Semester 116</p>
                    <p><?php echo $kl->hari ?>, 10.00 - 11.30</p>
                </div>
                <div class="col">
                    <!-- <div class="btn-group-vertical" style="float: right;">
                        <button class="mb-2" style="background-color:orange !important;">Absensi</button>
                        <button class="mb-2" style="background-color:orange !important;">Tugas</button>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#PJModal" style="background-color:orange !important;">Penanggungjawab</button>

                    </div> -->
                </div>
            </div>

        <table class="table table-bordered mt-5 mx-auto">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($kehadiran_encode2 as $index => $kehadiran) : ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ?></th>
                        <td><?php echo $kehadiran->nama_mahasiswa ?></td>
                        <?php if ($kehadiran->hadir == 0) : ?>
                            <td>Tidak hadir</td>
                        <?php elseif ($kehadiran->hadir == 1) : ?>
                            <td>Hadir</td>
                        <?php else :?>
                            <td>-</td>
                        <?php endif; ?>
                        <!-- <td><button style="background-color:orange !important;">Edit</button></td> -->
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <?php endforeach; ?>

    </div>




</div>