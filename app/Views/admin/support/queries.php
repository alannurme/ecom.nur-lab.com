<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Product Queries</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Customer Product Inquiries</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchQueryInput" placeholder="Search product or question...">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button"><i class="las la-search"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table aiz-table mb-0 align-middle">
                    <thead>
                        <tr class="bg-soft-secondary text-secondary">
                            <th width="40">#</th>
                            <th>User Name</th>
                            <th>Product Name</th>
                            <th>Question</th>
                            <th>Reply</th>
                            <th>Status</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="queryTableBody">
                        <?php 
                        $queryList = !empty($queries) ? $queries : [
                            ['id' => 1, 'user' => 'Paul K. Vance', 'product' => 'Wireless Bluetooth Headphones', 'question' => 'Does this headset support active noise cancellation (ANC)?', 'reply' => 'Yes, it features dual-microphone active noise cancellation up to 35dB.', 'status' => 'replied'],
                            ['id' => 2, 'user' => 'Sarah Connor', 'product' => 'Men Cotton Casual T-Shirt', 'question' => 'Will size M fit a 40-inch chest measurement?', 'reply' => null, 'status' => 'not_replied'],
                            ['id' => 3, 'user' => 'Michael Smith', 'product' => 'Smart Fitness Watch Series 7', 'question' => 'Is this watch water resistant during swimming?', 'reply' => 'Yes, it has a 5ATM water resistance rating suitable for pool swimming.', 'status' => 'replied'],
                        ];
                        foreach ($queryList as $index => $q): 
                        ?>
                        <tr class="query-row" id="query_row_<?= $q['id'] ?>" data-search="<?= strtolower(esc(($q['user'] ?? '').' '.($q['product'] ?? '').' '.($q['question'] ?? ''))) ?>">
                            <td><?= $index + 1 ?></td>
                            <td><span class="font-weight-bold text-dark"><?= esc($q['user'] ?? 'N/A') ?></span></td>
                            <td><span class="font-weight-bold text-primary"><?= esc($q['product'] ?? 'N/A') ?></span></td>
                            <td><span class="text-muted fs-13"><?= esc($q['question'] ?? '') ?></span></td>
                            <td>
                                <?php if (!empty($q['reply'])): ?>
                                    <span class="text-dark fs-13"><?= esc($q['reply']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted italic fs-13">-- No reply yet --</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($q['status'] == 'replied'): ?>
                                    <span class="badge badge-inline badge-soft-success">Replied</span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-soft-warning">Not Replied</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn-reply-query" 
                                   data-id="<?= $q['id'] ?>"
                                   data-user="<?= esc($q['user']) ?>"
                                   data-product="<?= esc($q['product']) ?>"
                                   data-question="<?= esc($q['question']) ?>"
                                   data-reply="<?= esc($q['reply'] ?? '') ?>"
                                   href="javascript:void(0);" title="View / Reply">
                                    <i class="las la-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Reply Product Query -->
<div class="modal fade" id="queryReplyModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Product Inquiry Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bg-light p-3 rounded-2 mb-3">
                    <span class="text-muted fs-12 d-block">Product:</span>
                    <strong class="text-primary fs-15 d-block mb-2" id="modal_query_product">Product Title</strong>
                    <span class="text-muted fs-12 d-block">Question by <strong id="modal_query_user">User</strong>:</span>
                    <p class="text-dark fs-14 fw-600 mb-0 mt-1" id="modal_query_question">Question text here...</p>
                </div>
                <div class="form-group mb-0">
                    <label class="col-from-label fs-14 fw-500">Official Reply <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="modal_query_reply_input" rows="4" placeholder="Write answer to customer's product question..."></textarea>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold" id="saveQueryReplyBtn">Save & Send Reply</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchQueryInput');
    const rows = document.querySelectorAll('.query-row');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.trim().toLowerCase();
            rows.forEach(row => {
                const searchStr = row.getAttribute('data-search') || '';
                if (searchStr.includes(q)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    document.querySelectorAll('.btn-reply-query').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const user = this.getAttribute('data-user');
            const product = this.getAttribute('data-product');
            const question = this.getAttribute('data-question');
            const reply = this.getAttribute('data-reply');

            document.getElementById('modal_query_user').innerText = user;
            document.getElementById('modal_query_product').innerText = product;
            document.getElementById('modal_query_question').innerText = question;
            document.getElementById('modal_query_reply_input').value = reply;

            $('#queryReplyModal').modal('show');
        });
    });

    const saveBtn = document.getElementById('saveQueryReplyBtn');
    if (saveBtn) {
        saveBtn.addEventListener('click', function() {
            alert('Product query reply saved successfully!');
            $('#queryReplyModal').modal('hide');
        });
    }
});
</script>

<?= $this->include('admin/layouts/footer') ?>
