<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
            <?= $this->session->flashdata('message'); ?>
            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#MenuBaruModal">Tambahkan Menu Baru</a>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $angka = 1; ?>
                    <?php foreach ($menu as  $m) : ?>
                        <tr>
                            <th scope="row"><?= $angka; ?></th>
                            <td><?= $m['menu']; ?> </td>
                            <td>
                                <a href="" class="badge badge-success">Ubah</a>
                                <a href="" class="badge badge-danger">Hapus</a>
                            </td>
                        </tr>
                        <?php $angka++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal TAMBAH MENU -->
<div class="modal fade" id="MenuBaruModal" tabindex="-1" aria-labelledby="MenuBaruModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="MenuBaruModalLabel">Tambahkan Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
                <span aria-hidden="true">&times;</span>
            </div>
            <form action=" <?= base_url('menu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Nama Menu">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>