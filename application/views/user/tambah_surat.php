<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title ?></h1>
    </div>
    <div class="row">

        <div class="col-md-8">
            <div id="response"></div>
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #22228a;"><?= $title ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="width: 5%; text-align: center;">No</th>
                                    <th>Tanggal<span style="color: #fff">_</span>Pengajuan</th>
                                    <th>Nomor<span style="color: #fff">_</span>Surat</th>
                                    <th style="width: 5%; text-align: center;">Semester</th>
                                    <th style="width: 25%; text-align: center;">Surat</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php 
                                $no = 1;
                                foreach ($surat as $key) {

                                    $status_surat = $key->status_surat == 1 ? '<a href="'. site_url('user/print_surat/' . md5($key->id_surat)) .'" target="_blank" class="btn btn-primary btn-sm" style="font-weight: bold;"><i class="fas fa-print"></i> Print</a>' : 'Menunggu Konfirmasi';

                                    $tanggal_pengajuan = $this->surat->getTanggal($key->tanggal);

                                    $tbody = '<tr>';
                                    $tbody .= '<td style="text-align: center;">'. $no++ .'</td>';
                                    $tbody .= '<td>'. $tanggal_pengajuan .'</td>';
                                    $tbody .= '<td>'. $key->nomor_surat .'</td>';
                                    $tbody .= '<td style="text-align: center;">'. $key->smt_mhs .'</td>';
                                    $tbody .= '<td style="text-align: center;">'. $status_surat .'</td>';
                                    $tbody .= '</tr>';
                                    echo $tbody;
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color: #22228a;">Form Pengajuan Surat</h6>
                </div>
                <div class="card-body">
                    <form action="" method="post" id="form-pengajuan_surat">
                        <div class="form-group" style="display: none;">
                            <input type="text" name="jenis_surat_id" value="<?= $jenis_surat_id ?>">
                            <input type="text" name="program_studi_id" value="<?= $user['program_studi_id'] ?>">
                            <input type="text" name="tahun_masuk" value="<?= $user['tahun_masuk'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="">NIM</label>
                            <input type="text" class="form-control" value="<?= $user['nim'] ?>" disabled="">
                        </div>
                        <div class="form-group">
                            <label for="">Nama Mahasiswa</label>
                            <input type="text" class="form-control" value="<?= $user['nama'] ?>" disabled="">
                        </div>
                        <div class="form-group">
                            <label for="smt_mhs">Semester</label>
                            <select name="smt_mhs" id="smt_mhs" class="form-control">
                                <option value="">-- Semester --</option>
                                <?php for ($i = 1; $i <= 15; $i++) { 
                                    echo '<option value="'. $i .'">'. $i .'</option>';
                                } ?>
                            </select>
                            <span id="error-smt_mhs" class="error invalid-feedback" style="display: none; font-size: 12px; color: #E74A3B;"></span>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary btn-sm" onclick="ajukan_surat();" style="font-weight: bold; float: right;"><i class="fas fa-envelope"></i> Ajukan</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    function ajukan_surat() {
        if ($('[name="program_studi_id"]').val() && $('[name="tahun_masuk"]').val()) {
            if ($('[name="smt_mhs"]').val()) {
                $.ajax({
                    url: '<?= site_url('user/surat_aktif/'. md5($user['id'])) ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        jenis_surat_id: $('[name="jenis_surat_id"]').val(),
                        smt_mhs: $('[name="smt_mhs"]').val(),
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#response').html('');
                            $(window).scrollTop(0);
                            $('<div class="alert alert-success alert-dismissible">'+ response.message +'</div>').show().appendTo('#response');
                            $('.alert').delay(2750).slideUp('slow', function(){
                                $(this).remove();
                            });
                            $('#modal-pengajuan_surat').modal('hide');
                            setTimeout(function() {
                              window.location.reload();
                            }, 3525);
                        } else {
                            $('[name="smt_mhs"]').addClass('is-invalid');
                            $('#error-smt_mhs').text('Surat Keterangan sudah ada').show();
                            $('[name="smt_mhs"]').change(function() {
                              $('[name="smt_mhs"]').removeClass('is-invalid');
                              $('#error-smt_mhs').text('').hide();
                            });
                        }
                    }
                });
                
            } else {
                $('[name="smt_mhs"]').addClass('is-invalid');
                $('#error-smt_mhs').text('Semester harus dipilih').show();
                $('[name="smt_mhs"]').change(function() {
                  $('[name="smt_mhs"]').removeClass('is-invalid');
                  $('#error-smt_mhs').text('').hide();
                });
            }
        } else {
            $('#response').html('');
            $(window).scrollTop(0);
            $('<div class="alert alert-danger alert-dismissible">Data Mahasiswa Belum Lengkap!</div>').show().appendTo('#response');
            $('.alert').delay(2750).slideUp('slow', function(){
                $(this).remove();
            });
        }
    }
</script>


</div>