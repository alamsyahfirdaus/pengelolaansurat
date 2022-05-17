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
                                  <h1 class="h4 text-gray-900 mb-4" style="font-weight: bold;">Lupa Password</h1>
                                  <?= $this->session->flashdata('message'); ?>
                                </div>
                                <form class="user" method="post" action="<?= base_url('auth/forgotpassword'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email" name="email" placeholder="Masukan Alamat Email" value="<?= set_value('email'); ?>" autocomplete="off">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-user btn-block" style="font-weight: bold;">Reset Password</button>
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

    </div>

</div> 