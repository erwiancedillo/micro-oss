<!-- View Household Data Modal -->
<div class="modal fade" id="viewHouseholdDataModal" tabindex="-1" aria-labelledby="viewHouseholdDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white; border-bottom: none;">
                <h5 class="modal-title fw-bold" id="viewHouseholdDataModalLabel">
                    <i class="fas fa-eye me-2"></i>Data Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-light">
                <div class="text-center mb-4 pb-3 border-bottom">
                    <h4 class="fw-bold text-dark mb-1" id="view_data_title">Type Name</h4>
                    <span class="badge bg-primary px-3 py-2 rounded-pill shadow-sm" id="view_data_category">Category</span>
                </div>

                <div class="row g-3">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-body">
                                <h6 class="text-secondary fw-bold mb-3 border-bottom pb-2"><i class="fas fa-chart-bar text-info me-2"></i>Statistics</h6>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted fw-medium">Number of Households:</span>
                                    <span class="fw-bold fs-5 text-dark" id="view_data_households">0</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted fw-medium">Percentage:</span>
                                    <span class="fw-bold fs-5 text-dark" id="view_data_percentage">0%</span>
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
