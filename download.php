<?php
if (isset($_GET['url'])) {
    $tiktokUrl = $_GET['url'];
    
    // Validasi URL TikTok
    if (!preg_match('/https?:\/\/(www\.)?tiktok\.com\/.+/', $tiktokUrl)) {
        header("Location: index.php?error=URL TikTok tidak valid!");
        exit();
    }

    // Gunakan API pihak ketiga (contoh: TikWM)
    $apiUrl = "https://api.tikwm.com/api?url=" . urlencode($tiktokUrl);
    $response = file_get_contents($apiUrl);
    
    if ($response === FALSE) {
        header("Location: index.php?error=Gagal mengambil data dari TikTok.");
        exit();
    }

    $data = json_decode($response, true);

    // Cek apakah data valid
    if (isset($data['data']['play'])) {
        $downloadUrl = $data['data']['play'];
        header("Location: $downloadUrl"); // Langsung unduh video
        exit();
    } else {
        header("Location: index.php?error=Video/Photo tidak ditemukan.");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
