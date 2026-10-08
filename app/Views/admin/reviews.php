<?= $this->extend('admin/layouts/app') ?>

<?= $this->section('content') ?>
<style>
    .reviews-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }
    .stat-box {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }
    .custom-table th {
        background-color: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 16px;
    }
    .custom-table td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }
    .modal-style .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        overflow: hidden;
    }
    .modal-style .modal-header {
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 24px;
    }
    .modal-style .modal-title {
        font-weight: 700;
        color: #0f172a;
        font-size: 18px;
    }
    .modal-style .modal-body {
        padding: 24px;
    }
    .modal-style .form-group label {
        font-weight: 600;
        color: #1e293b;
        font-size: 13px;
        margin-bottom: 6px;
    }
    .modal-style .form-control, .modal-style select.form-control {
        width: 100% !important;
        max-width: 100% !important;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        padding: 10px 14px;
        font-size: 14px;
        color: #1e293b;
        box-shadow: none !important;
        background-color: #ffffff;
        transition: border-color 0.15s ease-in-out;
        height: auto;
    }
    .modal-style select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        padding-right: 40px;
    }
    .modal-style .form-control:focus {
        border-color: #3b82f6;
    }
    .modal-style .modal-footer {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 16px 24px;
    }
    .badge-custom {
        background-color: #e0f2fe;
        color: #0284c7;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
    .badge-verified {
        background-color: #dcfce7;
        color: #16a34a;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
    }
</style>

<div class="aiz-titlebar text-left mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3 font-weight-bold text-dark mb-1">Product Ratings & Reviews</h1>
            <p class="text-muted fs-13 mb-0">Manage customer feedback, star ratings, and publish custom reviews.</p>
        </div>
        <div class="col-md-6 text-md-right mt-3 mt-md-0">
            <button class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm rounded-pill d-inline-flex align-items-center" data-toggle="modal" data-target="#addReviewModal" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">
                <i class="las la-plus fs-16 mr-2"></i>
                <span>Add New Custom Review</span>
            </button>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="las la-check-circle fs-20 mr-2"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-lg mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="las la-exclamation-triangle fs-20 mr-2"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
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
<div class="row gutters-10 mb-4">
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-primary text-primary mr-3">
                <i class="las la-comments"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Total Reviews</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $totalReviews ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-warning text-warning mr-3">
                <i class="las la-star"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Average Rating</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $avgRating ?> <span class="fs-12 text-muted font-normal">/ 5.0</span></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3 mb-3 mb-md-0">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-success text-success mr-3">
                <i class="las la-thumbs-up"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">5-Star Reviews</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $fiveStarCount ?></div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-box d-flex align-items-center">
            <div class="stat-icon bg-soft-info text-info mr-3">
                <i class="las la-user-edit"></i>
            </div>
            <div>
                <div class="text-muted fs-12 font-weight-bold uppercase">Custom Reviews</div>
                <div class="fs-22 font-weight-bold text-dark"><?= $customCount ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Table Card -->
<div class="reviews-card">
    <div class="card-header border-bottom border-light py-3 px-4 d-flex align-items-center justify-content-between flex-wrap">
        <h5 class="mb-0 font-weight-bold text-dark fs-16">All Reviews</h5>
        <div class="position-relative mt-2 mt-md-0" style="width: 280px; max-width: 100%;">
            <input type="text" id="reviewSearch" class="form-control form-control-sm rounded-pill pl-4 pr-3 py-2 bg-light border-0 fs-13" placeholder="Search product or reviewer...">
        </div>
    </div>

    <div class="table-responsive">
        <table class="table custom-table mb-0" id="reviewsTable">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 200px;">Product</th>
                    <th>Reviewer</th>
                    <th class="text-center" style="width: 140px;">Rating</th>
                    <th style="min-width: 250px;">Feedback</th>
                    <th class="text-center" style="width: 110px;">Type</th>
                    <th class="text-right" style="width: 80px;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reviews)): ?>
                    <?php foreach ($reviews as $index => $item): ?>
                        <tr>
                            <td class="font-weight-bold text-muted"><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="size-35px bg-soft-primary text-primary rounded d-flex align-items-center justify-content-center mr-2 font-weight-bold">
                                        <i class="las la-box fs-18"></i>
                                    </div>
                                    <span class="font-weight-semibold text-dark fs-14"><?= esc($item['product_name'] ?? 'General Product') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="font-weight-semibold text-dark"><?= esc(!empty($item['user_name']) ? $item['user_name'] : 'Customer Reviewer') ?></span>
                            </td>
                            <td class="text-center">
                                <div class="text-warning fs-14">
                                    <?php $rCount = (int)($item['rating'] ?? 5); ?>
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="<?= $s <= $rCount ? 'las la-star' : 'lar la-star' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="font-weight-bold text-dark ml-1 fs-12">(<?= $rCount ?>)</span>
                                </div>
                            </td>
                            <td>
                                <p class="text-muted fs-13 mb-0 text-truncate" style="max-width: 300px;" title="<?= esc($item['comment'] ?? '') ?>">
                                    <?= !empty($item['comment']) ? esc($item['comment']) : '<em class="opacity-50">No written comment</em>' ?>
                                </p>
                            </td>
                            <td class="text-center">
                                <?php if (($item['user_id'] ?? 0) == 0): ?>
                                    <span class="badge-custom">Custom</span>
                                <?php else: ?>
                                    <span class="badge-verified">Verified</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <a href="<?= base_url('admin/product-reviews/delete/' . $item['id']) ?>" 
                                   class="btn btn-soft-danger btn-icon btn-circle btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this product review?');"
                                   title="Delete Review">
                                    <i class="las la-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="py-4">
                                <i class="las la-comment-slash fs-40 text-muted opacity-50 d-block mb-2"></i>
                                <h6 class="text-secondary font-weight-bold">No Product Reviews Found</h6>
                                <p class="text-muted fs-13 mb-3">Add custom reviews to display customer testimonials.</p>
                                <button class="btn btn-sm btn-primary rounded-pill px-4" data-toggle="modal" data-target="#addReviewModal">
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

<!-- Add New Custom Review Modal -->
<div class="modal fade modal-style" id="addReviewModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Custom Review</h5>
                <button type="button" class="close text-secondary" data-dismiss="modal" aria-label="Close" style="outline: none;">
                    <span aria-hidden="true" style="font-size: 24px;">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/product-reviews/store') ?>" method="POST">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        <label>Select Product <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Choose Target Product --</option>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $prod): ?>
                                    <option value="<?= $prod['id'] ?>"><?= esc($prod['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label>Reviewer Name</label>
                        <input type="text" name="reviewer_name" class="form-control" placeholder="e.g. Tanvir Ahmed (Optional)">
                    </div>

                    <div class="form-group mb-3">
                        <label>Rating Star <span class="text-danger">*</span></label>
                        <select name="rating" class="form-control" required>
                            <option value="5" selected>⭐⭐⭐⭐⭐ (5 / 5 - Excellent)</option>
                            <option value="4">⭐⭐⭐⭐ (4 / 5 - Very Good)</option>
                            <option value="3">⭐⭐⭐ (3 / 5 - Average)</option>
                            <option value="2">⭐⭐ (2 / 5 - Below Average)</option>
                            <option value="1">⭐ (1 / 5 - Poor)</option>
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label>Review Comment / Feedback</label>
                        <textarea name="comment" class="form-control" rows="3" placeholder="Write customer feedback or review comment..."></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 font-weight-bold" style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); border: none;">Publish Review</button>
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
