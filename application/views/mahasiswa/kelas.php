<div class="col-9 ms-2 py-3" id="main-content">

  <?php
  foreach ($kelas as $kl) : ?>
    <h2 class="text-center"><?php echo $kl->nama ?></h2>
    <input type="text" class="kelas-val" value="<?php echo $kl->id ?>" hidden>


    <div class="row row-info align-items-start mt-5">
      <div class="col">
        <p>Semester 116</p>
        <p><?php echo $kl->hari ?>, <?php echo $kl->waktu ?></p>
      </div>
      <div class="col">
        <div class="tab">
          <div class="btn-group-vertical" style="float: right;">
            <button class="tablinks btn mb-2" onclick="openTable(event, 'table-data-absensi')">Absensi</button>
            <button class="tablinks btn" onclick="openTable(event, 'table-data-tugas')">Tugas</button>
          </div>
        </div>
      </div>
    </div>

    <div id="table-data-tugas" class="tabcontent">
      <table class="table table-bordered mt-5 mx-auto" id="table-data-tugas" style="width: 90%;">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Tugas</th>
            <th scope="col">Bobot</th>
            <th scope="col">Nilai</th>
          </tr>
        </thead>
        <?php if (!empty($tugas)) : ?>
          <?php
          foreach ($tugas as $index => $tugas) : ?>
            <tbody>
              <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $tugas->nama_tugas ?></td>
                <td><?php echo $tugas->bobot ?></td>
                <td><?php echo $tugas->nilai ?></td>
              </tr>
            </tbody>
          <?php endforeach ?>
        <?php endif; ?>
      </table>
    </div>

    <div id="table-data-absensi" class="tabcontent" style="display: none;">
    <?php if($kl->mahasiswa_id == $mahasiswa['id']) : ?>
      <table class="table table-bordered mt-5 mx-auto" style="width: 90%;">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Pertemuan</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Materi</th>
            <th scope="col">Kehadiran</th>
            <th scope="col">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($kehadiran_encode2)) : ?>
            <?php
            foreach ($kehadiran_encode2[0] as $index => $kehadiran) : ?>
              <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $kehadiran->nama_pertemuan ?></td>
                <td><?php echo $kehadiran->tanggal ?></td>
                <td><?php echo $kehadiran->materi ?></td>
                <?php if ($kehadiran->hadir == 0) : ?>
                  <td>Tidak Hadir</td>
                <?php elseif ($kehadiran->hadir == 1) : ?>
                  <td>Hadir</td>
                <?php else : ?>
                  <td>-</td>
                <?php endif; ?>
                <td><a href="" class="modal-btn" data-custom-value="<?php echo $kehadiran->pertemuan_id ?>" data-bs-toggle="modal" data-bs-target="#presensiModal-<?= $kehadiran->pertemuan_id; ?>" value="<?php echo $kehadiran->pertemuan_id ?>">Isi Presensi</a></td>
              </tr>
            <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
        <?php if ($kl->mahasiswa_id == $mahasiswa['id']) : ?>
          <div class="align-items-start mx-auto" style="float: right; margin-right:70px !important" >
            <a href="<?php echo base_url('mahasiswa/' . $kl->kode . "/" . $kl->id . '/tambah_pertemuan') ?>"><button>Tambah Pertemuan</button></a>
          </div>
        <?php endif; ?>
        
      <?php else : ?>
        <table class="table table-bordered mt-5 mx-auto" style="width: 90%;">
        <thead>
          <tr>
            <th scope="col">No</th>
            <th scope="col">Pertemuan</th>
            <th scope="col">Tanggal</th>
            <th scope="col">Kehadiran</th>
          </tr>
        </thead>
        <tbody>
        <?php if(!empty($kehadiran_encode2)) : ?>
          <?php
          foreach ($kehadiran_encode2[0] as $index => $kehadiran) : ?>
            <tr>
              <th scope="row"><?php echo $index + 1 ?></th>
              <td><?php echo $kehadiran->nama_pertemuan ?></td>
              <td><?php echo $kehadiran->tanggal ?></td>
              <?php if ($kehadiran->hadir == 0) : ?>
                <td>Tidak Hadir</td>
              <?php else : ?>
                <td>Hadir</td>
              <?php endif; ?>
            </tr>
          <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
</div>
    

<?php if (!empty($kehadiran_encode2)) : ?>
<?php
foreach ($kehadiran_encode2[0] as $index => $kehadiran) : ?>
  <div class="modal fade" id="presensiModal-<?= $kehadiran->pertemuan_id; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="<?php base_url('mahasiswa/kelas_detail/' . $kl->kode . "/" . $kl->id); ?>" method="post">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Isi Presensi</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <?php
          foreach ($kehadiran->presensi_mhs as $key => $kehadiran_mahasiswa) : ?>
            <div class="card ms-3 me-4 mt-2 card-kelas">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-4">
                    <?php echo $kehadiran_mahasiswa->mahasiswa->nama_mahasiswa ?>
                  </div>
                  <?php if ($kehadiran_mahasiswa->mahasiswa->hadir == 0) : ?>
                  <div class="col">
                  <!-- <input type="checkbox" id="mahasiswa_id" name="mahasiswa_id[]" style="float:right;" value=""> -->
                  <input type="radio" id="hadir" name="kehadiran[<?php print $key ?>]" value="1">
                  <label for="hadir">Hadir</label><br>
                  <input type="radio" id="age2" name="kehadiran[<?php print $key ?>]" value="0">
                  <label for="tidak_hadir">Tidak Hadir</label><br>
                  <input type="text" id="kelas_id" name="kelas_id[<?php print $key ?>]" value="<?php echo $kl->id ?>" hidden>
                  <input type="text" id="kehadiran_id" name="kehadiran_id[<?php print $key ?>]" value="<?php echo $kehadiran->pertemuan_id ?>" hidden> 
                  <input type="text" id="mahasiswa_id" name="mahasiswa_id[<?php print $key ?>]" value="<?php echo $kehadiran_mahasiswa->mahasiswa->mahasiswa_id ?>" hidden> 
                  </div>
                  <?php else : ?>
                    <div class="col" hidden>
                  </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

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


  
</script>