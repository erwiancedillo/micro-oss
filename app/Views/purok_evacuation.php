<div class="container py-5">
<style>
    :root {
        --primary-purple: #8b5cf6;
        --secondary-purple: #6366f1;
        --accent-purple: #a855f7;
        --light-pink: #fdf2f8;
        --total-row-bg: #f5d0fe;
        --text-main: #1e1b4b;
        --text-muted: #64748b;
        --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
    }

    .main-container {
        max-width: 100%;
        margin: 0 auto;
        padding: 0.75rem;
    }

    .page-header {
        display: none;
    }

    .mobile-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0.25rem 1.25rem;
    }

    .mobile-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .mobile-title i {
        color: var(--primary-purple);
        font-size: 1.3rem;
    }

    .table-container {
        background: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        margin-bottom: 1rem;
        border: 1px solid #f1f5f9;
        overflow-x: auto;
    }

    .table-container h4 {
        color: var(--text-main);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .demographic-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        font-size: 0.8rem;
    }

    .demographic-table thead th {
        background-color: var(--primary-purple);
        color: white;
        padding: 0.75rem 0.5rem;
        font-weight: 600;
        text-align: center;
        border: none;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }

    .demographic-table tbody td {
        padding: 0.75rem 0.5rem;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        text-align: center;
        color: var(--text-main);
        font-weight: 500;
    }

    .demographic-table tbody td:last-child {
        border-right: none;
    }

    .demographic-table tbody tr:nth-child(even) {
        background-color: var(--light-pink);
    }

    .total-row {
        background-color: var(--total-row-bg) !important;
        font-weight: 800 !important;
        color: var(--primary-purple) !important;
    }

    .purok-name {
        text-align: left !important;
        padding-left: 1.5rem !important;
        font-weight: 600 !important;
    }

    .stats-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        border: 1px solid #f1f5f9;
    }

    .stats-card h5 {
        color: var(--primary-purple);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
    }

    .export-btn, .action-btn {
        background: white;
        color: var(--primary-purple);
        border: 1px solid var(--primary-purple);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-size: 0.9rem;
    }

    .export-btn:hover, .action-btn:hover {
        background: var(--primary-purple);
        color: white;
    }

    .btn-edit {
        background: var(--primary-purple);
        border: none;
        color: white;
        padding: 0.35rem 0.7rem;
        border-radius: 6px;
        font-size: 0.8rem;
    }

    .pagination .page-link {
        color: var(--primary-purple);
        border: 1px solid #e2e8f0;
        border-radius: 8px !important;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.2s;
        margin: 0 2px;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-purple);
        border-color: var(--primary-purple);
        color: white;
    }

    .text-purple { color: var(--primary-purple) !important; }

    @media (max-width: 768px) {
        .page-title { font-size: 1.8rem; }
        .main-container { padding: 1rem; }
        .table-container { padding: 1rem; }
    }
