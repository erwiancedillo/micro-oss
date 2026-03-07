<?php
$title = 'Population Analysis';
ob_start();
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card shadow-sm border-0 rounded-4 p-5">
                <i class="fas fa-users-viewfinder fa-4x text-indigo mb-4"></i>
                <h2 class="fw-bold mb-3">Population Analysis</h2>
                <p class="text-muted lead mb-4">Demographic data and population analysis tools are under development.</p>
                <a href="index.php?route=dashboard" class="btn btn-primary rounded-pill px-4" style="background-color: #6366f1; border: none;">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<style>
    .text-indigo {
        color: #6366f1;
    }
</style>
<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>