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

    .table-container h5 {
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
        font-size: 0.8rem;
    }

    .demographic-table tbody td:last-child {
        border-right: none;
    }

    .demographic-table tbody tr:last-child td {
        border-bottom: none;
    }

    .demographic-table tbody tr:nth-child(even) {
        background-color: var(--light-pink);
    }

    .total-row {
        background-color: var(--total-row-bg) !important;
        font-weight: 800 !important;
        color: var(--primary-purple) !important;
    }

    .total-row td {
        color: var(--primary-purple) !important;
        font-weight: 800 !important;
    }

    .purok-name {
        text-align: left !important;
        padding-left: 1rem !important;
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

    .stat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .stat-item:last-child {
        border-bottom: none;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .stat-value {
        font-weight: 700;
        color: var(--text-main);
        font-size: 1rem;
    }

    .export-btn,
    .action-btn {
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

    .export-btn:hover,
    .action-btn:hover {
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

    .text-purple {
        color: var(--primary-purple) !important;
    }

    /* Responsive Table Adjustments */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }

        .main-container {
            padding: 1rem;
        }

        .table-container {
            padding: 1rem;
        }

        .demographic-table {
            font-size: 0.75rem;
        }

        .demographic-table th, .demographic-table td { 
            padding: 0.6rem 0.5rem; 
        }

        .btn-view, .btn-edit {
            padding: 0.25rem 0.5rem !important;
            font-size: 0.75rem !important;
        }
    }
    
    /* Custom CSS for navigation */
    .dropdown-item.active {
        background-color: #8b5cf6 !important;
        color: white !important;
        font-weight: bold;
    }

    .dropdown-item.active:hover {
        background-color: #6b21a8 !important;
        color: white !important;
    }

    /* Ensure dropdown menu is clickable and properly positioned */
    .dropdown-menu {
        z-index: 1050 !important;
        pointer-events: auto !important;
    }

    .dropdown-toggle {
        cursor: pointer !important;
    }

    .dropdown-item {
        cursor: pointer !important;
    }

    /* Prevent any overlay from blocking dropdown */
    .navbar-nav .dropdown {
        position: relative;
    }
</style>

<?php if ($is_logged_in): ?>
    <div class="main-container main-content-protected">
        <div class="mobile-header">
            <h1 class="mobile-title">
                <i class="fas fa-users"></i>Purok Demographics
            </h1>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success_message'];
                                                        unset($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo $_SESSION['error_message'];
                                                                unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-purple"></i>
                            Demographic Data by Purok
                        </h5>
                        <button class="export-btn" onclick="exportTable()">
                            <i class="fas fa-download me-1"></i>Export
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="demographic-table shadow-sm" id="demographicTable">
                        <thead>
                            <tr>
                                <th class="text-start ps-4">PUROK</th>
                                <th class="action-column">ACTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($demographic_data)) {
                                foreach ($demographic_data as $row) {
                                    echo "<tr>";
                                    echo "<td class='purok-name'>" . htmlspecialchars($row['purok_name'] ?? '') . "</td>";
                                    echo "<td class='action-column'>";
                                    echo "<button class='btn-view' style='background: #10b981; border: none; color: white; padding: 0.35rem 0.7rem; border-radius: 6px; font-size: 0.8rem; margin-right: 5px; margin-bottom: 5px;' onclick='viewData(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")'><i class='fas fa-eye me-1'></i>View Details</button>";
                                    if ($is_admin) {
                                        echo "<button class='btn-edit' style='margin-bottom: 5px;' onclick='editData(\"" . htmlspecialchars($row['purok_name'] ?? '') . "\")'>";
                                        echo "<i class='fas fa-edit me-1'></i>Edit";
                                        echo "</button>";
                                    }
                                    echo "</td>";
                                    echo "</tr>";
                                }

                                // Add total row
                                echo "<tr class='total-row'>";
                                echo "<td class='purok-name'>TOTAL (Across all Puroks)</td>";
                                echo "<td class='action-column text-muted small'>Summary Below</td>";
                                echo "</tr>";
                            } else {
                                // Show error message if no data
                                echo "<tr><td colspan='18' class='text-center p-5'>";
                                echo "<div class='alert alert-warning' role='alert'>";
                                echo "<i class='fas fa-exclamation-triangle me-2'></i>";
                                echo isset($error_message) ? htmlspecialchars($error_message) : "No demographic data available.";
                                echo "</div>";
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>

                    <?php if (!empty($demographic_data) && $total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?route=purok-demographics&page=<?php echo $page - 1; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>

                                <?php
                                // Show page numbers
                                $start_page = max(1, $page - 2);
                                $end_page = min($total_pages, $page + 2);

                                if ($start_page > 1) {
                                    echo '<li class="page-item"><a class="page-link" href="?route=purok-demographics&page=1">1</a></li>';
                                    if ($start_page > 2) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                }

                                for ($i = $start_page; $i <= $end_page; $i++) {
                                    $active = $i == $page ? 'active' : '';
                                    echo "<li class='page-item $active'><a class='page-link' href='?route=purok-demographics&page=$i'>$i</a></li>";
                                }

                                if ($end_page < $total_pages) {
                                    if ($end_page < $total_pages - 1) {
                                        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                    }
                                    echo "<li class='page-item'><a class='page-link' href='?route=purok-demographics&page=$total_pages'>$total_pages</a></li>";
                                }
                                ?>

                                <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?route=purok-demographics&page=<?php echo $page + 1; ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="text-center text-muted mt-2">
                                <small>Showing <?php echo count($demographic_data); ?> of <?php echo $total_rows; ?> records (Page <?php echo $page; ?> of <?php echo $total_pages; ?>)</small>
                            </div>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="stats-card">
                    <h5><i class="fas fa-home me-2"></i>Families & Persons</h5>
                    <div class="stat-item">
                        <span class="stat-label">Total Families</span>
                        <span class="stat-value"><?php echo number_format($totals['total_families'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Male</span>
                        <span class="stat-value"><?php echo number_format($totals['total_persons_male'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Female</span>
                        <span class="stat-value"><?php echo number_format($totals['total_persons_female'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Persons</span>
                        <span class="stat-value"><?php echo number_format(($totals['total_persons_male'] ?? 0) + ($totals['total_persons_female'] ?? 0)); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stats-card">
                    <h5><i class="fas fa-child me-2"></i>Age Groups</h5>
                    <div class="stat-item">
                        <span class="stat-label">Infants (M+F)</span>
                        <span class="stat-value"><?php echo number_format(($totals['infant_male'] ?? 0) + ($totals['infant_female'] ?? 0)); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Children (M+F)</span>
                        <span class="stat-value"><?php echo number_format(($totals['children_male'] ?? 0) + ($totals['children_female'] ?? 0)); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Adults (M+F)</span>
                        <span class="stat-value"><?php echo number_format(($totals['adult_male'] ?? 0) + ($totals['adult_female'] ?? 0)); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Elderly (M+F)</span>
                        <span class="stat-value"><?php echo number_format(($totals['elderly_male'] ?? 0) + ($totals['elderly_female'] ?? 0)); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="stats-card">
                    <h5><i class="fas fa-info-circle me-2"></i>Special Categories</h5>
                    <div class="stat-item">
                        <span class="stat-label">PWD (Total)</span>
                        <span class="stat-value"><?php echo number_format(($totals['pwd_male'] ?? 0) + ($totals['pwd_female'] ?? 0)); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">With Sickness (Total)</span>
                        <span class="stat-value"><?php echo number_format(($totals['sickness_male'] ?? 0) + ($totals['sickness_female'] ?? 0)); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Pregnant Women</span>
                        <span class="stat-value"><?php echo number_format($totals['pregnant_women'] ?? 0); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Total Records Found</span>
                        <span class="stat-value"><?php echo number_format($total_rows); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/modals/edit_purok_demographics.php'; ?>
    <?php include __DIR__ . '/modals/view_purok_demographics.php'; ?>

    <script>
        function editData(purokName) {
            // Show loading state or modal immediately
            const modal = new bootstrap.Modal(document.getElementById('editPurokModal'));

            fetch(`/micro-oss/index.php?route=api-get-purok-data&purok_name=${encodeURIComponent(purokName)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = data.data;
                        document.getElementById('edit_purok_name').value = row.purok_name;
                        document.getElementById('display_purok_name').value = row.purok_name;
                        document.getElementById('edit_total_families').value = row.total_families;
                        document.getElementById('edit_total_persons_male').value = row.total_persons_male;
                        document.getElementById('edit_total_persons_female').value = row.total_persons_female;
                        document.getElementById('edit_infant_male').value = row.infant_male;
                        document.getElementById('edit_infant_female').value = row.infant_female;
                        document.getElementById('edit_children_male').value = row.children_male;
                        document.getElementById('edit_children_female').value = row.children_female;
                        document.getElementById('edit_adult_male').value = row.adult_male;
                        document.getElementById('edit_adult_female').value = row.adult_female;
                        document.getElementById('edit_elderly_male').value = row.elderly_male;
                        document.getElementById('edit_elderly_female').value = row.elderly_female;
                        document.getElementById('edit_pwd_male').value = row.pwd_male;
                        document.getElementById('edit_pwd_female').value = row.pwd_female;
                        document.getElementById('edit_sickness_male').value = row.sickness_male;
                        document.getElementById('edit_sickness_female').value = row.sickness_female;
                        document.getElementById('edit_pregnant_women').value = row.pregnant_women;

                        modal.show();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching purok data:', error);
                    alert('An error occurred while fetching data.');
                });
        }

        function viewData(rowData) {
            // Populate the view modal
            document.getElementById('view_purok_name_display').textContent = rowData.purok_name || '';
            document.getElementById('view_total_families').textContent = Number(rowData.total_families || 0).toLocaleString();
            document.getElementById('view_total_persons_male').textContent = Number(rowData.total_persons_male || 0).toLocaleString();
            document.getElementById('view_total_persons_female').textContent = Number(rowData.total_persons_female || 0).toLocaleString();
            document.getElementById('view_infant_male').textContent = Number(rowData.infant_male || 0).toLocaleString();
            document.getElementById('view_infant_female').textContent = Number(rowData.infant_female || 0).toLocaleString();
            document.getElementById('view_children_male').textContent = Number(rowData.children_male || 0).toLocaleString();
            document.getElementById('view_children_female').textContent = Number(rowData.children_female || 0).toLocaleString();
            document.getElementById('view_adult_male').textContent = Number(rowData.adult_male || 0).toLocaleString();
            document.getElementById('view_adult_female').textContent = Number(rowData.adult_female || 0).toLocaleString();
            document.getElementById('view_elderly_male').textContent = Number(rowData.elderly_male || 0).toLocaleString();
            document.getElementById('view_elderly_female').textContent = Number(rowData.elderly_female || 0).toLocaleString();
            document.getElementById('view_pwd_male').textContent = Number(rowData.pwd_male || 0).toLocaleString();
            document.getElementById('view_pwd_female').textContent = Number(rowData.pwd_female || 0).toLocaleString();
            document.getElementById('view_sickness_male').textContent = Number(rowData.sickness_male || 0).toLocaleString();
            document.getElementById('view_sickness_female').textContent = Number(rowData.sickness_female || 0).toLocaleString();
            document.getElementById('view_pregnant_women').textContent = Number(rowData.pregnant_women || 0).toLocaleString();

            const modal = new bootstrap.Modal(document.getElementById('viewPurokModal'));
            modal.show();
        }

        function exportTable() {
            const table = document.getElementById('demographicTable');
            let csv = [];

            // Get headers (exclude Action column)
            const headers = [];
            table.querySelectorAll('thead th').forEach((th, index) => {
                const thText = th.textContent.trim();
                if (thText !== 'ACTION') {
                    headers.push(thText);
                }
            });
            csv.push(headers.join(','));

            // Get data rows (exclude Action column)
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = [];
                tr.querySelectorAll('td').forEach((td, index) => {
                    const headerCount = table.querySelectorAll('thead th').length;
                    if (index < headerCount - 1) { // Exclude Action column
                        row.push(td.textContent.trim().replace(/,/g, ''));
                    }
                });
                csv.push(row.join(','));
            });

            // Create download link
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'purok_demographics_' + new Date().toISOString().split('T')[0] + '.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);
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
                });

                // Don't highlight TOTAL row
                if (!this.classList.contains('total-row')) {
                    this.style.backgroundColor = '#fbbf24';
                }
            });
        });
    </script>
<?php endif; ?>