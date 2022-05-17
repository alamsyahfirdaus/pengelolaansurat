              <!-- Begin Page Content -->
              <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800"><?= $title; ?> </h1>

                <div class="row">
                  <div class="col-md-6">
                    <?= $this->session->flashdata('message'); ?>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-md-4">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img" style="width: 100%; max-height: 325px;">
                          </div>
                          <div class="col-md-8">
                            <h5 class="card-title"><?= $user['nama']; ?></h5>
                            <p class="card-text"><?= $user['nim']; ?></p>
                            <p class="card-text"><?= $user['email']; ?></p>
                            <?php if ($user['role_id'] == 2): ?>
                              <p class="card-text"><?= $user['program_studi_id'] != null ? $user['program_studi'] : '-' ?></p>
                              <p class="card-text">Tahun Masuk <?= $user['tahun_masuk'] != null ? $user['tahun_masuk'] : '-' ?></p>
                            <?php endif ?>
                            <p class="card-text">Member Sejak <?= date(' d F Y', $user['date_created']); ?>
                              <small class="text-muted">
                            </p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- End of main content -->
              </div>
              </div>