<?php
$title = 'Publications';
ob_start();
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0 rounded-4 p-5">
                <i class="fas fa-book-open fa-4x text-primary mb-4"></i>
                <h2 class="fw-bold mb-3">Publications</h2>
                <p class="text-muted lead mb-4">Our publications and research papers will be available here soon.</p>
                <a href="index.php?route=dashboard" class="btn btn-primary rounded-pill px-4">
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