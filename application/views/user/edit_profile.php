<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-8">

            <div class="card">
                <div class="card-body">
                    <?= form_open_multipart('user/edit_profile'); ?>
                    <!-- nim -->
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label"><?= $user['role_id'] == 2 ? 'NIM' : 'Username' ?> </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nim" id="nim" value="<?= $user['nim']; ?>" readonly>
                        </div>
                    </div>
                    <!-- email -->
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="email" id="email" value="<?= $user['email']; ?>" readonly>
                        </div>
                    </div>
                    <!-- nama -->
                    <div class="form-group row">
                        <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $user['nama']; ?>" autocomplete="off">
                            <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>
                        </div>
                    </div>
                    <?php if ($user['role_id'] == 2): ?>
                        <!-- program studi -->
                        <div class="form-group row">
                            <label for="program_studi_id" class="col-sm-3 col-form-label">Program Studi</label>
                            <div class="col-sm-9">
                                <select name="program_studi_id" id="program_studi_id" class="form-control select2">
                                    <option value="">-- Program Studi --</option>
                                    <?php foreach ($this->db->get('program_studi')->result() as $key): ?>
                                        <option value="<?= $key->id_program_studi ?>" <?php if($key->id_program_studi == $user['program_studi_id']) echo 'selected=""'; ?>><?= $key->program_studi ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?= form_error('program_studi_id', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                        <!-- tahun masuk -->
                        <div class="form-group row">
                            <label for="tahun_masuk" class="col-sm-3 col-form-label">Tahun Masuk</label>
                            <div class="col-sm-9">
                                <select name="tahun_masuk" id="tahun_masuk" class="form-control select2">
                                    <option value="">-- Tahun Masuk --</option>
                                    <?php for ($i = 2015; $i <= date('Y'); $i++): ?>
                                        <option value="<?= $i ?>" <?php if($i == $user['tahun_masuk']) echo 'selected=""'; ?>><?= $i ?></option>
                                    <?php endfor ?>
                                </select>
                                <?= form_error('tahun_masuk', '<small class="text-danger pl-3">', '</small>'); ?>
                            </div>
                        </div>
                    <?php endif ?>
                    <!-- gambar -->
                    <div class="form-group row">
                        <div class="col-sm-3">Gambar</div>
                        <div class="col-sm-3">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-timbnail" width="150" height="150">
                        </div>
                        <div class="col-sm-6">
                            <div class="custom-file"></div>
                            <!-- telah di manipulasi oleh ajax di footer.php -->
                            <input type="file" class="custom-file-input" id="image" name="image">
                            <label class="custom-file-label" for="image">Pilih File</label>
                        </div>
                    </div>
                    <div class="form-group row justify-content-end">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>







    <!-- container pluid -->
</div>
<!-- End of main content -->
</div>