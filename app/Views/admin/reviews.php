<?= $this->extend('admin/layouts/app') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <!-- Header & Action Bar -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Product Ratings & Reviews</h3>
            <p class="text-muted small mb-0">Manage customer feedback, testimonials, and add custom product reviews.</p>
        </div>
        <div>
            <button class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 shadow-sm fw-medium" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                <i class="bi bi-plus-lg fs-6"></i>
                <span>Add New Custom Review</span>
            </button>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <div><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5 text-danger"></i>
            <div><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Overview Stats -->
    <?php 
        $totalReviews = count($reviews ?? []);
        $totalStars = 0;
        $fiveStarCount = 0;
        $customCount = 0;

        foreach ($reviews ?? [] as $r) {
            $ratingVal = (int)($r['rating'] ?? 5);
            $totalStars += $ratingVal;
            if ($ratingVal == 5) $fiveStarCount++;
            if (($r['user_id'] ?? 0) == 0) $customCount++;
        }
        $avgRating = $totalReviews > 0 ? number_format($totalStars / $totalReviews, 1) : '5.0';
    ?>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-chat-square-quote fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Reviews</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $totalReviews ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-warning-subtle text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-star-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Average Rating</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $avgRating ?> <span class="fs-6 text-muted font-normal">/ 5</span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-hand-thumbs-up-fill fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">5-Star Reviews</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $fiveStarCount ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 p-3 bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-person-badge fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Custom Reviews</div>
                        <div class="fs-4 fw-bold text-dark mb-0"><?= $customCount ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <h5 class="fw-bold text-dark mb-0">Reviews List</h5>
            <div class="d-flex align-items-center gap-2">
                <div class="position-relative" style="max-width: 260px; width: 100%;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="reviewSearch" class="form-control ps-5 rounded-pill bg-light border-0 py-2 fs-6" placeholder="Search product or reviewer...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="reviewsTable">
                <thead class="bg-light border-top border-bottom text-secondary">
                    <tr>
                        <th class="ps-4 py-3 text-uppercase fs-7 fw-semibold" style="width: 60px;">#</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold" style="min-width: 220px;">Product Name</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold">Reviewer</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold text-center" style="width: 140px;">Rating</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold" style="min-width: 250px;">Review Comment</th>
                        <th class="py-3 text-uppercase fs-7 fw-semibold text-center" style="width: 110px;">Type</th>
                        <th class="pe-4 py-3 text-uppercase fs-7 fw-semibold text-end" style="width: 90px;">Action</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    <?php if (!empty($reviews)): ?>
                        <?php foreach ($reviews as $index => $item): ?>
                            <tr>
                                <td class="ps-4 fw-medium text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-2 bg-primary-subtle text-primary p-2 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px;">
                                            <i class="bi bi-box-seam"></i>
                                        </div>
                                        <span class="fw-semibold text-dark"><?= esc($item['product_name'] ?? 'General Store Review') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-medium text-dark"><?= esc(!empty($item['user_name']) ? $item['user_name'] : 'Customer Reviewer') ?></span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center gap-1 text-warning">
                                        <?php $rCount = (int)($item['rating'] ?? 5); ?>
                                        <?php for ($s = 1; $s <= 5; $s++): ?>
                                            <i class="bi bi-star-<?= $s <= $rCount ? 'fill' : 'star' ?> fs-6"></i>
                                        <?php endfor; ?>
                                        <span class="ms-1 fw-bold text-dark small">(<?= $rCount ?>)</span>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-muted small mb-0 text-truncate" style="max-width: 320px;" title="<?= esc($item['comment'] ?? '') ?>">
                                        <?= !empty($item['comment']) ? esc($item['comment']) : '<em class="opacity-50">No text comment provided</em>' ?>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <?php if (($item['user_id'] ?? 0) == 0): ?>
                                        <span class="badge rounded-pill bg-info-subtle text-info px-3 py-1 fw-medium">Custom</span>
                                    <?php else: ?>
                                        <span class="badge rounded-pill bg-success-subtle text-success px-3 py-1 fw-medium">Verified User</span>
                                    <?php endif; ?>
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="<?= base_url('admin/product-reviews/delete/' . $item['id']) ?>" 
                                       class="btn btn-sm btn-icon btn-light rounded-circle"
                                       onclick="return confirm('Are you sure you want to delete this product review?');"
                                       title="Delete Review">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-chat-square-star fs-1 text-muted opacity-50 d-block mb-2"></i>
                                    <h6 class="text-secondary fw-semibold">No Product Reviews Found</h6>
                                    <p class="text-muted small mb-3">Add your first custom review or wait for customers to post feedback.</p>
                                    <button class="btn btn-sm btn-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                                        Add Custom Review
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add New Custom Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold text-dark">Add New Custom Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('admin/product-reviews/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Select Product <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select rounded-3 py-2" required>
                            <option value="">-- Choose Target Product --</option>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $prod): ?>
                                    <option value="<?= $prod['id'] ?>"><?= esc($prod['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Reviewer Name</label>
                        <input type="text" name="reviewer_name" class="form-control rounded-3 py-2" placeholder="e.g. Tanvir Ahmed (Optional)">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Rating Star <span class="text-danger">*</span></label>
                        <select name="rating" class="form-select rounded-3 py-2" required>
                            <option value="5" selected>⭐⭐⭐⭐⭐ (5 / 5 - Excellent)</option>
                            <option value="4">⭐⭐⭐⭐ (4 / 5 - Very Good)</option>
                            <option value="3">⭐⭐⭐ (3 / 5 - Average)</option>
                            <option value="2">⭐⭐ (2 / 5 - Below Average)</option>
                            <option value="1">⭐ (1 / 5 - Poor)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-dark">Review Comment / Feedback</label>
                        <textarea name="comment" class="form-control rounded-3" rows="3" placeholder="Write customer feedback or review comment..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-medium" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-medium">Publish Review</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Live Search
    const searchInput = document.getElementById('reviewSearch');
    const tableRows = document.querySelectorAll('#reviewsTable tbody tr');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
