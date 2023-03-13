<div class="col-9 ps-5 py-3" id="main-content">
            <h2 class="text-center"><?php echo $kelas[0]['nama'] ?></h2>
            <div class="row mt-5">
                <div class="col">
                    <p>Semester <?php echo $kelas[0]['semester'] ?></p>
                    <p><?php echo $kelas[0]['hari'] ?>, <?php echo $kelas[0]['waktu'] ?></p>
                </div>
                <div class="col">
                    <div class="btn-group-vertical" style="float: right;">
                        <button class="tablinks btn-general mb-2" onclick="openTable(event, 'table-data-absensi')">Absensi</button>
                        <button class="tablinks btn-general mb-2" onclick="openTable(event, 'table-data-tugas')">Tugas</button>
                        <button class="btn-general" data-bs-toggle="modal" data-bs-target="#PJModal" style="background-color:orange !important;">Penanggungjawab</button>
                    </div>
                </div>
            </div>

            <div class="tabcontent" id="table-data-tugas">
                <table class="table table-bordered mt-5 mx-auto" id="table-data-tugas">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Tugas</th>
                            <th scope="col">Bobot</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($tugas as $index => $t) : ?>
                            <tr>
                                <th scope="row"><?php echo $index + 1 ?></th>
                                <td><?php echo $t['nama_tugas'] ?></td>
                                <td><?php echo $t['bobot'] ?></td>
                                <?php if ($t['status_isi'] == 1) : ?>
                                    <td><a href="<?php echo base_url("dosen/" . $kelas[0]['kode'] . "/" . $kelas[0]['id'] . "/" . $t['id']); ?>"><button class="btn-general">Lihat Nilai</button></a></td>
                                <?php else : ?>
                                    <td><a href="<?php echo base_url("dosen/" . $kelas[0]['kode'] . "/" . $kelas[0]['id'] . "/isi_nilai/" . $t['id']); ?>"><button class="btn-general" >Isi Nilai</button></a></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <?php if ($nilai_mahasiswas != null) : ?>
                <table class="table display nowrap" id="nilai_mhs_table" hidden>
                    <thead>
                        <tr>
                            <?php foreach ($nilai_mahasiswas[0] as $header => $value ) : ?>
                                <th scope="col"><?php echo $header; ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                <?php 
                    foreach ($nilai_mahasiswas as $nilai_mahasiswa):
                        echo "<tr>";
                        foreach ($nilai_mahasiswa as $nm) {
                            echo "<td>{$nm}</td>";
                        }
                        echo "</tr> ";
                    endforeach;
                ?>
                </table>
                <?php endif; ?>
            </div>

    <div id="table-data-absensi" class="tabcontent" style="display: none;">
      <table class="table table-bordered mt-5 mx-auto" style="width: 90%;">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Pertemuan</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Materi</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($pertemuans as $index => $pertemuan) : ?> 
            <tr>
              <th scope="row"><?php echo $index + 1 ?></th>
              <td><?php echo $pertemuan->pertemuan ?></td>
              <td><?php echo $pertemuan->tanggal ?></td>
              <td><?php echo $pertemuan->materi ?></td>
              <td><a href="<?php echo base_url("dosen/" . $kelas[0]['kode'] . "/" . $kelas[0]['id'] . "/pertemuan/" . $pertemuan->id); ?>"><button class="btn-general">Lihat Kehadiran</button></a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
            <div class="btn-group-horizontal mt-2 mb-5" style="float: right;">
                <button data-bs-toggle="modal" data-bs-target="#peringatanModal" style="background-color:orange !important;">Lihat Peringatan</button>
                <a href="<?php echo base_url("dosen/" . $kelas[0]['kode'] . "/" . $kelas[0]['id'] . "/tambah"); ?>"><button style="background-color:orange !important;">Tambah Tugas</button></a>
            </div>
    </div>
</div>

<div class="modal fade" id="PJModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Penanggungjawab Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                foreach ($mahasiswa_kelas as $mahasiswa_kelas) : ?>
                    <div class="card" style="margin-top: 5px !important; height:70px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <p><?php echo $mahasiswa_kelas->nim ?></p>
                                    <p><?php echo $mahasiswa_kelas->nama ?></p>
                                </div>
                                <div class="col">
                                        <?php if ($kelas[0]['mahasiswa_id'] != $mahasiswa_kelas->mahasiswa_id) : ?>
                                            <a style="float: right;" href="<?= base_url('dosen/assign_pj/') . $mahasiswa_kelas->kelas_id . "/" . $mahasiswa_kelas->kode . "/" . $mahasiswa_kelas->mahasiswa_id; ?>"><button>Pilih</button></a>
                                        <?php else : ?>
                                            <button disabled style="float: right;">Terpilih</button></a>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="peringatanModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Peringatan Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                foreach ($kelas_mahasiswa as $km) : ?>
                    <div class="card" style="margin-top: 5px !important; height:70px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">
                                    <p><?php echo $km->nama ?></p>
                                </div>
                                <div class="col-5 text-center">
                                    <?php if ($km->warning == 'Aman') : ?>
                                        <button disabled style="background-color:green; !important"><?php echo $km->warning ?></button>
                                    <?php elseif ($km->warning == 'Tidak cukup aman') : ?>
                                        <button disabled style="background-color:#FFE600; !important"><?php echo $km->warning ?></button>
                                    <?php elseif ($km->warning == 'Tidak aman'): ?>
                                        <button disabled style="background-color:red;!important"><?php echo $km->warning ?></button>
                                    <?php else: ?>
                                        <p>-</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> -->
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function openTable(evt, tableName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tableName).style.display = "";
    evt.currentTarget.className += " active";
  }

    $(document).on('shown.bs.modal', '#PJModal', function() {
        setTimeout(function() {
            $('#PJModal').modal('hide');
        }, 5000);
    });

    $(document).ready(function() {
        $('#nilai_mhs_table').DataTable( {
        header: false,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn-general' } 
        ],
        
        paging: false,
        ordering: false,
        info: false,
        searching: false
    } );
    } );

    <?php if ($this->session->flashdata('success')) { ?>  
            Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            })
        <?php $this->session->unset_userdata('success'); ?>
    <?php } ?>
</script>