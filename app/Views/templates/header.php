<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $title ?></title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    $current_url = current_url(); // Fungsi untuk mendapatkan URL saat ini dari CodeIgniter
    // dd($current_url);
    ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">APTAVIS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link<?= ($current_url == base_url('input-klub')) ? ' active' : '' ?>" href="<?= base_url('input-klub') ?>">Input Klub</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= ($current_url == base_url('input-skor')) ? ' active' : '' ?>" href="<?= base_url('input-skor') ?>">Input Skor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?= ($current_url == base_url('klasemen')) ? ' active' : '' ?>" href="<?= base_url('klasemen') ?>">Klasemen</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <?php if (session()->has('sukses')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Yeay!</strong> <?= session()->getFlashdata('sukses') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (session()->has('gagal')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oops!</strong> <?= session()->getFlashdata('gagal') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>