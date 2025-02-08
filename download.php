<?php
// Cek apakah request yang masuk adalah POST atau GET
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {

    // Cek apakah parameter tiktok_url sudah disediakan (bisa melalui POST atau GET)
    if (isset($_REQUEST['tiktok_url']) && !empty($_REQUEST['tiktok_url'])) {
        $tiktokUrl = $_REQUEST['tiktok_url'];
    } else {
        // Jika parameter belum ada, tampilkan form input sederhana
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <title>Downloader TikTok</title>
        </head>
        <body>
            <h2>Masukkan URL TikTok</h2>
            <form method="post" action="">
                <input type="text" name="tiktok_url" placeholder="Masukkan URL TikTok" required>
                <button type="submit">Download</button>
            </form>
        </body>
        </html>
        <?php
        exit();
    }

    // Buat URL API dengan meng-encode URL TikTok
    $apiUrl = "https://api.tiklydown.eu.org/api/download?url=" . urlencode($tiktokUrl);
    $response = file_get_contents($apiUrl);

    if ($response === FALSE) {
        die("Gagal mengambil data dari TikTok.");
    }

    $result = json_decode($response, true);

    // Tentukan URL file (video atau image) yang akan didownload
    if (isset($result['video'])) {
        $fileUrl = $result['video'];
    } elseif (isset($result['image'])) {
        $fileUrl = $result['image'];
    } else {
        die("Tidak dapat menemukan video atau foto.");
    }

    // Periksa apakah file URL valid dan dapat diakses
    $headers = @get_headers($fileUrl);
    if(!$headers || strpos($headers[0], '200') === false) {
        die("Gagal mengambil file untuk diunduh.");
    }

    // Set header untuk memaksa download file
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileUrl) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');

    // Menggunakan readfile untuk langsung mengirim file ke client
    readfile($fileUrl);
    exit();

} else {
    // Jika method selain GET atau POST, kembalikan error 405
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Hanya metode GET dan POST yang diizinkan!";
    exit();
}
?>
