<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tiktokUrl = $_POST['tiktok_url'];

    // Gunakan API pihak ketiga untuk mengunduh video/foto TikTok
    $apiUrl = "https://api.tiklydown.eu.org/api/download"; // Contoh API
    $data = [
        'url' => $tiktokUrl
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];

    $context  = stream_context_create($options);
    $response = file_get_contents($apiUrl, false, $context);

    if ($response === FALSE) {
        die("Gagal mengambil data dari TikTok.");
    }

    $result = json_decode($response, true);

    if (isset($result['video'])) {
        // Jika hasilnya adalah video
        $videoUrl = $result['video'];
        header("Location: $videoUrl"); // Redirect ke URL video untuk diunduh
        exit();
    } elseif (isset($result['image'])) {
        // Jika hasilnya adalah foto
        $imageUrl = $result['image'];
        header("Location: $imageUrl"); // Redirect ke URL foto untuk diunduh
        exit();
    } else {
        echo "Tidak dapat menemukan video atau foto.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
