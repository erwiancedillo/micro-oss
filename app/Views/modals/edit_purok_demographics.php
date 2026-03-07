<!-- Edit Purok Demographics Modal -->
<div class="modal fade" id="editPurokModal" tabindex="-1" aria-labelledby="editPurokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="editPurokModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Purok Demographic Data
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPurokForm" action="/micro-oss/index.php?route=api-update-purok-data" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="purok_name" id="edit_purok_name">

                    <div class="row g-3">
                        <div class="col-12">
                            <h6 class="border-bottom pb-2 mb-3 text-purple"><i class="fas fa-home me-2"></i>Basic Information</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Purok Name</label>
                                    <input type="text" class="form-control" id="display_purok_name" disabled>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Total Families</label>
                                    <input type="number" name="total_families" id="edit_total_families" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-venus-mars me-2"></i>Total Persons</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Male</label>
                                    <input type="number" name="total_persons_male" id="edit_total_persons_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Female</label>
                                    <input type="number" name="total_persons_female" id="edit_total_persons_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-info"><i class="fas fa-baby me-2"></i>Infants</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Infant Male</label>
                                    <input type="number" name="infant_male" id="edit_infant_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Infant Female</label>
                                    <input type="number" name="infant_female" id="edit_infant_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-success"><i class="fas fa-child me-2"></i>Children</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Children Male</label>
                                    <input type="number" name="children_male" id="edit_children_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Children Female</label>
                                    <input type="number" name="children_female" id="edit_children_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-warning"><i class="fas fa-user-friends me-2"></i>Adults</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Adult Male</label>
                                    <input type="number" name="adult_male" id="edit_adult_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Adult Female</label>
                                    <input type="number" name="adult_female" id="edit_adult_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-danger"><i class="fas fa-user-clock me-2"></i>Elderly</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Elderly Male</label>
                                    <input type="number" name="elderly_male" id="edit_elderly_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Elderly Female</label>
                                    <input type="number" name="elderly_female" id="edit_elderly_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-secondary"><i class="fas fa-wheelchair me-2"></i>Special Needs</h6>
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">PWD Male</label>
                                    <input type="number" name="pwd_male" id="edit_pwd_male" class="form-control" required min="0">
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">PWD Female</label>
                                    <input type="number" name="pwd_female" id="edit_pwd_female" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2 mb-3 text-dark"><i class="fas fa-notes-medical me-2"></i>Health & More</h6>
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label">Sick M</label>
                                    <input type="number" name="sickness_male" id="edit_sickness_male" class="form-control" required min="0">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Sick F</label>
                                    <input type="number" name="sickness_female" id="edit_sickness_female" class="form-control" required min="0">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label">Preg.</label>
                                    <input type="number" name="pregnant_women" id="edit_pregnant_women" class="form-control" required min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3">
                    <button type="button" class="btn btn-secondary border-0" data-bs-dismiss="modal" style="border-radius: 8px; padding: 10px 20px;">Cancel</button>
                    <button type="submit" class="btn btn-primary border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; padding: 10px 25px;">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>