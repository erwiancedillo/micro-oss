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

    .table-container h5 {
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
        min-width: 1200px;
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
    }

    /* Hide action column for non-admin users */
    <?php if (!$is_admin): ?>.demographic-table th.action-column,
    .demographic-table td.action-column {
        display: none;
    }

    <?php endif; ?>@media (max-width: 480px) {
        .demographic-table {
            min-width: 800px;
        }

        .page-title {
            font-size: 1.2rem;
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

    /* Hide action column for non-admin users */
    <?php if (!$is_admin): ?>.demographic-table th.action-column,
    .demographic-table td.action-column {
        display: none;
    }

    <?php endif; ?>
</style>

<?php if ($is_logged_in): ?>
    <div class="main-container main-content-protected">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-users me-3"></i>Purok Demographics
            </h1>
            <p class="page-subtitle">Detailed Population Statistics by Purok - Barangay Lizada</p>
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

                    <table class="demographic-table shadow-sm" id="demographicTable">
                        <thead>
                            <tr>
                                <th>PUROK</th>
                                <th>FAMILIES</th>
                                <th>MALE</th>
                                <th>FEMALE</th>
                                <th>INF M</th>
                                <th>INF F</th>
                                <th>CHILD M</th>
                                <th>CHILD F</th>
                                <th>ADULT M</th>
                                <th>ADULT F</th>
                                <th>ELDER M</th>
                                <th>ELDER F</th>
                                <th>PWD M</th>
                                <th>PWD F</th>
                                <th>SICK M</th>
                                <th>SICK F</th>
                                <th>PREGNANT</th>
                                <?php if ($is_admin): ?>
                                    <th class="action-column">ACTION</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($demographic_data)) {
                                foreach ($demographic_data as $row) {
                                    echo "<tr>";
                                    echo "<td class='purok-name'>" . htmlspecialchars($row['purok_name'] ?? '') . "</td>";
                                    echo "<td>" . number_format($row['total_families'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['total_persons_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['total_persons_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['infant_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['infant_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['children_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['children_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['adult_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['adult_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['elderly_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['elderly_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['pwd_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['pwd_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['sickness_male'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['sickness_female'] ?? 0) . "</td>";
                                    echo "<td>" . number_format($row['pregnant_women'] ?? 0) . "</td>";
                                    if ($is_admin) {
                                        echo "<td class='action-column'>";
                                        echo "<button class='btn-edit' onclick='editData(\"" . htmlspecialchars($row['purok_name'] ?? '') . "\")'>";
                                        echo "<i class='fas fa-edit me-1'></i>Edit";
                                        echo "</button>";
                                        echo "</td>";
                                    }
                                    echo "</tr>";
                                }

                                // Add total row
                                echo "<tr class='total-row'>";
                                echo "<td class='purok-name'>TOTAL</td>";
                                echo "<td>" . number_format($totals['total_families'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['total_persons_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['total_persons_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['infant_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['infant_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['children_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['children_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['adult_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['adult_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['elderly_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['elderly_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['pwd_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['pwd_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['sickness_male'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['sickness_female'] ?? 0) . "</td>";
                                echo "<td>" . number_format($totals['pregnant_women'] ?? 0) . "</td>";
                                if ($is_admin) {
                                    echo "<td class='action-column'>-</td>";
                                }
                                echo "</tr>";
                            } else {
                                // Show error message if no data
                                $colspan = $is_admin ? 18 : 17; // Number of columns
                                echo "<tr><td colspan='$colspan' class='text-center p-5'>";
                                echo "<div class='alert alert-warning' role='alert'>";
                                echo "<i class='fas fa-exclamation-triangle me-2'></i>";
                                echo isset($error_message) ? htmlspecialchars($error_message) : "No demographic data available.";
                                echo "</div>";
                                echo "</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

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