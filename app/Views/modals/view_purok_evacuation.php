<!-- View Evacuation Plan Modal -->
<div class="modal fade" id="viewEvacuationModal" tabindex="-1" aria-labelledby="viewEvacuationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-bottom: none;">
                <h5 class="modal-title fw-bold" id="viewEvacuationModalLabel">
                    <i class="fas fa-eye me-2"></i>Evacuation Plan Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold text-dark mb-1" id="view_evac_purok_name">Purok Name</h4>
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">Evacuation Plan</span>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-users me-2"></i>Population Overview</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <p class="mb-1 text-muted small fw-bold text-uppercase">Total Population</p>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted small">Families:</span>
                                            <span class="fw-bold text-dark" id="view_evac_total_fam">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Persons:</span>
                                            <span class="fw-bold text-dark" id="view_evac_total_pers">0</span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <p class="mb-1 text-muted small fw-bold text-uppercase text-danger">Vulnerable</p>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted small">Families:</span>
                                            <span class="fw-bold text-dark text-danger" id="view_evac_vuln_fam">0</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted small">Persons:</span>
                                            <span class="fw-bold text-dark text-danger" id="view_evac_vuln_pers">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10 border border-warning">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-exclamation-triangle text-warning me-2"></i>Not Accommodated (A & B)</h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted fw-medium">Unaccommodated Families:</span>
                                    <span class="fw-bold fs-5 text-dark" id="view_evac_not_accom_ab_fam">0</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted fw-medium">Unaccommodated Persons:</span>
                                    <span class="fw-bold fs-5 text-dark" id="view_evac_not_accom_ab_pers">0</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-building text-primary me-2"></i>Plan A: Primary Evacuation Center</h6>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-dark mb-0" id="view_evac_plan_a_center">Plan A Center Name</h5>
                                    <p class="text-muted small mb-0" id="view_evac_plan_a_address"><i class="fas fa-map-marker-alt me-1"></i>Address</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="p-2 bg-light rounded mb-2">
                                            <p class="mb-0 text-muted small fw-bold">Capacity</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="small">Families: <b class="text-dark" id="view_evac_plan_a_cap_fam">0</b></span>
                                                <span class="small">Persons: <b class="text-dark" id="view_evac_plan_a_cap_pers">0</b></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 bg-success bg-opacity-10 rounded mb-2 border border-success">
                                            <p class="mb-0 text-success small fw-bold">To Accommodate</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="small">Families: <b class="text-success" id="view_evac_to_accom_fam">0</b></span>
                                                <span class="small">Persons: <b class="text-success" id="view_evac_to_accom_pers">0</b></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 bg-danger bg-opacity-10 rounded mb-2 border border-danger">
                                            <p class="mb-0 text-danger small fw-bold">Not Accommodated</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="small">Families: <b class="text-danger" id="view_evac_not_accom_fam">0</b></span>
                                                <span class="small">Persons: <b class="text-danger" id="view_evac_not_accom_pers">0</b></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-campground text-info me-2"></i>Plan B: Secondary Evacuation Center</h6>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-dark mb-0" id="view_evac_plan_b_center">Plan B Center Name</h5>
                                    <p class="text-muted small mb-0" id="view_evac_plan_b_address"><i class="fas fa-map-marker-alt me-1"></i>Address</p>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="p-2 bg-light rounded">
                                            <p class="mb-0 text-muted small fw-bold">Capacity</p>
                                            <div class="d-flex justify-content-between">
                                                <span class="small">Families: <b class="text-dark" id="view_evac_plan_b_cap_fam">0</b></span>
                                                <span class="small">Persons: <b class="text-dark" id="view_evac_plan_b_cap_pers">0</b></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body p-3 text-center">
                                <h6 class="text-secondary fw-bold mb-1"><i class="fas fa-comment text-muted me-2"></i>Remarks</h6>
                                <p class="mb-0 text-dark fst-italic" id="view_evac_remarks">No remarks</p>
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
