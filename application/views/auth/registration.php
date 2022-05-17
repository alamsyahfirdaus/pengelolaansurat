<!-- Nested Row within Card Body -->
<div class="container">
  <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
    <div class="card-body p-0">
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <img src="<?= base_url('assets/img/logo_umtas.png') ?>" alt="" style="width: 100px; margin-bottom: 6px;">
              <h1 class="h4 text-gray-900 mb-4" style="font-weight: bold;">Pendaftaran Akun Baru</h1>
            </div>
            <form class="user" method="post" action="<?= base_url('auth/registration'); ?>">
              <div class="form-group">
                <input type="text" class="form-control form-control-user <?php if(form_error('nama')) echo 'is-invalid' ?>" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= set_value('nama'); ?>" autocomplete="off">
                <?= form_error('nama', '<small class="text-danger pl-3">', '</small>');?>
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user <?php if(form_error('nim')) echo 'is-invalid' ?>" id="nim" name="nim" placeholder="Nomor Induk Mahasiswa (NIM)" value="<?= set_value('nim'); ?>" autocomplete="off">
                <?= form_error('nim', '<small class="text-danger pl-3">', '</small>');?>
              </div>
              <div class="form-group">
                <input type="text" class="form-control form-control-user <?php if(form_error('email')) echo 'is-invalid' ?>" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>" autocomplete="off">
                <?= form_error('email', '<small class="text-danger pl-3"> ', '</small>');?>
              </div>
              <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input type="password" class="form-control form-control-user <?php if(form_error('password1')) echo 'is-invalid' ?>" id="password1" name="password1" placeholder="Kata Sandi">
                  <?= form_error('password1', '<small class="text-danger pl-3">', '</small>');?>
                </div>
                <div class="col-sm-6">
                  <input type="password" class="form-control form-control-user <?php if(form_error('password2')) echo 'is-invalid' ?>" id="password2" name="password2" placeholder="Masukan Lagi Kata Sandi">
                  <?= form_error('password2', '<small class="text-danger pl-3">', '</small>');?>
                </div>
              </div>
              <br>
              <button type="submit" class="btn btn-user btn-block" style="font-weight: bold;">Buat Akun</button>
            </form>
            <hr>
            <div class="text-center">
              <a class="small txt-auth" href="<?= base_url('auth') ?>" style="text-decoration: none;">Sudah Punya Akun? Login!</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
</body>
