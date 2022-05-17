<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>
            <div id="response"></div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #22228a;">Daftar Jenis Surat</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">No</th>
                                <th style="text-align: left;">Jenis<span style="color: #FFFFFF;">_</span>Surat</th>
                                <th style="width: 5%; text-align: left;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($jenis_surat as $key) {
                                $content = '<tr>';
                                $content .= '<td>'. $no++ .'</td>';
                                $content .= '<td>'. $key->jenis_surat .'</td>';
                                $content .= '<td><a href="'. site_url('admin/jenissurat/'. md5($key->id_jenis_surat)) .'" class="btn btn-primary btn-sm" style="font-weight: bold;"><i class="fas fa-edit"></i></a></td>';
                                $content .= '</tr>';
                                echo $content;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <?php if (isset($row->id_jenis_surat)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold" style="color: #22228a;">Edit Format Surat</h6>
                    </div>
                    <div class="card-body table-responsive">
                        <form action="" method="post" id="form-edit">
                            <input type="text" name="id_jenis_surat" value="<?= $row->id_jenis_surat ?>" style="display: none;">
                            <div class="form-group">
                                <label for="">Jenis Surat</label>
                                <input type="text" class="form-control" value="<?= $row->jenis_surat ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="format_nomor"><span id="label-format_nomor">Nomor Surat</span><span style="color: #dc3545">*</span></label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <span class="input-group-text"><?= $row->nomor_ke ?>.</span>
                                  </div>
                                  <input type="text" id="format_nomor" name="format_nomor" class="form-control" value="<?= $row->format_nomor ?>" autocomplete="off" placeholder="Nomor Surat">

                                  <div class="input-group-append">
                                    <span class="input-group-text">/<?= $bulan_tahun ?></span>
                                  </div>
                                </div>
                                <span id="error-format_nomor" class="error invalid-feedback" style="display: none; font-size: 12px; color: #E74A3B;"></span>
                            </div>
                            <div class="form-group">
                                <label for="paragraf1"><span id="label-paragraf1">Paragraf 1</span><span style="color: #dc3545">*</span></label>
                                <textarea name="paragraf1" id="paragraf1" class="form-control" placeholder="Paragraf 1"><?= $row->paragraf1 ?></textarea>
                                <span id="error-paragraf1" class="error invalid-feedback" style="display: none; font-size: 12px; color: #E74A3B;"></span>
                            </div>
                            <div class="form-group">
                                <label for="paragraf2"><span id="label-paragraf2">Paragraf 2</span><span style="color: #dc3545">*</span></label>
                                <textarea name="paragraf2" id="paragraf2" class="form-control" placeholder="Paragraf 2"><?= $row->paragraf2 ?></textarea>
                                <span id="error-paragraf2" class="error invalid-feedback" style="display: none; font-size: 12px; color: #E74A3B;"></span>
                            </div>
                            <div class="form-group">
                                <label for="paragraf3">Paragraf 3</label>
                                <textarea name="paragraf3" id="paragraf3" class="form-control" placeholder="Paragraf 3"><?= $row->paragraf3 ?></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a href="<?= site_url('admin/jenissurat') ?>" class="btn btn-secondary btn-sm" style="font-weight: bold;"><i class="fas fa-times"></i> Batal</a>
                        <button type="button" class="btn btn-primary btn-sm" onclick="format_surat();" style="font-weight: bold; float: right;"><i class="fas fa-save"></i> Simpan</button>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<script type="text/javascript">

    function format_surat() {
        var errors = [];
        var fields = ['format_nomor', 'paragraf1', 'paragraf2'];
        $.each(fields, function(index, val) {
             if (!$('[name="'+ val +'"]').val()) {
                var label = $('#label-'+ val +'').text();
                $('[name="'+ val +'"]').addClass('is-invalid');
                $('#error-'+ val +'').text(label + ' harus diisi.').show();
                $('[name="'+ val +'"]').keyup(function() {
                    $('[name="'+ val +'"]').removeClass('is-invalid');
                    $('#error-'+ val +'').text('').hide();
                });
                errors.push(val);
             }
        });

        if (errors.length < 1) {
            $('#form-edit').submit();
        }
    }
</script>


</div>