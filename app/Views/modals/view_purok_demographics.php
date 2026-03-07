<!-- View Purok Demographics Modal -->
<div class="modal fade" id="viewPurokModal" tabindex="-1" aria-labelledby="viewPurokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-bottom: none;">
                <h5 class="modal-title fw-bold" id="viewPurokModalLabel">
                    <i class="fas fa-eye me-2"></i>Purok Demographic Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold text-dark mb-1" id="view_purok_name_display">Purok Name</h4>
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">Demographic Data</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-users me-2"></i>General Overview</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-medium">Total Families:</span>
                                    <span class="fw-bold text-dark" id="view_total_families">0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-medium">Total Male:</span>
                                    <span class="fw-bold text-dark" id="view_total_persons_male">0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted fw-medium">Total Female:</span>
                                    <span class="fw-bold text-dark" id="view_total_persons_female">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-venus-mars me-2"></i>Age Groups (Male & Female)</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Infant Male:</span>
                                            <span class="fw-bold text-dark" id="view_infant_male">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Children Male:</span>
                                            <span class="fw-bold text-dark" id="view_children_male">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Adult Male:</span>
                                            <span class="fw-bold text-dark" id="view_adult_male">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted fw-medium">Elderly Male:</span>
                                            <span class="fw-bold text-dark" id="view_elderly_male">0</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Infant Female:</span>
                                            <span class="fw-bold text-dark" id="view_infant_female">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Children Female:</span>
                                            <span class="fw-bold text-dark" id="view_children_female">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Adult Female:</span>
                                            <span class="fw-bold text-dark" id="view_adult_female">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted fw-medium">Elderly Female:</span>
                                            <span class="fw-bold text-dark" id="view_elderly_female">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-heartbeat me-2 text-danger"></i>Special Categories</h6>
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">PWD Male:</span>
                                            <span class="fw-bold text-dark" id="view_pwd_male">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted fw-medium">PWD Female:</span>
                                            <span class="fw-bold text-dark" id="view_pwd_female">0</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-muted fw-medium">Sick Male:</span>
                                            <span class="fw-bold text-dark" id="view_sickness_male">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted fw-medium">Sick Female:</span>
                                            <span class="fw-bold text-dark" id="view_sickness_female">0</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 mt-2 mt-md-0 d-flex justify-content-between align-items-center">
                                        <span class="text-muted fw-medium">Pregnant Women:</span>
                                        <span class="fw-bold fs-5 text-dark" id="view_pregnant_women">0</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-white border-top-0 pt-0">
                <button type="button" class="btn btn-secondary w-100 fw-bold rounded-pill" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
