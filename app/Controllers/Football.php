<?php

namespace App\Controllers;

use App\Models\KlubModel;
use App\Models\PertandinganModel;
use CodeIgniter\Controller;

class Football extends Controller
{
    protected $validation;
    protected $klubModel;
    protected $pertandinganModel;

    public function __construct()
    {
        // Initialize the validation object and the models
        $this->validation = \Config\Services::validation();
        $this->klubModel = new KlubModel();
        $this->pertandinganModel = new PertandinganModel();
    }

    public function index()
    {
        return view('football/home', ['title' => 'Home']);
    }

    public function createKlub()
    {
        // Mengirim data ke tampilan
        return view('football/input_klub', [
            'title' => 'Input Klub',
            'validation' => $this->validation,
        ]);
    }

    public function storeKlub()
    {
        // Set validation rules
        $validationRules = [
            'nama_klub' => [
                'label'  => 'Nama Klub',
                'rules'  => 'required|trim|is_unique[klub.nama_klub]',
                'errors' => [
                    'required' => 'Kolom Nama Klub harus diisi.',
                    'is_unique' => 'Nama Klub sudah terdaftar.',
                ],
            ],
            'asal_klub' => [
                'label'  => 'Asal Klub',
                'rules'  => 'required|trim',
                'errors' => [
                    'required' => 'Kolom Asal Klub harus diisi.',
                ],
            ],
        ];

        // Validate inputs
        if (!$this->validate($validationRules)) {
            return $this->createKlub();
        }

        // Menyiapkan data untuk disimpan
        $data = [
            'nama_klub' => $this->request->getVar('nama_klub'),
            'asal_klub' => $this->request->getVar('asal_klub'),
        ];

        // Menyimpan data dan memberikan feedback ke pengguna
        if ($this->klubModel->save($data)) {
            session()->setFlashdata('sukses', 'Sukses menambah klub');
        } else {
            session()->setFlashdata('gagal', 'Gagal menambah data klub');
        }

        return redirect()->to('/input-klub');
    }

    public function createPertandingan()
    {
        return view('football/input_skor', [
            'title' => 'Input Data Pertandingan',
            'klubs' => $this->klubModel->findAll(),
        ]);
    }

    public function storePertandingan()
    {
        // Mengambil data dari form
        $klub_home = $this->request->getPost('klub_home');
        $klub_away = $this->request->getPost('klub_away');
        $skor_home = $this->request->getPost('skor_home');
        $skor_away = $this->request->getPost('skor_away');

        $batchData = [];

        // Memastikan semua data yang dibutuhkan tersedia sebelum melakukan iterasi
        if ($klub_home && $klub_away && $skor_home && $skor_away) {
            // Iterasi untuk menyimpan data dalam batch
            for ($i = 0; $i < count($klub_home); $i++) {
                $data = [
                    'klub_home' => $klub_home[$i],
                    'klub_away' => $klub_away[$i],
                    'skor_home' => $skor_home[$i],
                    'skor_away' => $skor_away[$i],
                ];

                // Menambahkan data ke dalam batchData
                $batchData[] = $data;

                // Simpan data menggunakan model
                $this->pertandinganModel->insert($data);
            }

            // Memberikan feedback sesuai dengan berhasil atau tidaknya operasi batch
            if (count($batchData) == count($klub_home)) {
                session()->setFlashdata('sukses', 'Sukses menambah skor');
            } else {
                session()->setFlashdata('gagal', 'Gagal menambah data skor');
            }
        } else {
            // Jika ada data yang tidak lengkap, berikan pesan kesalahan
            session()->setFlashdata('gagal', 'Gagal menambah data skor. Data tidak lengkap.');
        }

        // Redirect kembali ke halaman input skor setelah operasi selesai
        return redirect()->to('/input-skor');
    }

    public function viewKlasemen()
    {
        // Ambil data klub dan hitung statistiknya
        $klubs = $this->klubModel->findAll();
        $klasemen = [];

        foreach ($klubs as $klub) {
            // Inisialisasi statistik
            $played = 0;
            $won = 0;
            $drawn = 0;
            $lost = 0;
            $homeGoalsScored = 0;
            $homeGoalsConceded = 0;
            $awayGoalsScored = 0;
            $awayGoalsConceded = 0;

            // Ambil pertandingan tim sebagai tim kandang
            $homeMatches = $this->pertandinganModel->where('klub_home', $klub['id'])->findAll();
            foreach ($homeMatches as $match) {
                $played++;

                $homeGoalsScored += $match['skor_home'];
                $homeGoalsConceded += $match['skor_away'];

                if ($match['skor_home'] > $match['skor_away']) {
                    $won++;
                } elseif ($match['skor_home'] == $match['skor_away']) {
                    $drawn++;
                } else {
                    $lost++;
                }
            }

            // Ambil pertandingan tim sebagai tim tandang
            $awayMatches = $this->pertandinganModel->where('klub_away', $klub['id'])->findAll();
            foreach ($awayMatches as $match) {
                $played++;

                $awayGoalsScored += $match['skor_away'];
                $awayGoalsConceded += $match['skor_home'];

                if ($match['skor_away'] > $match['skor_home']) {
                    $won++;
                } elseif ($match['skor_away'] == $match['skor_home']) {
                    $drawn++;
                } else {
                    $lost++;
                }
            }

            // Hitung total gol yang dicetak dan kebobolan
            $totalGoalsScored = $homeGoalsScored + $awayGoalsScored;
            $totalGoalsConceded = $homeGoalsConceded + $awayGoalsConceded;

            // Perhitungan poin sesuai aturan
            $points = ($won * 3) + $drawn;

            $klasemen[] = [
                'nama_klub' => $klub['nama_klub'],
                'played' => $played,
                'won' => $won,
                'drawn' => $drawn,
                'lost' => $lost,
                'points' => $points,
                'GM' => $totalGoalsScored,
                'GK' => $totalGoalsConceded,
            ];
        }

        // Urutkan klasemen berdasarkan points
        usort($klasemen, function ($a, $b) {
            return $b['points'] <=> $a['points'];
        });

        return view('football/klasemen', [
            'title' => 'Klasemen',
            'klasemen' => $klasemen,
        ]);
    }
}
