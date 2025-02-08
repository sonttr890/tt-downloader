<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tiktokUrl = $_POST['tiktok_url'];

    // Gunakan API dengan metode GET
    $apiUrl = "https://api.tiklydown.eu.org/api/download?url=" . urlencode($tiktokUrl);
    $response = file_get_contents($apiUrl);

    if ($response === FALSE) {
        die("Gagal mengambil data dari TikTok.");
    }

    $result = json_decode($response, true);

    if (isset($result['video'])) {
        header("Location: " . $result['video']);
        exit();
    } elseif (isset($result['image'])) {
        header("Location: " . $result['image']);
        exit();
    } else {
        echo "Tidak dapat menemukan video/foto.";
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
    echo "Hanya metode POST yang diizinkan!";
    exit();
}
?>
