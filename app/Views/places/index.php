<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tempat Wisata - Lazy Loading</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header, footer {
            background-color: #f4f4f4;
            text-align: center;
            padding: 15px 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 0 15px;
        }
        .place {
            background: #fff;
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #loading {
            text-align: center;
            padding: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <header>
        <h1>Tempat Wisata</h1>
    </header>

    <div class="container" id="content">
        <!-- Data awal akan dimuat di sini -->
    </div>

    <div id="loading">Memuat lebih banyak data...</div>

    <footer>
        <p>&copy; 2024 Tempat Wisata</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 1; // Halaman saat ini
        let isLoading = false; // Status loading

        function loadPlaces() {
            if (isLoading) return; // Cegah request ganda

            isLoading = true;
            $('#loading').show();

            $.ajax({
                url: `<?= base_url('place/loadMore') ?>`, // API untuk load data
                method: 'GET',
                data: { page: currentPage },
                success: function(data) {
                    if (data.length === 0) {
                        $('#loading').html('Semua data sudah dimuat.');
                        return;
                    }

                    // Tambahkan data baru ke halaman
                    data.forEach(place => {
                        $('#content').append(`
                            <div class="place">
                                <h3>${place.name}</h3>
                                <p>${place.description}</p>
                            </div>
                        `);
                    });

                    currentPage++; // Tambah nomor halaman
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
            loadPlaces();

            // Event scroll
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 50) {
                    loadPlaces();
                }
            });
        });
    </script>
</body>
</html>
