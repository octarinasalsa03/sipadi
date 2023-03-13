<div class="col-9 ps-5 py-3" id="main-content">

        <?php
        foreach ($kelas as $kl) : ?>
            <form action="<?php base_url('mahasiswa/' . $kl->kode . $kl->id . '/tambah_pertemuan'); ?>" method="post" class="mt-4">
                <div class="row mt-4 mb-3">
                    <div class="col">
                        <h5>Pertemuan</h5>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input type="text" class="form-control" id="pertemuan" name="pertemuan" />
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col">
                        <h5>Tanggal</h5>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input type="date" class="form-control" id="tanggal" name="tanggal" />
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mb-3">
                    <div class="col">
                        <h5 class="mb-4">Materi</h5>
                    </div>
                    <div class="col">
                        <div class="input-group">
                            <input type="text" class="form-control" id="materi" name="materi" />
                        </div>
                    </div>
                </div>

                <button type="submit" class="mb-2" style="background-color:orange !important; float:right;">Tambah</button>
            </form>
        <?php endforeach; ?>
    </div>

</div>
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