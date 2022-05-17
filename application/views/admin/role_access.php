<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <?= $this->session->flashdata('message'); ?>

            <h5>Peran Sebagai : <?= $role['role']; ?></h5>

            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Menu</th>
                        <th class="text-center" scope="col">Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $angka = 1; ?>
                    <?php foreach ($menu as  $m) : ?>
                        <tr>
                            <th scope="row"><?= $angka; ?></th>
                            <td><?= $m['menu']; ?> </td>
                            <td class="text-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" <?= check_access($role['id'], $m['id']); ?> data_role="<?= $role['id']; ?>" data_menu="<?= $m['id']; ?>">
                                </div>
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