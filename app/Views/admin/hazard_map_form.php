<div class="container-fluid px-4">
    <h1 class="mt-4"><?= $title ?></h1>
    
    <?php if (isset($error) && $error): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <form action="index.php?route=<?= isset($map) ? 'admin-hazard-map-edit&id=' . $map['id'] : 'admin-hazard-map-create' ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name (e.g., Barangay Name)</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= isset($map) ? htmlspecialchars($map['name']) : '' ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="image" class="form-label">Map Image</label>
                        <input type="file" class="form-control" id="image" name="image" <?= isset($map) ? '' : 'required' ?>>
                        <?php if (isset($map)): ?>
                            <input type="hidden" name="existing_image" value="<?= htmlspecialchars($map['image_url']) ?>">
                            <div class="mt-2">
                                <small>Current Image: <?= htmlspecialchars($map['image_url']) ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= isset($map) ? htmlspecialchars($map['description']) : '' ?></textarea>
                </div>


                <div class="d-flex justify-content-end gap-2">
                    <a href="index.php?route=admin-hazard-maps" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Hazard Map</button>
                </div>
            </form>
        </div>
    </div>
</div>

