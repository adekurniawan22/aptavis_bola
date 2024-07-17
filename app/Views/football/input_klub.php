<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<h1 class="mb-3">Input Data Klub</h1>
<form action="/input-klub" method="post">
    <?= csrf_field() ?>

    <!-- Nama Klub -->
    <div class="mb-3">
        <label class="form-label">Nama Klub</label>
        <input type="text" class="form-control <?= ($validation->hasError('nama_klub')) ? 'is-invalid' : '' ?>" placeholder="Nama Klub" name="nama_klub" value="<?= set_value('nama_klub') ?>">
        <!-- Tampilkan pesan validasi jika ada -->
        <div class="invalid-feedback"><?= $validation->getError('nama_klub') ?></div>
    </div>

    <!-- Asal Klub -->
    <div class="mb-3">
        <label class="form-label">Asal Klub</label>
        <input type="text" class="form-control <?= ($validation->hasError('asal_klub')) ? 'is-invalid' : '' ?>" placeholder="Asal Klub" name="asal_klub" value="<?= set_value('asal_klub') ?>">
        <!-- Tampilkan pesan validasi jika ada -->
        <div class="invalid-feedback"><?= $validation->getError('asal_klub') ?></div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?= $this->endSection() ?>