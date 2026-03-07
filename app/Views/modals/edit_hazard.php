 <!-- Edit Modal -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header" style="background-color: #8b5cf6; color: white;">
                 <h5 class="modal-title" id="editModalLabel">
                     <i class="fas fa-edit me-2"></i>Edit Hazard Data
                 </h5>
                 <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="editForm" method="POST" action="/micro-oss/index.php?route=api-update-hazard">
                 <div class="modal-body">
                     <input type="hidden" id="editId" name="id">
                     <div class="row">
                         <div class="col-md-12 mb-3">
                             <label for="editArea" class="form-label">Area</label>
                             <input type="text" class="form-control" id="editArea" name="area" required>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-4 mb-3">
                             <label for="editLowFamily" class="form-label">Low Family</label>
                             <input type="number" class="form-control" id="editLowFamily" name="low_family" min="0" required>
                         </div>
                         <div class="col-md-4 mb-3">
                             <label for="editLowPerson" class="form-label">Low Person</label>
                             <input type="number" class="form-control" id="editLowPerson" name="low_person" min="0" required>
                         </div>
                         <div class="col-md-4 mb-3">
                             <label for="editModerateFamily" class="form-label">Moderate Family</label>
                             <input type="number" class="form-control" id="editModerateFamily" name="moderate_family" min="0" required>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col-md-4 mb-3">
                             <label for="editModeratePerson" class="form-label">Moderate Person</label>
                             <input type="number" class="form-control" id="editModeratePerson" name="moderate_person" min="0" required>
                         </div>
                         <div class="col-md-4 mb-3">
                             <label for="editHighFamily" class="form-label">High Family</label>
                             <input type="number" class="form-control" id="editHighFamily" name="high_family" min="0" required>
                         </div>
                         <div class="col-md-4 mb-3">
                             <label for="editHighPerson" class="form-label">High Person</label>
                             <input type="number" class="form-control" id="editHighPerson" name="high_person" min="0" required>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-primary" style="background: #8b5cf6; border-color: #8b5cf6;">
                         <i class="fas fa-save me-1"></i>Save Changes
                     </button>
                 </div>
             </form>
         </div>
     </div>
 </div>