<?php
// socio.php is now loaded consistently via SocioController
// Variables available: $is_logged_in, $is_admin, $agePopulation, $totals, $ageGroups 
?>

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
    }

    .demographic-table thead th {
        background-color: var(--primary-purple);
        color: white;
        padding: 1rem;
        font-weight: 600;
        text-align: center;
        border: none;
    }

    .demographic-table tbody td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
        border-right: 1px solid #e2e8f0;
        text-align: center;
        color: var(--text-main);
        font-weight: 500;
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

    .demographic-table tbody tr.total-row {
        background-color: var(--total-row-bg) !important;
        font-weight: 800 !important;
        color: var(--primary-purple) !important;
    }

    .demographic-table tbody tr.total-row td {
        color: var(--primary-purple) !important;
        font-weight: 800 !important;
    }

    .age-bracket {
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
        font-size: 0.95rem;
        font-weight: 500;
    }

    .stat-value {
        font-weight: 700;
        color: var(--text-main);
        font-size: 1rem;
    }

    .stat-value.highlight {
        font-weight: 800;
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
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
    }

    .text-purple {
        color: var(--primary-purple) !important;
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.8rem;
        }

        .table-container {
            padding: 1rem;
        }

        .demographic-table {
            font-size: 0.9rem;
        }
    }

    /* Hide action column for non-admin users */
    <?php if (!$is_admin): ?>.demographic-table th.action-column,
    .demographic-table td.action-column {
        display: none;
    }

    <?php endif; ?>
