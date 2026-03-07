<?php
$title = 'Downloads';
ob_start();
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0 rounded-4 p-5">
                <i class="fas fa-file-arrow-down fa-4x text-success mb-4"></i>
                <h2 class="fw-bold mb-3">Downloadables</h2>
                <p class="text-muted lead mb-4">Resources and downloadable materials will be listed here shortly.</p>
                <a href="index.php?route=dashboard" class="btn btn-success rounded-pill px-4">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>