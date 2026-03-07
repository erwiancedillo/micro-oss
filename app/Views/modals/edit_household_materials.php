<!-- Edit Construction Material Modal -->
<div class="modal fade" id="editMaterialModal" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="editMaterialModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Construction Material
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/micro-oss/index.php?route=api-update-material" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="material_name" id="edit_material_name">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Type of Material</label>
                        <input type="text" class="form-control" id="display_material_name" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Number of Households</label>
                        <input type="number" name="households" id="edit_material_households" class="form-control" required min="0">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary border-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Ownership Type Modal -->
<div class="modal fade" id="editOwnershipModal" tabindex="-1" aria-labelledby="editOwnershipModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="editOwnershipModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Ownership Type
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/micro-oss/index.php?route=api-update-ownership" method="POST">
                <div class="modal-body p-4">
                    <input type="hidden" name="ownership_type" id="edit_ownership_type">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Type of Ownership</label>
                        <input type="text" class="form-control" id="display_ownership_type" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Number of Households</label>
                        <input type="number" name="households" id="edit_ownership_households" class="form-control" required min="0">
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary border-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>