<!-- Add Age Bracket Modal -->
<div class="modal fade" id="addAgeBracketModal" tabindex="-1" aria-labelledby="addAgeBracketModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
                <h5 class="modal-title fw-bold" id="addAgeBracketModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add Age Bracket
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAgeBracketForm" action="index.php?route=api-add-age-bracket" method="POST">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="age_bracket" class="form-label fw-bold text-muted small text-uppercase">Age Bracket (Year)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-calendar-alt text-primary"></i></span>
                            <input type="text" class="form-control bg-light border-start-0" id="age_bracket" name="age_bracket" placeholder="e.g. 18-59" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="female_count" class="form-label fw-bold text-muted small text-uppercase">Female</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-venus text-pink"></i></span>
                                <input type="number" class="form-control bg-light border-start-0 count-input" id="female_count" name="female" value="0" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="male_count" class="form-label fw-bold text-muted small text-uppercase">Male</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-mars text-info"></i></span>
                                <input type="number" class="form-control bg-light border-start-0 count-input" id="male_count" name="male" value="0" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-0">
                        <label for="total_count" class="form-label fw-bold text-muted small text-uppercase">Total Population</label>
                        <div class="input-group">
                            <span class="input-group-text bg-dark text-white border-end-0"><i class="fas fa-users"></i></span>
                            <input type="text" class="form-control bg-dark text-white border-start-0 fw-bold" id="total_count" name="total" value="0" readonly>
                        </div>
                        <small class="text-muted mt-1 d-block"><i class="fas fa-info-circle me-1"></i>Total is automatically calculated</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 px-4 py-3">
                    <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill shadow-sm" style="background: #8b5cf6; border-color: #8b5cf6;">
                        <i class="fas fa-save me-2"></i>Save Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .text-pink {
        color: #ec4899;
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #8b5cf6;
    }

    .input-group-text {
        border-color: #dee2e6;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const femaleInput = document.getElementById('female_count');
        const maleInput = document.getElementById('male_count');
        const totalInput = document.getElementById('total_count');

        function calculateTotal() {
            const female = parseInt(femaleInput.value) || 0;
            const male = parseInt(maleInput.value) || 0;
            totalInput.value = (female + male).toLocaleString();
        }

        femaleInput.addEventListener('input', calculateTotal);
        maleInput.addEventListener('input', calculateTotal);
    });
</script>