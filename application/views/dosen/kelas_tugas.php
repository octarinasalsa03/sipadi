<div class="col-9 ps-5 py-3" id="main-content">

    <?php
        foreach ($kelas as $kl) : ?>
            <h2 class="text-center"><?php echo $kl->nama ?></h2>


            <div class="row mt-5">
                <div class="col">
                    <p>Semester <?php echo $kl->semester ?></p>
                    <p><?php echo $kl->hari ?>, <?php echo $kl->waktu ?></p>
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
                    <th scope="col">Tugas 1</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($nilai as $index => $n) : ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ?></th>
                        <td><?php echo $n->nama ?></td>
                        <td><?php echo $n->nilai ?></td>
                        <!-- <td><button style="background-color:orange !important;">Edit</button></td> -->
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <?php endforeach; ?>

    </div>




</div>