</style>
    </style>

    <?php if ($is_logged_in): ?>
        <div class="main-container main-content-protected">
            <div class="mobile-header">
                <h1 class="mobile-title">
                    <i class="fas fa-person-running"></i>Evacuation Plan
                </h1>
            </div>
            <?php
            if (isset($_SESSION['success'])): ?>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <i class='fas fa-check-circle me-2'></i><?php echo htmlspecialchars($_SESSION['success']); ?>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    <i class='fas fa-exclamation-triangle me-2'></i><?php echo htmlspecialchars($_SESSION['error']); ?>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <!-- Table Container -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">
                                <i class="fas fa-route me-2 text-purple"></i>Purok Evacuation Plan
                            </h4>
                        </div>

                        <?php
                        // Pagination variables
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $per_page = 10; // Show 10 records per page
                        $offset = ($page - 1) * $per_page;

                        // Get database connection
                        $conn = \App\Models\Database::getInstance()->getConnection();

                        // Get total records
                        $count_query = "SELECT COUNT(*) as total FROM purok_evacuation_plan";
                        $count_result = $conn->query($count_query);
                        $total_rows = $count_result->fetch()['total'];
                        $total_pages = ceil($total_rows / $per_page);

                        // Query to get evacuation plan data with pagination
                        $query = "SELECT * FROM purok_evacuation_plan ORDER BY purok_name ASC LIMIT $per_page OFFSET $offset";
                        $result = $conn->query($query);
                        $rows = $result->fetchAll();
                        ?>

                        <div class="table-responsive">
                            <table class="demographic-table shadow-sm" id="evacuationTable">
                                <thead>
                                    <tr>
                                        <th class="text-start ps-4">Purok Name</th>
                                        <th class="action-column">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($rows)) {
                                        foreach ($rows as $row) {
                                            echo "<tr>";
                                            echo "<td class='purok-name'>" . htmlspecialchars($row["purok_name"]) . "</td>";
                                            echo "<td class='action-column'>";
                                            echo "<button class='btn-view' style='background: #10b981; border: none; color: white; padding: 0.35rem 0.7rem; border-radius: 6px; font-size: 0.8rem; margin-right: 5px; margin-bottom: 5px;' onclick='viewEvacuationPlan(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")'><i class='fas fa-eye me-1'></i>View Details</button>";
                                            if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                                echo "<button class='btn-edit' style='margin-bottom: 5px;' onclick='editEvacuationPlan(" . $row["purok_id"] . ")'>";
                                                echo "<i class='fas fa-edit me-1'></i>Edit";
                                                echo "</button>";
                                            }
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='2' class='text-center'>No evacuation plan data available</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($total_pages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php if ($page > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($page < $total_pages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #8b5cf6; color: white;">
                        <h5 class="modal-title" id="editModalLabel">
                            <i class="fas fa-edit me-2"></i>Edit Evacuation Plan
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm" method="POST" action="../actions/update_evacuation_plan.php">
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="purok_id">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="editPurokName" class="form-label">Purok Name</label>
                                    <input type="text" class="form-control" id="editPurokName" name="purok_name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="editTotalPopFamilies" class="form-label">Total Population (Families)</label>
                                    <input type="number" class="form-control" id="editTotalPopFamilies" name="total_pop_families" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="editTotalPopPersons" class="form-label">Total Population (Persons)</label>
                                    <input type="number" class="form-control" id="editTotalPopPersons" name="total_pop_persons" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="editRiskPopFamilies" class="form-label">Vulnerable Population (Families)</label>
                                    <input type="number" class="form-control" id="editRiskPopFamilies" name="risk_pop_families" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="editRiskPopPersons" class="form-label">Vulnerable Population (Persons)</label>
                                    <input type="number" class="form-control" id="editRiskPopPersons" name="risk_pop_persons" min="0">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="editPlanACenterName" class="form-label">Plan A - Center Name</label>
                                    <input type="text" class="form-control" id="editPlanACenterName" name="plan_a_center_name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="editPlanACenterAddress" class="form-label">Plan A - Center Address</label>
                                    <input type="text" class="form-control" id="editPlanACenterAddress" name="plan_a_center_address">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editPlanACapacityFamilies" class="form-label">Plan A - Capacity (Families)</label>
                                    <input type="number" class="form-control" id="editPlanACapacityFamilies" name="plan_a_capacity_families" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editPlanACapacityPersons" class="form-label">Plan A - Capacity (Persons)</label>
                                    <input type="number" class="form-control" id="editPlanACapacityPersons" name="plan_a_capacity_persons" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="editToBeAccommodatedFamilies" class="form-label">To be Accommodated (Families)</label>
                                    <input type="number" class="form-control" id="editToBeAccommodatedFamilies" name="to_be_accommodated_families" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editToBeAccommodatedPersons" class="form-label">To be Accommodated (Persons)</label>
                                    <input type="number" class="form-control" id="editToBeAccommodatedPersons" name="to_be_accommodated_persons" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editNotAccommodatedFamilies" class="form-label">Not Accommodated (Families)</label>
                                    <input type="number" class="form-control" id="editNotAccommodatedFamilies" name="not_accommodated_families" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editNotAccommodatedPersons" class="form-label">Not Accommodated (Persons)</label>
                                    <input type="number" class="form-control" id="editNotAccommodatedPersons" name="not_accommodated_persons" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="editPlanBCenterName" class="form-label">Plan B - Center Name</label>
                                    <input type="text" class="form-control" id="editPlanBCenterName" name="plan_b_center_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="editPlanBCenterAddress" class="form-label">Plan B - Center Address</label>
                                    <input type="text" class="form-control" id="editPlanBCenterAddress" name="plan_b_center_address">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="editPlanBCapacityFamilies" class="form-label">Plan B - Cap (Families)</label>
                                    <input type="number" class="form-control" id="editPlanBCapacityFamilies" name="plan_b_capacity_families" min="0">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="editPlanBCapacityPersons" class="form-label">Plan B - Capacity (Persons)</label>
                                    <input type="number" class="form-control" id="editPlanBCapacityPersons" name="plan_b_capacity_persons" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editNotAccomPlanABFamilies" class="form-label">Not Accom (A&B) (Families)</label>
                                    <input type="number" class="form-control" id="editNotAccomPlanABFamilies" name="not_accom_plan_ab_families" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editNotAccomPlanABPersons" class="form-label">Not Accom (A&B) (Persons)</label>
                                    <input type="number" class="form-control" id="editNotAccomPlanABPersons" name="not_accom_plan_ab_persons" min="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="editRemarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="editRemarks" name="remarks">
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

    <?php endif; ?>

    <?php include __DIR__ . '/modals/view_purok_evacuation.php'; ?>

    <script>
        function editEvacuationPlan(id) {
            // Fetch evacuation plan data from the server
            fetch(`../actions/get_evacuation_plan.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Access the data object from the response
                        const evacuationData = data.data;

                        // Populate the modal fields with the data
                        document.getElementById('editId').value = evacuationData.purok_id;
                        document.getElementById('editPurokName').value = evacuationData.purok_name;
                        document.getElementById('editTotalPopFamilies').value = evacuationData.total_pop_families;
                        document.getElementById('editTotalPopPersons').value = evacuationData.total_pop_persons;
                        document.getElementById('editRiskPopFamilies').value = evacuationData.risk_pop_families;
                        document.getElementById('editRiskPopPersons').value = evacuationData.risk_pop_persons;
                        document.getElementById('editPlanACenterName').value = evacuationData.plan_a_center_name;
                        document.getElementById('editPlanACenterAddress').value = evacuationData.plan_a_center_address;
                        document.getElementById('editPlanACapacityFamilies').value = evacuationData.plan_a_capacity_families;
                        document.getElementById('editPlanACapacityPersons').value = evacuationData.plan_a_capacity_persons;
                        document.getElementById('editToBeAccommodatedFamilies').value = evacuationData.to_be_accommodated_families;
                        document.getElementById('editToBeAccommodatedPersons').value = evacuationData.to_be_accommodated_persons;
                        document.getElementById('editNotAccommodatedFamilies').value = evacuationData.not_accommodated_families;
                        document.getElementById('editNotAccommodatedPersons').value = evacuationData.not_accommodated_persons;
                        document.getElementById('editPlanBCenterName').value = evacuationData.plan_b_center_name;
                        document.getElementById('editPlanBCenterAddress').value = evacuationData.plan_b_center_address;
                        document.getElementById('editPlanBCapacityFamilies').value = evacuationData.plan_b_capacity_families;
                        document.getElementById('editPlanBCapacityPersons').value = evacuationData.plan_b_capacity_persons;
                        document.getElementById('editNotAccomPlanABFamilies').value = evacuationData.not_accom_plan_ab_families;
                        document.getElementById('editNotAccomPlanABPersons').value = evacuationData.not_accom_plan_ab_persons;
                        document.getElementById('editRemarks').value = evacuationData.remarks;

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('editModal'));
                        modal.show();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching evacuation plan data:', error);
                    alert('Error fetching evacuation plan data. Please try again.');
                });
        }

        function viewEvacuationPlan(rowData) {
            document.getElementById('view_evac_purok_name').textContent = rowData.purok_name || '';
            document.getElementById('view_evac_total_fam').textContent = Number(rowData.total_pop_families || 0).toLocaleString();
            document.getElementById('view_evac_total_pers').textContent = Number(rowData.total_pop_persons || 0).toLocaleString();
            document.getElementById('view_evac_vuln_fam').textContent = Number(rowData.risk_pop_families || 0).toLocaleString();
            document.getElementById('view_evac_vuln_pers').textContent = Number(rowData.risk_pop_persons || 0).toLocaleString();
            document.getElementById('view_evac_plan_a_center').textContent = rowData.plan_a_center_name || 'No Center Assigned';
            document.getElementById('view_evac_plan_a_address').innerHTML = `<i class="fas fa-map-marker-alt me-1"></i>${rowData.plan_a_center_address || 'No Address'}`;
            document.getElementById('view_evac_plan_a_cap_fam').textContent = Number(rowData.plan_a_capacity_families || 0).toLocaleString();
            document.getElementById('view_evac_plan_a_cap_pers').textContent = Number(rowData.plan_a_capacity_persons || 0).toLocaleString();
            document.getElementById('view_evac_to_accom_fam').textContent = Number(rowData.to_be_accommodated_families || 0).toLocaleString();
            document.getElementById('view_evac_to_accom_pers').textContent = Number(rowData.to_be_accommodated_persons || 0).toLocaleString();
            document.getElementById('view_evac_not_accom_fam').textContent = Number(rowData.not_accommodated_families || 0).toLocaleString();
            document.getElementById('view_evac_not_accom_pers').textContent = Number(rowData.not_accommodated_persons || 0).toLocaleString();
            document.getElementById('view_evac_plan_b_center').textContent = rowData.plan_b_center_name || 'No Center Assigned';
            document.getElementById('view_evac_plan_b_address').innerHTML = `<i class="fas fa-map-marker-alt me-1"></i>${rowData.plan_b_center_address || 'No Address'}`;
            document.getElementById('view_evac_plan_b_cap_fam').textContent = Number(rowData.plan_b_capacity_families || 0).toLocaleString();
            document.getElementById('view_evac_plan_b_cap_pers').textContent = Number(rowData.plan_b_capacity_persons || 0).toLocaleString();
            document.getElementById('view_evac_not_accom_ab_fam').textContent = Number(rowData.not_accom_plan_ab_families || 0).toLocaleString();
            document.getElementById('view_evac_not_accom_ab_pers').textContent = Number(rowData.not_accom_plan_ab_persons || 0).toLocaleString();
            document.getElementById('view_evac_remarks').textContent = rowData.remarks || 'No remarks provided.';

            const modal = new bootstrap.Modal(document.getElementById('viewEvacuationModal'));
            modal.show();
        }

        // Add row click functionality (exclude action column clicks)
        document.querySelectorAll('.demographic-table tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                // Don't highlight row if clicking on action button
                if (e.target.tagName === 'BUTTON' || e.target.tagName === 'I') {
                    return;
                }

                // Highlight selected row
                const parentTable = this.closest('table');
                parentTable.querySelectorAll('tbody tr').forEach(r => {
                    r.style.backgroundColor = '';
                    const purokCell = r.querySelector('.purok-name');
                    if (purokCell) {
                        purokCell.style.backgroundColor = r.rowIndex % 2 === 0 ? 'var(--light-pink)' : '#fff';
                    }
                });

                this.style.backgroundColor = '#fbbf24';
                const currentPurokCell = this.querySelector('.purok-name');
                if (currentPurokCell) {
                    currentPurokCell.style.backgroundColor = '#fbbf24';
                }
            });
        });
    </script>

    <!-- Bootstrap JS -->
</div>