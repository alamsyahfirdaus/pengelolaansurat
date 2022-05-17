<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">

                                <div class="text-center">
                                  <img src="<?= base_url('assets/img/logo_umtas.png') ?>" alt="" style="width: 100px; margin-bottom: 6px;">
                                  <h1 class="h4 text-gray-900" style="font-weight: bold;">Ubah Password</h1>
                                  <p><?= $this->session->userdata('reset_email'); ?></p>
                                </div>

                                <form class="user" method="post" action="<?= base_url('auth/changepassword'); ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Masukan Password Baru">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Konfirmasi Password (Ulangi)">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-user btn-block" style="font-weight: bold;">Ubah Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div> 