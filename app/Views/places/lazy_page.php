<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lazy Loading Header, Content, Footer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        #loading {
            text-align: center;
            padding: 20px;
            font-size: 1.2rem;
            color: #555;
        }
        .section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: linear-gradient(to bottom, #f9f9f9, #e8e8e8);
            border-bottom: 2px solid #ddd;
        }
        .section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- Placeholder untuk header -->
    <div id="header-placeholder"></div>

    <!-- Placeholder untuk konten -->
    <div id="content-placeholder">
        <div id="first-section-placeholder"></div>
        <div id="sections"></div>
    </div>

    <!-- Placeholder untuk footer -->
    <div id="footer-placeholder"></div>

    <div id="loading">Memuat lebih banyak konten...</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentSection = 1; // Mulai dari section pertama
        let isLoading = false; // Status loading

        function loadHeader() {
            $.ajax({
                url: '<?= base_url('place/loadHeader') ?>',
                method: 'GET',
                success: function(data) {
                    $('#header-placeholder').html(data);
                    loadFirstContent(); // Muat konten pertama setelah header selesai
                }
            });
        }

        function loadFirstContent() {
            $.ajax({
                url: '<?= base_url('place/loadFirstContent') ?>',
                method: 'GET',
                success: function(data) {
                    $('#first-section-placeholder').html(data);
                    loadFooter(); // Muat footer setelah konten pertama selesai
                }
            });
        }

        function loadFooter() {
            $.ajax({
                url: '<?= base_url('place/loadFooter') ?>',
                method: 'GET',
                success: function(data) {
                    $('#footer-placeholder').html(data);
                }
            });
        }

        function loadSection() {
            if (isLoading) return; // Hindari request berulang
            isLoading = true;
            $('#loading').show();

            $.ajax({
                url: '<?= base_url('place/loadSection') ?>',
                method: 'GET',
                data: { section: currentSection },
                success: function(data) {
                    if (data.length === 0) {
                        $('#loading').html('Semua data sudah dimuat.');
                        return;
                    }

                    // Tambahkan konten baru
                    data.forEach(place => {
                        $('#sections').append(`
                            <div class="section">
                                <h2>${place.name}</h2>
                                <p>${place.description}</p>
                            </div>
                        `);
                    });

                    currentSection++;
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

        $(document).ready(function() {
            loadHeader(); // Mulai dengan header

            // Lazy loading section lainnya
            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100) {
                    loadSection();
                }
            });
        });
    </script>
</body>
</html>
