<?php if ($is_logged_in): ?>
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

        .main-container {
            padding: 2rem;
            color: var(--text-main);
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
            font-weight: 800;
            color: var(--primary-purple);
        }

        .material-type {
            text-align: left !important;
            padding-left: 1.5rem !important;
            font-weight: 500;
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

        .export-btn {
            background: white;
            color: var(--primary-purple);
            border: 1px solid var(--primary-purple);
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .export-btn:hover {
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
    </style>

    <div class="main-container">
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-home me-3"></i>Household Materials Analysis
            </h1>
            <p class="page-subtitle">Construction Materials & Ownership Types - Barangay Lizada</p>
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
            <div class="col-lg-9">
                <!-- Construction Materials Table -->
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">
                            <i class="fas fa-building me-2 text-purple"></i>
                            Number of Households according to the type of Materials used in Construction
                        </h4>
                        <?php if ($is_admin): ?>
                            <button class="export-btn" onclick="exportTable('materialsTable')">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        <?php endif; ?>
                    </div>

                    <table class="demographic-table shadow-sm" id="materialsTable">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Type of Materials Used in Construction</th>
                                <th style="width: 25%;">Number of Households</th>
                                <th style="width: 20%;">Percentage</th>
                                <?php if ($is_admin): ?>
                                    <th style="width: 10%;">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($materials)): ?>
                                <?php foreach ($materials as $row): ?>
                                    <?php
                                    $percentage = $materials_total > 0 ?
                                        round(($row["households"] / $materials_total) * 100, 1) : 0;
                                    ?>
                                    <tr>
                                        <td class='material-type'><?= htmlspecialchars($row["material_name"]) ?></td>
                                        <td><strong><?= number_format((float)$row["households"]) ?></strong></td>
                                        <td><?= $percentage ?>%</td>
                                        <?php if ($is_admin): ?>
                                            <td>
                                                <button class='btn-edit' onclick='editMaterialData("<?= htmlspecialchars($row["material_name"]) ?>", <?= $row["households"] ?>)'>
                                                    <i class='fas fa-edit me-1'></i>Edit
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td class='material-type'>TOTAL</td>
                                    <td><?= number_format((float)$materials_total) ?></td>
                                    <td>100%</td>
                                    <?php if ($is_admin): ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $is_admin ? 4 : 3 ?>" class='text-center'>No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Ownership Types Table -->
                <div class="table-container">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">
                            <i class="fas fa-key me-2 text-purple"></i>
                            Total Households by Type of Ownership
                        </h4>
                        <?php if ($is_admin): ?>
                            <button class="export-btn" onclick="exportTable('ownershipTable')">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                        <?php endif; ?>
                    </div>

                    <table class="demographic-table shadow-sm" id="ownershipTable">
                        <thead>
                            <tr>
                                <th style="width: 45%;">Type of Ownership</th>
                                <th style="width: 25%;">Number of Households</th>
                                <th style="width: 20%;">Percentage</th>
                                <?php if ($is_admin): ?>
                                    <th style="width: 10%;">Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($ownership)): ?>
                                <?php foreach ($ownership as $row): ?>
                                    <?php
                                    $percentage = $ownership_total > 0 ?
                                        round(($row["households"] / $ownership_total) * 100, 1) : 0;
                                    ?>
                                    <tr>
                                        <td class='material-type'><?= htmlspecialchars($row["ownership_type"]) ?></td>
                                        <td><strong><?= number_format((float)$row["households"]) ?></strong></td>
                                        <td><?= $percentage ?>%</td>
                                        <?php if ($is_admin): ?>
                                            <td>
                                                <button class='btn-edit' onclick='editOwnershipData("<?= htmlspecialchars($row["ownership_type"]) ?>", <?= $row["households"] ?>)'>
                                                    <i class='fas fa-edit me-1'></i>Edit
                                                </button>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td class='material-type'>TOTAL</td>
                                    <td><?= number_format((float)$ownership_total) ?></td>
                                    <td>100%</td>
                                    <?php if ($is_admin): ?>
                                        <td>-</td>
                                    <?php endif; ?>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= $is_admin ? 4 : 3 ?>" class='text-center'>No data available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="stats-card">
                    <h5><i class="fas fa-chart-pie me-2"></i>Materials Statistics</h5>
                    <div class="stat-item">
                        <span class="stat-label">Total Households</span>
                        <span class="stat-value"><?= number_format((float)$materials_total) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Material Types</span>
                        <span class="stat-value"><?= count($materials) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Most Common</span>
                        <span class="stat-value highlight text-purple"><?= htmlspecialchars($most_common) ?></span>
                    </div>
                </div>

                <div class="stats-card">
                    <h5><i class="fas fa-home me-2"></i>Ownership Statistics</h5>
                    <div class="stat-item">
                        <span class="stat-label">Total Households</span>
                        <span class="stat-value"><?= number_format((float)$ownership_total) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Ownership Types</span>
                        <span class="stat-value"><?= count($ownership) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Owned Houses</span>
                        <span class="stat-value highlight text-purple"><?= number_format((float)$owned_count) ?></span>
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

    <?php include __DIR__ . '/modals/edit_household_materials.php'; ?>

    <script>
        function editMaterialData(materialType, households) {
            document.getElementById('edit_material_name').value = materialType;
            document.getElementById('display_material_name').value = materialType;
            document.getElementById('edit_material_households').value = households;
            new bootstrap.Modal(document.getElementById('editMaterialModal')).show();
        }

        function editOwnershipData(ownershipType, households) {
            document.getElementById('edit_ownership_type').value = ownershipType;
            document.getElementById('display_ownership_type').value = ownershipType;
            document.getElementById('edit_ownership_households').value = households;
            new bootstrap.Modal(document.getElementById('editOwnershipModal')).show();
        }

        function exportTable(tableId) {
            const table = document.getElementById(tableId);
            let csv = [];

            // Get headers (exclude Action column)
            const headers = [];
            table.querySelectorAll('thead th').forEach((th, index) => {
                if (index < 3) { // Only include first 3 columns, exclude Action
                    headers.push(th.textContent.trim());
                }
            });
            csv.push(headers.join(','));

            // Get data rows (exclude Action column)
            table.querySelectorAll('tbody tr').forEach(tr => {
                const row = [];
                tr.querySelectorAll('td').forEach((td, index) => {
                    if (index < 3) { // Only include first 3 columns, exclude Action
                        row.push(td.textContent.trim().replace(/,/g, ''));
                    }
                });
                if (row.length > 0) {
                    csv.push(row.join(','));
                }
            });

            // Create download link
            const csvContent = csv.join('\n');
            const blob = new Blob([csvContent], {
                type: 'text/csv'
            });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = tableId + '_' + new Date().toISOString().split('T')[0] + '.csv';
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
                if (!this.querySelector('.material-type') || this.querySelector('.material-type').textContent.trim() !== 'TOTAL') {
                    this.style.backgroundColor = '#fbbf24';
                }
            });
        });
    </script>
<?php endif; ?>