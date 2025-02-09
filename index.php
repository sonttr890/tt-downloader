<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TikTok Downloader HD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>TikTok Downloader HD</h1>
        <p>Unduh video dan foto TikTok dalam kualitas HD!</p>
        
        <!-- Ubah method POST ke GET -->
        <form action="download.php" method="GET">
            <input type="url" name="url" placeholder="Masukkan URL TikTok" required>
            <button type="submit">Unduh Sekarang</button>
        </form>

        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
