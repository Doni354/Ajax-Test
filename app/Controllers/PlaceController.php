<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\PlaceModel;

class PlaceController extends BaseController
{
    public function index()
    {
        return view('places/lazy_page'); // Menampilkan halaman utama
    }

    public function loadHeader()
    {
        // Muat header
        return view('partials/header');
    }

    public function loadFirstContent()
    {
        // Muat konten pertama
        return view('partials/first_section');
    }

    public function loadFooter()
    {
        // Muat footer
        return view('partials/footer');
    }

    public function loadSection()
    {
        // Contoh data dinamis untuk section
        $data = [
            ['name' => 'Pantai Kuta', 'description' => 'Pantai indah di Bali dengan pasir putih.'],
            ['name' => 'Borobudur', 'description' => 'Candi Buddha terbesar di dunia.'],
            ['name' => 'Gunung Bromo', 'description' => 'Gunung dengan pemandangan matahari terbit yang spektakuler.'],
        ];

        // Simulasikan data bagian berdasarkan parameter
        $section = $this->request->getGet('section');
        $response = [];

        if (isset($data[$section - 1])) {
            $response[] = $data[$section - 1];
        }

        return $this->response->setJSON($response);
    }
}
