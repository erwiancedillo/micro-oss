<style>
    .alert-card { border: none; border-radius: 12px; transition: all 0.3s ease; }
    .alert-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .status-dot { width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px; }
    .bg-Green { background-color: #22c55e; }
    .bg-Yellow { background-color: #eab308; }
    .bg-Orange { background-color: #f97316; }
    .bg-Red { background-color: #ef4444; }
    .text-Green { color: #166534; }
    .text-Yellow { color: #854d0e; }
    .text-Orange { color: #9a3412; }
    .text-Red { color: #991b1b; }
    .alert-box-Green { background-color: #dcfce7; border-left: 5px solid #22c55e; }
    .alert-box-Yellow { background-color: #fef9c3; border-left: 5px solid #eab308; }
    .alert-box-Orange { background-color: #ffedd5; border-left: 5px solid #f97316; }
    .alert-box-Red { background-color: #fee2e2; border-left: 5px solid #ef4444; }
    
    @keyframes pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.7; }
        100% { transform: scale(1); opacity: 1; }
    }
    .animate-pulse {
        animation: pulse 2s infinite ease-in-out;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h2 class="fw-bold text-primary mb-0">
                        <i class="fas fa-broadcast-tower me-2"></i>Flood Alert System
                    </h2>
                    <span class="badge bg-light text-dark px-3 py-2 border">
                        <i class="far fa-clock me-1"></i> <?= $timestamp ?>
                    </span>
                </div>
            </div>
            
            <div class="card-body p-4">
                <!-- Flood Monitoring Connection Banner -->
                <?php if (isset($weather) && $weather): ?>
                <div class="alert border-0 rounded-3 mb-4 p-3 d-flex align-items-center justify-content-between flex-wrap gap-2" 
                     style="background: linear-gradient(135deg, rgba(102,126,234,0.08), rgba(118,75,162,0.08)); border-left: 4px solid #667eea !important;">
                    <div class="d-flex align-items-center gap-3">
                        <div class="fs-3 text-primary"><i class="<?= $weather['icon'] ?>"></i></div>
                        <div>
                            <div class="fw-bold" style="font-size: 0.9rem;"><?= $weather['temp'] ?> · <?= $weather['condition'] ?></div>
                            <div class="text-muted small">
                                <i class="fas fa-tint me-1 text-info"></i>Rainfall: <?= $weather['rainfall'] ?>
                                <?php if ((float)str_replace('mm', '', $weather['rainfall']) > 20): ?>
                                    <span class="badge bg-warning text-dark ms-1" style="font-size: 0.6rem;">Heavy</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <a href="/micro-oss/index.php?route=flood-monitoring" class="btn btn-sm btn-primary rounded-pill px-3">
                        <i class="fas fa-map me-1"></i>Flood Monitor Map
                    </a>
                </div>
                <?php endif; ?>

                <!-- Barangay Selection -->
                <div class="mb-4">
                    <label class="form-label fw-bold"><i class="fas fa-search me-1 text-muted"></i> Select Barangay</label>
                    <form method="GET" action="/micro-oss/index.php" id="alertForm">
                        <input type="hidden" name="route" value="alerts">
                        <select name="barangay" class="form-select form-select-lg rounded-3" onchange="this.form.submit()" required>
                            <option value="">-- Choose Barangay --</option>
                            <?php foreach ($barangayList as $b): ?>
                                <option value="<?= htmlspecialchars($b) ?>" <?= ($barangay === $b) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </div>

                <?php if ($barangay !== null): ?>
                    <!-- Current Alert Level -->
                    <div class="alert-box-<?= $alertColors[$barangayAlert] ?> p-4 rounded-4 mb-4 shadow-sm">
                        <div class="d-flex align-items-center mb-3">
                            <div class="status-dot bg-<?= $alertColors[$barangayAlert] ?> animate-pulse"></div>
                            <h4 class="mb-0 fw-bold text-<?= $alertColors[$barangayAlert] ?>">
                                <?= htmlspecialchars($barangay) ?>: <?= strtoupper($alertColors[$barangayAlert]) ?>
                            </h4>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="fw-bold mb-1 opacity-75">ADVISORY:</h6>
                            <p class="mb-0 fs-5"><?= !empty($barangayAdvisory) ? htmlspecialchars($barangayAdvisory) : "No specific advisory issued for this location." ?></p>
                        </div>
                        
                        <div class="p-3 bg-white bg-opacity-50 rounded-3">
                            <h6 class="fw-bold mb-1 text-muted small">PROTOCOL:</h6>
                            <p class="mb-0 small text-dark"><?= $educationMsg[$barangayAlert] ?></p>
                        </div>
                    </div>

                    <!-- Sitio-Level Alerts -->
                    <h5 class="fw-bold mt-5 mb-4 px-2">
                        <i class="fas fa-map-marker-alt me-2 text-danger"></i>Sitio-Level Alerts
                    </h5>
                    
                    <div class="row g-3">
                        <?php if (count($sitios) > 0): ?>
                            <?php foreach ($sitios as $s): ?>
                                <div class="col-md-6">
                                    <div class="card h-100 alert-card alert-box-<?= $alertColors[(int)($s['flood_level'] ?? 0)] ?>">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold mb-0"><?= htmlspecialchars($s['sitio_name']) ?></h6>
                                                <span class="badge bg-<?= $alertColors[(int)($s['flood_level'] ?? 0)] ?> rounded-pill">
                                                    <?= $alertColors[(int)($s['flood_level'] ?? 0)] ?>
                                                </span>
                                            </div>
                                            <p class="small mb-0 opacity-75">
                                                <?= !empty($s['flood_advisory']) ? htmlspecialchars($s['flood_advisory']) : "Normal conditions." ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p class="text-center text-muted py-4 bg-light rounded-3">
                                    No detailed sitio data recorded for this barangay.
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <!-- Welcome / Instruction State -->
                    <div class="text-center py-5">
                        <div class="mb-4 text-muted">
                            <i class="fas fa-map-marked-alt fa-4x opacity-25"></i>
                        </div>
                        <h4 class="text-muted">Please select a barangay</h4>
                        <p class="text-muted">View real-time flood alert levels and evacuation protocols for your area.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>