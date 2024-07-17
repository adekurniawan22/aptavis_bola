<?= $this->extend('main') ?>

<?= $this->section('content') ?>
<h1 class="mb-3">Input Data Pertandingan</h1>
<form id="matchForm" action="/input-skor" method="post">
    <?= csrf_field() ?>
    <div id="errorForm" class="alert alert-danger d-flex align-items-center d-none" role="alert">
        <div>
            <strong>Oops!</strong> Masih terdapat error pada form, segera perbaiki.
        </div>
    </div>
    <div id="matchContainer">
        <div class="card" id="match1">
            <div class="card-body">
                <div class="error invalid-feedback d-block mb-2"></div>
                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="klub_home[]">Klub Home:</label>
                            <select name="klub_home[]" class="klub_home form-select">
                                <option value="" selected disabled>Pilih Klub Home</option>
                                <?php foreach ($klubs as $klub) : ?>
                                    <option value="<?= $klub['id'] ?>"><?= $klub['nama_klub'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label for="klub_away[]">Klub Away:</label>
                            <select name="klub_away[]" class="klub_away form-select">
                                <option value="" selected disabled>Pilih Klub Away</option>
                                <?php foreach ($klubs as $klub) : ?>
                                    <option value="<?= $klub['id'] ?>"><?= $klub['nama_klub'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="mb-3">
                            <label for="skor_home[]">Skor Home:</label>
                            <input type="number" name="skor_home[]" class="form-control skor-home">
                        </div>
                    </div>

                    <div class="col">
                        <div class="mb-3">
                            <label for="skor_away[]">Skor Away:</label>
                            <input type="number" name="skor_away[]" class="form-control skor-away">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- Tombol untuk menyalin div -->
    <button type="button" id="duplicateMatch" class="btn btn-secondary">Tambah Pertandingan</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
    // Fungsi untuk memvalidasi pertandingan duplikat dan memberi warna border merah
    function validateMatches() {
        const matches = document.querySelectorAll('.card');
        matches.forEach(match => {
            match.style.borderColor = '';
            const error = match.querySelector('.error');
            error.textContent = ''; // Reset pesan error sebelum validasi ulang
        });

        for (let i = matches.length - 1; i >= 0; i--) {
            const currentMatch = matches[i];
            const error = currentMatch.querySelector('.error');
            error.textContent = ''; // Reset pesan error pada setiap iterasi

            const currentHome = currentMatch.querySelector('.klub_home').value;
            const currentAway = currentMatch.querySelector('.klub_away').value;
            const currentSkorHome = currentMatch.querySelector('.skor-home').value;
            const currentSkorAway = currentMatch.querySelector('.skor-away').value;

            // Validasi jika select atau input skor kosong
            if (currentHome === "" || currentAway === "" || currentSkorHome === "" || currentSkorAway === "") {
                currentMatch.style.borderColor = 'red';
                error.textContent = 'Harap lengkapi semua input.';
                continue; // Lanjut ke card selanjutnya jika ada field yang kosong
            }

            // Validasi jika select ada yang sama
            const homeSelect = currentMatch.querySelector('.klub_home');
            const awaySelect = currentMatch.querySelector('.klub_away');
            if (homeSelect.value === awaySelect.value) {
                currentMatch.style.borderColor = 'red';
                error.textContent = 'Klub Home tidak boleh sama dengan Klub Away.';
                continue; // Lanjut ke card selanjutnya jika ada select yang sama
            }

            for (let j = i - 1; j >= 0; j--) {
                const previousMatch = matches[j];
                const previousHome = previousMatch.querySelector('.klub_home').value;
                const previousAway = previousMatch.querySelector('.klub_away').value;

                if (currentHome === previousHome && currentAway === previousAway) {
                    currentMatch.style.borderColor = 'red';
                    error.textContent = 'Pertandingan ini sudah ada.';
                    previousMatch.style.borderColor = 'red';
                    break; // Keluar dari loop jika sudah ditemukan pertandingan yang sama
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('matchForm').addEventListener('change', function(event) {
            if (event.target.classList.contains('klub_home') ||
                event.target.classList.contains('klub_away') ||
                event.target.classList.contains('skor-home') || // Tambahkan ini
                event.target.classList.contains('skor-away')) { // dan ini
                validateMatches();
            }
        });
    });

    document.getElementById('matchForm').addEventListener('submit', function(event) {
        validateMatches(); // Panggil validateMatches() sebelum submit untuk memastikan tidak ada error

        const matches = document.querySelectorAll('.card');
        let hasError = false;

        matches.forEach(match => {
            if (match.style.borderColor === 'red') {
                hasError = true;
            }
        });

        if (hasError) {
            document.getElementById('errorForm').classList.remove('d-none'); // Tampilkan alert error
            event.preventDefault();
        }
    });


    // Fungsi untuk menyalin div match
    document.getElementById('duplicateMatch').addEventListener('click', function() {
        const matchContainer = document.getElementById('matchContainer');
        const matchDiv = matchContainer.querySelector('.card:last-child');
        const clone = matchDiv.cloneNode(true);
        const inputs = clone.querySelectorAll('input');
        const selects = clone.querySelectorAll('select');

        // Reset semua input dan select pada klon
        inputs.forEach(input => input.value = '');
        selects.forEach(select => select.selectedIndex = 0);

        // Ganti id match1 menjadi id match yang sesuai dengan urutan
        const matchCount = matchContainer.querySelectorAll('.card').length + 1;
        clone.id = 'match' + matchCount;

        clone.classList.add('mt-3'); // Tambahkan kelas mt-3 pada klon
        matchContainer.appendChild(clone);
    });
</script>

<?= $this->endSection() ?>