</style>

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php if ($is_logged_in): ?>
    <div class="py-4 px-3">
        <div class="mobile-header">
            <h1 class="mobile-title">
                <i class="fas fa-users"></i>Population Demographics
            </h1>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['flash_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-9">
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">
                            <i class="fas fa-chart-bar me-2 text-purple"></i>
                            Age Bracket Distribution
                        </h4>
                        <?php if ($is_admin): ?>
                            <div>
                                <button class="action-btn me-2" onclick="addAgeBracket()">
                                    <i class="fas fa-plus me-1"></i>Add Bracket
                                </button>
                                <button class="export-btn" onclick="exportTable()">
                                    <i class="fas fa-download me-1"></i>Export
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>

                    <table class="demographic-table shadow-sm" id="demographicTable">
                        <thead>
                            <tr>
                                <th>AGE BRACKET (YEAR)</th>
                                <th>FEMALE</th>
                                <th>MALE</th>
                                <th>TOTAL</th>
                                <?php if ($is_admin): ?>
                                    <th class="action-column">ACTION</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($agePopulation)) {
                                // Track unique age brackets to avoid duplicates
                                $displayed_brackets = array();
                                foreach ($agePopulation as $row) {
                                    $bracket = $row["age_bracket"];

                                    // Skip if this bracket was already displayed
                                    if (in_array($bracket, $displayed_brackets)) {
                                        continue;
                                    }

                                    echo "<tr>";
                                    echo "<td class='age-bracket'>" . htmlspecialchars($bracket) . "</td>";
                                    echo "<td>" . number_format($row["female"]) . "</td>";
                                    echo "<td>" . number_format($row["male"]) . "</td>";
                                    echo "<td><strong>" . number_format($row["total"]) . "</strong></td>";
                                    if ($is_admin) {
                                        echo "<td class='action-column'>";
                                        echo "<button class='btn-edit' onclick='editPopulationData(\"" . htmlspecialchars($bracket) . "\", " . $row["female"] . ", " . $row["male"] . ")'>";
                                        echo "<i class='fas fa-edit me-1'></i>Edit";
                                        echo "</button>";
                                        echo "</td>";
                                    }
                                    echo "</tr>";

                                    // Mark this bracket as displayed
                                    $displayed_brackets[] = $bracket;
                                }

                                // Add only one total row at the end
                                echo "<tr class='total-row'>";
                                echo "<td class='age-bracket'>TOTAL</td>";
                                echo "<td>" . number_format($totals["total_female"]) . "</td>";
                                echo "<td>" . number_format($totals["total_male"]) . "</td>";
                                echo "<td>" . number_format($totals["total_population"]) . "</td>";
                                if ($is_admin) {
                                    echo "<td class='action-column'>-</td>";
                                }
                                echo "</tr>";
                            } else {
                                $colspan = $is_admin ? 5 : 4;
                                echo "<tr><td colspan='$colspan' class='text-center'>No data available</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="stats-card">
                    <h5><i class="fas fa-chart-pie me-2"></i>Population Statistics</h5>
                    <div class="stat-item">
                        <span class="stat-label">Total Population</span>
                        <span class="stat-value highlight text-purple"><?php echo number_format($totals["total_population"]); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Female Population</span>
                        <span class="stat-value"><?php echo number_format($totals["total_female"]); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Male Population</span>
                        <span class="stat-value"><?php echo number_format($totals["total_male"]); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Gender Ratio</span>
                        <span class="stat-value"><?php
                                                    $ratio = $totals["total_male"] > 0 ? round(($totals["total_female"] / $totals["total_male"]) * 100, 1) : 0;
                                                    echo $ratio . ":100";
                                                    ?></span>
                    </div>
                </div>

                <div class="stats-card">
                    <h5><i class="fas fa-child me-2"></i>Age Groups</h5>
                    <div class="stat-item">
                        <span class="stat-label">0-14 years</span>
                        <span class="stat-value"><?php echo isset($ageGroups["youth_0_14"]) ? number_format($ageGroups["youth_0_14"]) : 0; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">15-64 years</span>
                        <span class="stat-value highlight text-purple"><?php echo isset($ageGroups["adults_15_64"]) ? number_format($ageGroups["adults_15_64"]) : 0; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">65+ years</span>
                        <span class="stat-value"><?php echo isset($ageGroups["elderly_65_plus"]) ? number_format($ageGroups["elderly_65_plus"]) : 0; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Dependency Ratio</span>
                        <span class="stat-value"><?php
                                                    $working_age = isset($ageGroups["adults_15_64"]) ? $ageGroups["adults_15_64"] : 0;
                                                    $dependents = (isset($ageGroups["youth_0_14"]) ? $ageGroups["youth_0_14"] : 0) + (isset($ageGroups["elderly_65_plus"]) ? $ageGroups["elderly_65_plus"] : 0);
                                                    $dependency_ratio = $working_age > 0 ? round(($dependents / $working_age) * 100, 1) : 0;
                                                    echo $dependency_ratio . "%";
                                                    ?></span>
                    </div>
                </div>

                <div class="stats-card">
                    <h5><i class="fas fa-info-circle me-2"></i>Data Information</h5>
                    <div class="stat-item">
                        <span class="stat-label">Last Updated</span>
                        <span class="stat-value">Dec 2024</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Data Source</span>
                        <span class="stat-value highlight">Barangay Survey</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Coverage</span>
                        <span class="stat-value highlight">100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addAgeBracket() {
            const modal = new bootstrap.Modal(document.getElementById('addAgeBracketModal'));
            modal.show();
        }

        function exportTable() {
            const table = document.getElementById('demographicTable');
            let csv = [];

            // Get headers (exclude Action column)
            const headers = [];
            table.querySelectorAll('thead th').forEach((th, index) => {
                if (index < 4) { // Only include first 4 columns, exclude Action
                    // Escape quotes and wrap in quotes
                    headers.push('"' + th.textContent.trim().replace(/"/g, '""') + '"');
                }
            });
            csv.push(headers.join(','));

            // Get data rows (exclude Action column)
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = [];
                tr.querySelectorAll('td').forEach((td, index) => {
                    if (index < 4) { // Only include first 4 columns, exclude Action
                        // Escape quotes and wrap in quotes
                        row.push('"' + td.textContent.trim().replace(/"/g, '""') + '"');
                    }
                });
                csv.push(row.join(','));
            });

            // Create download link with BOM for Excel character encoding support
            const csvContent = '\uFEFF' + csv.join('\n');
            const blob = new Blob([csvContent], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'population_demographics_' + new Date().toISOString().split('T')[0] + '.csv';
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
<?php include __DIR__ . '/modals/add_age_bracket.php'; ?>
<?php include __DIR__ . '/modals/edit_socio.php'; ?>