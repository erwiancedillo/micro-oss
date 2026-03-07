<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title . ' - Micro OSS' : 'Micro OSS' ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="/micro-oss/assets/css/style.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1 0 auto;
        }
    </style>
</head>
<?php
$route = $_GET['route'] ?? 'dashboard';
$isAuthPage = in_array($route, ['login', 'register']);
?>

<body class="d-flex flex-column h-100 <?= $isAuthPage ? 'bg-light' : '' ?>">

    <?php if (!$isAuthPage): ?>
        <?php include __DIR__ . '/includes/nav.php'; ?>

        <!-- Mobile Sidebar Toggle Button -->
        <button class="btn btn-primary d-lg-none shadow-sm position-fixed mobile-sidebar-toggle"
            style="top: 15px; left: 15px; z-index: 1040; border-radius: 50%; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar"
            aria-controls="mobileSidebar">
            <i class="fas fa-bars"></i>
        </button>

        <?php include __DIR__ . '/includes/mobile-sidebar.php'; ?>
        <?php include __DIR__ . '/includes/mobile-bottom-nav.php'; ?>
    <?php endif; ?>

    <main class="main-content <?= $isAuthPage ? 'd-flex align-items-center py-5 min-vh-100' : '' ?>">
        <div class="<?= $isAuthPage ? 'container' : '' ?>">
            <?= $content ?>
        </div>
    </main>

    <?php if (!$isAuthPage): ?>
        <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php endif; ?>

    <?php include __DIR__ . '/includes/scripts.php'; ?>

</body>

</html>