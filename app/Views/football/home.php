<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<?php
date_default_timezone_set('Asia/Jakarta');
$jam = date('H');
if ($jam >= 0 && $jam < 10) {
    $ucapan = "Selamat pagi";
} elseif ($jam >= 10 && $jam < 15) {
    $ucapan = "Selamat siang";
} elseif ($jam >= 15 && $jam < 18) {
    $ucapan = "Selamat sore";
} else {
    $ucapan = "Selamat malam";
}
?>
<h1>Halo, <?= $ucapan ?>.</h1>
<span>Selamat datang di website APTAVIS Football League</span><br>
<span>Di sini kamu dapat menambahkan data klub dan pertandingan, serta melihat klasemen dari liga tersebut.</span>
<?= $this->endSection() ?>