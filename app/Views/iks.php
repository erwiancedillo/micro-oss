<style>
    .iks-container { max-width: 1200px; margin: 0 auto; padding: 2rem 1rem; }
    .iks-header { 
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        color: white; 
        padding: 3rem 2rem; 
        border-radius: 1.5rem; 
        margin-bottom: 3rem; 
        box-shadow: 0 10px 30px rgba(118, 75, 162, 0.2);
    }
    .section-title { 
        font-weight: 800; 
        color: #2d3748; 
        margin-bottom: 2rem; 
        display: flex; 
        align-items: center; 
        border-bottom: 2px solid #edf2f7;
        padding-bottom: 0.75rem;
    }
    .section-title i { color: #667eea; margin-right: 1rem; }
    .knowledge-card { 
        background: white; 
        border-radius: 1.25rem; 
        border: 1px solid #e2e8f0; 
        padding: 2rem; 
        transition: all 0.3s ease;
        height: 100%;
    }
    .knowledge-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); border-color: #cbd5e1; }
    .iks-img-wrapper { 
        background: #f8fafc; 
        border-radius: 1rem; 
        padding: 1.5rem; 
        text-align: center;
        margin-bottom: 1.5rem;
    }
    .iks-img { max-width: 100%; height: auto; transition: transform 0.5s ease; }
    .knowledge-card:hover .iks-img { transform: scale(1.05); }
    .significance-box { 
        background: #f0f7ff; 
        border-left: 4px solid #3b82f6; 
        padding: 1.25rem; 
        border-radius: 0.5rem; 
        margin-top: 1.5rem;
    }
</style>

<div class="iks-container">
    <div class="iks-header text-center">
        <h1 class="display-5 fw-bold mb-2"><i class="fas fa-feather-alt me-3"></i>Indigenous Knowledge Systems</h1>
        <p class="lead opacity-90">Traditional Wisdom for Flood Prediction & Prevention</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-11">
            <div class="text-center mb-5">
                <i class="fas fa-users-viewfinder fa-3x text-primary opacity-20 mb-3"></i>
                <p class="lead text-muted mx-auto" style="max-width: 900px;">
                    Indigenous communities in the Philippines have developed rich and detailed systems for understanding and predicting floods. These systems are rooted in centuries of observation of the natural environment, reflecting a profound connection between people and nature.
                </p>
            </div>

            <!-- Prediction Section -->
            <?php if (!empty($predictionItems)): ?>
                <h3 class="section-title"><i class="fas fa-paw"></i>Flood Prediction through Animal Behavior</h3>
                <?php foreach ($predictionItems as $item): ?>
                    <div class="row align-items-center mb-5 gap-lg-5">
                        <div class="col-lg-7">
                            <h4 class="fw-bold mb-3"><?= htmlspecialchars($item['title']) ?></h4>
                            <p class="text-secondary" style="font-size: 1.1rem; line-height: 1.7;">
                                <?= htmlspecialchars($item['description']) ?>
                            </p>
                            <?php if ($item['significance']): ?>
                                <div class="significance-box">
                                    <h6 class="fw-bold text-primary mb-2"><i class="fas fa-microscope me-2"></i>Context and Significance</h6>
                                    <p class="small mb-0 text-dark opacity-80"><?= htmlspecialchars($item['significance']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="knowledge-card text-center p-4">
                                <div class="iks-img-wrapper">
                                    <img src="<?= htmlspecialchars($item['icon_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="iks-img" style="max-height: 200px;">
                                </div>
                                <p class="small text-muted mb-0">Traditional indicator: <?= htmlspecialchars($item['title']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Weather Section -->
            <?php if (!empty($weatherItems)): ?>
                <h3 class="section-title"><i class="fas fa-cloud-sun"></i>Understanding Weather Patterns</h3>
                <p class="mb-4 text-muted">Indigenous communities also rely on various natural indicators to forecast weather patterns, demonstrating a holistic approach to environmental awareness:</p>
                
                <div class="row g-4 mb-5">
                    <?php foreach ($weatherItems as $item): ?>
                        <div class="col-md-4">
                            <div class="knowledge-card">
                                <div class="iks-img-wrapper" style="padding: 1rem;">
                                    <img src="<?= htmlspecialchars($item['icon_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="iks-img" style="height: 100px; width: auto; object-fit: contain;">
                                </div>
                                <h5 class="fw-bold mb-3"><?= htmlspecialchars($item['title']) ?></h5>
                                <p class="small text-secondary mb-0"><?= htmlspecialchars($item['description']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="alert alert-primary border-0 rounded-4 shadow-sm p-4 d-flex align-items-center mb-5" style="background: rgba(102, 126, 234, 0.05);">
                    <div class="bg-primary text-white p-3 rounded-circle me-4">
                        <i class="fas fa-lightbulb fa-lg"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1">Holistic Insight</h6>
                        <p class="mb-0 small opacity-80">By observing all elements of the environment, Indigenous communities gain a deeper understanding of weather changes without relying on modern technology.</p>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Prevention Section -->
            <?php if (!empty($preventionItems)): ?>
                <h3 class="section-title"><i class="fas fa-shield-virus"></i>Flood Prevention Practices</h3>
                <div class="row g-4 mb-5">
                    <?php foreach ($preventionItems as $item): ?>
                        <div class="col-md-6">
                            <div class="knowledge-card d-flex align-items-center gap-4">
                                <div class="flex-shrink-0 iks-img-wrapper mb-0" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= htmlspecialchars($item['icon_url']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="img-fluid rounded">
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-2"><?= htmlspecialchars($item['title']) ?></h5>
                                    <p class="small text-muted mb-0"><?= htmlspecialchars($item['description']) ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Conclusion -->
            <div class="mt-5 pt-5 border-top text-center">
                <div class="bg-light p-5 rounded-4 border border-white">
                    <h4 class="text-primary fw-bold mb-3">Community Wisdom & Resilience</h4>
                    <p class="lead text-muted mx-auto mb-0" style="max-width: 800px;">
                        Indigenous knowledge provides valuable insights into flood prediction and prevention. These practices emphasize a deep connection to nature and highlight sustainable ways to mitigate environmental risks.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
