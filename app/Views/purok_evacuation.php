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
        padding: 2rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--secondary-purple) 0%, var(--accent-purple) 100%);
        padding: 2.5rem;
        border-radius: 20px;
        color: white;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        text-align: center;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .page-title i {
        font-size: 2.8rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .table-container {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
        border: 1px solid #f1f5f9;
        overflow-x: auto;
    }

    .table-container h4 {
        color: var(--text-main);
        font-weight: 600;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .demographic-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        min-width: 1800px;
        font-size: 0.8rem;
    }

    .demographic-table thead th {
        background-color: var(--primary-purple);
        color: white;
        padding: 0.75rem 0.5rem;
        font-weight: 600;
        text-align: center;
        border: none;
        font-size: 0.7rem;
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
        padding-left: 1rem !important;
        font-weight: 600 !important;
        background-color: #fff;
        position: sticky;
        left: 0;
        z-index: 1;
        border-right: 2px solid #e2e8f0 !important;
    }

    tr:nth-child(even) .purok-name {
        background-color: var(--light-pink);
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
            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                echo "<i class='fas fa-check-circle me-2'></i>" . htmlspecialchars($_SESSION['success']);
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo "</div>";
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                echo "<i class='fas fa-exclamation-triangle me-2'></i>" . htmlspecialchars($_SESSION['error']);
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
                echo "</div>";
                unset($_SESSION['error']);
            }
            ?>
            <div class="page-header">
                <h1 class="page-title">
                    <i class="fas fa-person-running me-3"></i>Purok Evacuation Population
                </h1>
                <p class="page-subtitle">Evacuation plan of the affected population in times of disaster or emergency.</p>
            </div>

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
                                        <th title="Purok Name">Purok Name</th>
                                        <th title="Total Population (Families)">Total Pop (Fam)</th>
                                        <th title="Total Population (Persons)">Total Pop (Pers)</th>
                                        <th title="Vulnerable Population (Families)">Vuln Pop (Fam)</th>
                                        <th title="Vulnerable Population (Persons)">Vuln Pop (Pers)</th>
                                        <th title="Plan A - Center Name">Plan A - Center</th>
                                        <th title="Plan A - Center Address">Plan A - Address</th>
                                        <th title="Plan A - Capacity (Families)">Plan A Cap (Fam)</th>
                                        <th title="Plan A - Capacity (Persons)">Plan A Cap (Pers)</th>
                                        <th title="To be Accommodated (Families)">To Accom (Fam)</th>
                                        <th title="To be Accommodated (Persons)">To Accom (Pers)</th>
                                        <th title="Not Accommodated (Families)">Not Accom (Fam)</th>
                                        <th title="Not Accommodated (Persons)">Not Accom (Pers)</th>
                                        <th title="Plan B - Center Name">Plan B - Center</th>
                                        <th title="Plan B - Center Address">Plan B - Address</th>
                                        <th title="Plan B - Capacity (Families)">Plan B Cap (Fam)</th>
                                        <th title="Plan B - Capacity (Persons)">Plan B Cap (Pers)</th>
                                        <th title="Not Accommodated (Plan A & B) (Families)">Not Accom AB (Fam)</th>
                                        <th title="Not Accommodated (Plan A & B) (Persons)">Not Accom AB (Pers)</th>
                                        <th title="Remarks">Remarks</th>
                                        <th title="Action">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($rows)) {
                                        foreach ($rows as $row) {
                                            echo "<tr>";
                                            echo "<td class='purok-name'>" . htmlspecialchars($row["purok_name"]) . "</td>";
                                            echo "<td>" . number_format($row["total_pop_families"]) . "</td>";
                                            echo "<td>" . number_format($row["total_pop_persons"]) . "</td>";
                                            echo "<td>" . number_format($row["risk_pop_families"]) . "</td>";
                                            echo "<td>" . number_format($row["risk_pop_persons"]) . "</td>";
                                            echo "<td title='$row[plan_a_center_name]'>" . htmlspecialchars($row["plan_a_center_name"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_a_center_address"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_a_capacity_families"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_a_capacity_persons"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["to_be_accommodated_families"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["to_be_accommodated_persons"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["not_accommodated_families"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["not_accommodated_persons"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_b_center_name"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_b_center_address"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_b_capacity_families"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["plan_b_capacity_persons"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["not_accom_plan_ab_families"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["not_accom_plan_ab_persons"]) . "</td>";
                                            echo "<td>" . htmlspecialchars($row["remarks"]) . "</td>";
                                            echo "<td>";
                                            echo "<button class='btn-edit' onclick='editEvacuationPlan(" . $row["purok_id"] . ")'>";
                                            echo "<i class='fas fa-edit me-1'></i>Edit";
                                            echo "</button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='21' class='text-center'>No evacuation plan data available</td></tr>";
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