                            <!-- Begin Page Content -->
                            <div class="container-fluid">

                                <!-- Page Heading -->
                                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                    <h1 class="h3 mb-0 text-gray-800"><?= $title  ?></h1>
                                </div>

                                <div class="row">

                                    <?php 
                                    $warna = array('primary', 'success', 'info', 'warning');
                                    $no    = 0;
                                    foreach ($jenis_surat as $row): ?>
                                        <div class="col-xl-3 col-md-6 mb-4">
                                            <div class="card border-left-<?= $warna[$no] ?> shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text font-weight-bold text-<?= $warna[$no] ?> text-uppercase mb-1">
                                                                <?php $url = $no >= 1 ? 'list_surat/'. md5($row->id_jenis_surat) : 'surat_keterangan'; ?>
                                                                <a href="<?= base_url('user/'. $url .'') ?>"style="text-decoration: none;"><?= $row->jenis_surat ?></a></div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php $no++ ?>
                                    <?php endforeach ?>

                                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-primary shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold text-primary text-uppercase mb-1">
                                                            <a href="<?= base_url('user/surat_keterangan') ?>"style="text-decoration: none;">Surat Keterangan Kuliah</a></div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-success shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold text-success text-uppercase mb-1">
                                                            Surat izin Penelitian </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-info shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold text-info text-uppercase mb-1">Surat Dispensasi
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-xl-3 col-md-6 mb-4">
                                        <div class="card border-left-warning shadow h-100 py-2">
                                            <div class="card-body">
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col mr-2">
                                                        <div class="text font-weight-bold text-warning text-uppercase mb-1">
                                                            Surat Izin Melakukan Kegiatan</div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <i class="fas fa-envelope fa-2x text-gray-300"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                </div>
                            </div>
                            </div>
                            <!-- End of Main Content -->