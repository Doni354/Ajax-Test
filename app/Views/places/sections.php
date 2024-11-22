<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Wisata - Section Lazy Loading</title>
    <style>
        /* Styling Global */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }
        footer {
            margin-top: 50px;
        }
        .section {
            min-height: 30vh; /* Setiap section tinggi minimal layar */
            padding: 20px 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to bottom, #f9f9f9, #e8e8e8);
            border-bottom: 2px solid #ddd;
        }
        .section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }
        .section p {
            font-size: 1.2rem;
            line-height: 1.6;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }
        #loading {
            text-align: center;
            padding: 20px;
            font-size: 1.2rem;
            color: red;
        }
    </style>
</head>
<body>
    <header>
        <h1>Tempat Wisata - Eksplorasi Indonesia</h1>
    </header>

    <!-- Kontainer untuk section -->
    <div id="sections">
        <div class="section">
            <h2>Selamat Datang</h2>
            <p>Jelajahi keindahan Indonesia dengan informasi tempat wisata terbaik kami. Scroll ke bawah untuk melihat lebih banyak!</p>
        </div>
    </div>

    <div id="loading">Memuat lebih banyak konten...</div>

    <footer>
        <p>&copy; 2024 Tempat Wisata</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentSection = 1; // Mulai dari section pertama
        let isLoading = false; // Status loading

        function loadSection() {
            if (isLoading) return; // Cegah request ganda

            isLoading = true;
            $('#loading').show();

            $.ajax({
                url: `<?= base_url('place/loadSection') ?>`, // API untuk load section
                method: 'GET',
                data: { section: currentSection },
                success: function(data) {
                    if (data.length === 0) {
                        $('#loading').html('Semua data sudah dimuat.');
                        return;
                    }

                    // Tambahkan data baru ke halaman
                    data.forEach(place => {
                        $('#sections').append(`
                            <div class="section">
                                <h2>${place.name}</h2>
                                <p>${place.description}</p>
                            </div>
                        `);
                    });

                    currentSection++; // Tambah nomor section
                    isLoading = false;
                    $('#loading').hide();
                },
                error: function() {
                    alert('Gagal memuat data');
                    isLoading = false;
                    $('#loading').hide();
                }
            });
        }

        // Load data saat pertama kali
        $(document).ready(function() {
            loadSection();

            // Event scroll untuk lazy loading
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadSection();
                }
            });
        });
    </script>
</body>
</html>
