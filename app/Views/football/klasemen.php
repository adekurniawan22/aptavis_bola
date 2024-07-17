<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<h1 class="mb-3">Klasemen</h1>
<table id="klasemen-table" class="display">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th>Nama Klub</th>
            <th class="text-center">Ma</th>
            <th class="text-center">Me</th>
            <th class="text-center">S</th>
            <th class="text-center">K</th>
            <th class="text-center">GM</th>
            <th class="text-center">GK</th>
            <th class="text-center">Point</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($klasemen as $index => $klub) : ?>
            <tr>
                <td class="text-center"><?= $index + 1 ?></td>
                <td><?= $klub['nama_klub'] ?></td>
                <td class="text-center"><?= $klub['played'] ?></td>
                <td class="text-center"><?= $klub['won'] ?></td>
                <td class="text-center"><?= $klub['drawn'] ?></td>
                <td class="text-center"><?= $klub['lost'] ?></td>
                <td class="text-center"><?= $klub['GM'] ?></td>
                <td class="text-center"><?= $klub['GK'] ?></td>
                <td class="text-center"><?= $klub['points'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?= $this->endSection() ?>