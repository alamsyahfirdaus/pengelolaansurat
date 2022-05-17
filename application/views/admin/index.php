<!-- Custom styles for this page -->
<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- Bootstrap core JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>
<!-- Page level plugins -->
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div id="response"></div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: #22228a;">Daftar Pengajuan Surat</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 5%; text-align: center;">No</th>
                                <th style="width: 45%; text-align: left;">Data<span style="color: #FFFFFF;">_</span>Mahasiswa</th>
                                <th style="text-align: left;">Pengajuan<span style="color: #FFFFFF;">_</span>Surat</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <span style="font-size: 16px; ">Apakah anda yakin?</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" style="" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger btn-sm" id="btn-delete" style="">Hapus</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-persetujuan">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pengajuan Surat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p style="font-size: 16px;  text-align: justify; margin: 0px;">Apakah anda yakin, akan menyetujui pengajuan surat?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" style="" data-dismiss="modal">Tidak</button>
        <button type="button" class="btn btn-primary btn-sm" id="btn-persetujuan" style="">Setujui</button>
      </div>
    </div>
  </div>
</div>

<div style="display: none;">
    <input type="text" name="id_surat" value="">
    <input type="text" name="nomor_surat" value="">
    <input type="text" name="format_nomor" value="">
</div>

<script type="text/javascript">

var table;

    table = $('#dataTable').DataTable({
      "processing": false,
      "serverSide": true,
      "paging": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "order": [],
      "language": { 
        "infoFiltered": "",
        "sZeroRecords": "",
        "sEmptyTable": "",
        "sSearch": "Cari:"
      },
      "ajax": {
          "url": "<?= site_url('admin/showDataTable/'. md5(time()))?>",
          "type": "POST",
          "data": function(data) {

          },
      },
      "columnDefs": [{ 
          "targets": [0],
          "orderable": false,
      }],
    });

    $('#btn-delete').click(function() {
        $.getJSON('<?= site_url('admin/hapus_surat/') ?>' + $('[name="id_surat"]').val(), function(response) {
            if (response.status) {
                $('#response').html('');
                $('#modal-delete').modal('hide');
                $(window).scrollTop(0);
                $('<div class="alert alert-success alert-dismissible">Berhasil Menghapus Pengajuan Surat</div>').show().appendTo('#response')
                $('.alert').delay(2750).slideUp('slow', function(){
                    $(this).remove();
                });
                table.ajax.reload();
            }
        });
    });

    $('#btn-persetujuan').click(function() {
        $.ajax({
            url: '<?= site_url('admin/setujui_surat/') ?>' + $('[name="id_surat"]').val(),
            type: 'POST',
            dataType: 'json',
            data: {
                nomor_surat: $('[name="nomor_surat"]').val(),
                format_nomor: $('[name="format_nomor"]').val(),
            },
            success: function (response) {
               if (response.status) {
                   $('#response').html('');
                   $('#modal-persetujuan').modal('hide');
                   $(window).scrollTop(0);
                   table.ajax.reload();
                   $('<div class="alert alert-success alert-dismissible">Berhasil Menyetujui Pengajuan Surat</div>').show().appendTo('#response');
                   $('.alert').delay(2750).slideUp('slow', function(){
                       $(this).remove();
                   });
               }
            }
        });
    });

    function status_surat(id) {
        
        $('[name="id_surat"]').val(id).change();
        $('#modal-persetujuan').modal('show');

        // var nomor_surat  = $('[name="nomor_surat_'+ id +'"]').val();
        // var format_nomor = $('[name="format_nomor_'+ id +'"]').val();
        // if (format_nomor) {
        //     $('[name="id_surat"]').val(id).change();
        //     $('[name="nomor_surat"]').val(nomor_surat).change();
        //     $('[name="format_nomor"]').val(format_nomor).change();
        //     $('#modal-persetujuan').modal('show');
            
        // } else {
        //     $('[name="format_nomor_'+ id +'"]').addClass('is-invalid');
        //     $('#error-format_nomor_'+ id +'').text('Nomor Surat harus diisi').show();

        //     $('[name="format_nomor_'+ id +'"]').keyup(function() {
        //       if ($(this).val()) {
        //         $('[name="format_nomor_'+ id +'"]').removeClass('is-invalid');
        //         $('#error-format_nomor_'+ id +'').text('').hide();
        //       }
        //     });
        // }
        
    }

    function hapus_surat(id) {
        $('[name="id_surat"]').val(id).change();
        $('#modal-delete').modal('show');
    }

    $('#userDropdown').click(function() {
        var dropdown = $('#dropdown-menu-user').attr('data-column');
        if (dropdown > 0) {
            $('#dropdown-menu-user').attr('data-column', '0');
            $('#dropdown-menu-user').hide();
        } else {
            $('#dropdown-menu-user').attr('data-column', '1');
            $('#dropdown-menu-user').show();
        }

    });

</script>

<style type="text/css">
    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #22228a;
        border-color: #22228a;
    }
    .page-link {
        position: relative;
        display: block;
        padding: 0.5rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        color: #22228a;
        background-color: #fff;
        border: 1px solid #dddfeb;
    }
    .page-link:focus {
        z-index: 3;
        outline: 0;
        /*box-shadow: 0 0 0 0.2rem rgb(78 115 223 / 25%);*/
        box-shadow: none;
    }
</style>



</div>
