<!-- Outer Row -->
<div class="container">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card o-hidden border-0 shadow-lg" style="margin-top: 75px;">
        <div class="card-body p-0">

          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg">
              <div class="p-5">
                <div class="text-center">
                  <img src="<?= base_url('assets/img/logo_umtas.png') ?>" alt="" style="width: 100px; margin-bottom: 6px;">
                  <h1 class="h4 text-gray-900 mb-4" style="font-weight: bold;">Pengelolaan Surat Keluar</h1>
                  <?= $this->session->flashdata('message'); ?>
                </div>

                <form class="user" method="post" action="<?= base_url('auth/index'); ?>">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user <?php if(form_error('nim')) echo 'is-invalid' ?>" id="nim" name="nim" placeholder="Masukan NIM / Username" value="<?= set_value('nim'); ?>" autocomplete="off">
                    <?= form_error('nim', '<small class="text-danger pl-3">', '</small>');?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user <?php if(form_error('nim')) echo 'is-invalid' ?>" id="password" name="password" placeholder="Masukan Kata Sandi">
                      <?= form_error('password', '<small class="text-danger pl-3">', '</small>');?>
                  </div>
                  <button type="submit" class="btn btn-user btn-block" style="font-weight: bold;">Masuk</button>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small txt-auth" href="<?= base_url('auth/forgotPassword') ?>" style="text-decoration: none;">Lupa Password?  |</a>
                  <a class="small txt-auth" href="<?= base_url('auth/registration') ?>" style="text-decoration: none;">Buat Akun Baru</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>