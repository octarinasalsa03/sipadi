<section class="contents">
    <!-- <div class="homesidebar">
        <div style="text-align:center;">
            <img src="https://www.freeiconspng.com/uploads/am-a-19-year-old-multimedia-artist-student-from-manila--21.png" style="width: 150px !important;"/>
            <h4 class="mt-3">Octarina</h4>
        </div>
        <a href="#services">Services</a>
        <a href="#clients">Clients</a>
        <a href="#contact">Contact</a>
    </div> -->


    <div class="container-fluid" style="background-color: rgba(249,255,105,1);">
        <div class="row">
            <h2 class="text-center mt-4">Selamat datang, <?php echo $user['nama'] ?></h2>
            <h4 class="text-center mb-5">Cek Performa Anda dalam Mata Kuliah!</h4>
        </div>
        <div class="container">
            <div class="row mt-4">
                <button class="mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:orange !important; width:auto">Daftar Kelas</button>
            </div>
        </div>
    </div>
    <?php if ($kelas_mahasiswa == null ) : ?>
    <div class="content-wrapper" id="warning-section" style="background-color:white">
        <p class="text-center mt-3">Silakan pilih kelas terlebih dahulu!</p>
        
    </div>
    <?php else : ?>
        <div class="content-wrapper" id="warning-section">
        <div class="row justify-content-center ms-5 me-5 mt-3 mb-5">
            <div class="col col-6">
                <div class="card" style="box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);">
                    <div class="card-body ms-2 me-2" id="card-home">
                        <h5 class="text-center mb-3" style="font-weight:700;"><?php echo $kelas_mahasiswa[0]->nama ?> <?php echo $kelas_mahasiswa[0]->kode ?></h6>
                            <h6 style="font-weight:700;">Kehadiran: <?php echo $jumlah_kehadiran; ?>/<?php echo $jumlah_pertemuan; ?></h6>
                            <h6 style="font-weight:700;">Ketidakhadiran: <?php echo $jumlah_ketidakhadiran; ?>/<?php echo $jumlah_pertemuan; ?></h6>
                            <?php if ($jumlah_ketidakhadiran >= 2 ) : ?>
                                <p style="color:red;">Batas maksimal ketidakhadiran hanya 3 kali!</p>
                            <?php endif; ?>
                            <h6 class="mt-2" style="font-weight:700;">Nilai:</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Rata-Rata Tugas</th>
                                        <th scope="col">UTS</th>
                                        <th scope="col">UAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php if($nilai != null) : ?>
                                            <?php if($nilai[0]->tugas == null) : ?>
                                            <td>-</td>
                                            <?php else : ?>
                                            <td><?php echo $nilai[0]->tugas?></td>
                                            <?php endif; ?>
                                            <?php if ($nilai[0]->uts == null) : ?>
                                            <td>-</td>
                                            <?php else : ?>
                                            <td><?php echo $nilai[0]->uts?></td>
                                            <?php endif; ?>
                                            <?php if ($nilai[0]->uas == null) : ?>
                                            <td>-</td>
                                            <?php else : ?>
                                            <td><?php echo $nilai[0]->uas?></td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if($kelas_mahasiswa != null) : ?>
                                <a href="<?= base_url('/mahasiswa/kelas_detail/' . $kelas_mahasiswa[0]->kode . "/" . $kelas_mahasiswa[0]->kelas_id ); ?>">Lihat detail nilai</a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col col-6">
                <div class="card" style="box-shadow: 0 3px 10px rgb(0 0 0 / 0.2);" id="card-home">
                    <div class="card-body ms-2 me-2">
                        <h5 class="text-center mb-4" style="font-weight:700;">Progress</h5>
                        <h6 style="font-weight:700;">Peringatan</h6>
                        <?php if ($kelas_mahasiswa[0]->warning == "Tidak aman") : ?>
                            <div>
                                <span class="square" style="background-color: red; border-style:solid; border-color:black; width: 30px; height: 30px;"></span>
                                <span class="square" style="background-color: rgba(255,255,0,0.7);"></span>
                                <span class="square" style="background-color: rgba(0,255,0,0.7);"></span>
                        </div>
                            <p>Nilai Anda <span style="color: red; font-weight:bold">TIDAK AMAN</span> untuk lulus dari mata kuliah <?php echo $kelas_mahasiswa[0]->nama ?>!</p>
                            <h6 class="mt-4" style="font-weight: 700;">Saran</h6>
                            <p>Anda harus memperbaiki metode pembelajaran Anda supaya dapat memperbaiki progres pembelajaran Anda</p>
                        <?php elseif ($kelas_mahasiswa[0]->warning == "Tidak cukup aman") : ?>
                            <div>
                                <span class="square" style="background-color: red;"></span>
                                <span class="square" style="background-color: rgba(255,255,0,0.7); border-style:solid; border-color:black; width: 30px; height: 30px;"></span>
                                <span class="square" style="background-color: rgba(0,255,0,0.7);"></span>
                            </div>
                            <p>Nilai Anda <span style="color: #FFE600; font-weight:bold">TIDAK CUKUP AMAN</span> untuk lulus dari mata kuliah <?php echo $kelas_mahasiswa[0]->nama ?>!</p>
                            <h6 class="mt-4" style="font-weight: 700;">Saran</h6>
                            <p>Anda harus memperbaiki metode pembelajaran Anda supaya dapat memperbaiki progres pembelajaran Anda</p>
                        <?php elseif ($kelas_mahasiswa[0]->warning == "Aman") : ?>
                            <div>
                                <span class="square" style="background-color: red;"></span>
                                <span class="square" style="background-color: rgba(255,255,0,0.7);"></span>
                                <span class="square" style="background-color: rgba(0,255,0,0.7); border-style:solid; border-color:black; width: 30px; height: 30px;"></span>
                            </div>
                            <p>Nilai Anda <span style="color: rgba(0,255,0,0.7); font-weight:bold">AMAN</span> untuk lulus dari mata kuliah <?php echo $kelas_mahasiswa[0]->nama ?>!</p>
                            <h6 class="mt-4" style="font-weight: 700;">Saran</h6>
                            <p>Anda harus mempertahankan metode belajar Anda yang dapat mempertahankan progres belajar Anda</p>
                        <?php else : ?>
                            <p>-</p>
                            <h6 class="mt-4" style="font-weight: 700;">Saran</h6>
                            <p>-</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (empty($kelas)) : ?>
                    <div class="text-center">
                    <p class="text-center">Gabung kelas terlebih dahulu!</p>
                    <a href="<?= base_url('/mahasiswa/kelas'); ?>">Gabung kelas</a>
                    </div>
                    <?php endif; ?>
                    <?php
                    foreach ($kelas as $kl) : ?>
                        <form action="<?php base_url('mahasiswa/index'); ?>" id="kelasForm" method="post">
                            <div class="card ms-3 me-4 mt-2 card-kelas" >
                                <div class="card-body" >
                                    <?php echo $kl->nama ?>
                                    <?php echo $kl->kode ?>
                                    <input type="text" id="kelas_id" name="kelas_id" value="<?php echo $kl->kelas_id ?>" hidden>
                                    <!-- <input type="text" id="mahasiswa_id" name="mahasiswa_id" value="<?php echo $mahasiswa['id'] ?>" hidden> -->
                                    <button class="btn-kelas" type="submit" value="<?php echo $kl->id ?>">Pilih</button>
                                </div>
                            </div>
                    </form>
                    <?php endforeach; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        <?php if ($this->session->flashdata('success')) : ?>  
            Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            })
        <?php $this->session->unset_userdata('success'); ?>
        <?php endif; ?>
    </script>

    <!-- <script>
        $(document).ready(function() {
            $(".btn-kelas").click(function(event) {
                var id = $(this).val();
                console.log(id);

            });

            });
    </script> -->

</section>