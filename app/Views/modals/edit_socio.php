<div class="modal fade" id="editSocioModal" tabindex="-1" aria-labelledby="editSocioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: var(--primary-purple); color: white;">
                <h5 class="modal-title" id="editSocioModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Age Bracket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSocioForm" method="POST" action="/micro-oss/index.php?route=api-update-socio-data">
                <div class="modal-body">
                    <input type="hidden" id="edit_original_age_bracket" name="original_age_bracket">

                    <div class="mb-3">
                        <label for="edit_socio_age_bracket" class="form-label">Age Bracket</label>
                        <input type="text" class="form-control" id="edit_socio_age_bracket" name="age_bracket" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_socio_female" class="form-label">Female Population</label>
                        <input type="number" class="form-control" id="edit_socio_female" name="female" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_socio_male" class="form-label">Male Population</label>
                        <input type="number" class="form-control" id="edit_socio_male" name="male" min="0" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <input type="number" class="form-control" id="edit_socio_total" readonly disabled>
                        <small class="text-muted">Calculated automatically</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background-color: var(--primary-purple); border-color: var(--primary-purple);">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const femaleInput = document.getElementById('edit_socio_female');
        const maleInput = document.getElementById('edit_socio_male');
        const totalInput = document.getElementById('edit_socio_total');

        function updateTotal() {
            const f = parseInt(femaleInput.value) || 0;
            const m = parseInt(maleInput.value) || 0;
            totalInput.value = f + m;
        }

        if (femaleInput && maleInput && totalInput) {
            femaleInput.addEventListener('input', updateTotal);
            maleInput.addEventListener('input', updateTotal);
        }
    });

    function editPopulationData(ageBracket, female, male) {
        document.getElementById('edit_original_age_bracket').value = ageBracket;
        document.getElementById('edit_socio_age_bracket').value = ageBracket;
        document.getElementById('edit_socio_female').value = female;
        document.getElementById('edit_socio_male').value = male;

        // Trigger calculation
        const f = parseInt(female) || 0;
        const m = parseInt(male) || 0;
        document.getElementById('edit_socio_total').value = f + m;

        const modal = new bootstrap.Modal(document.getElementById('editSocioModal'));
        modal.show();
    }
</script>