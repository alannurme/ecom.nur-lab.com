<?= $this->include('admin/layouts/header') ?>

<div class="aiz-titlebar text-left mt-2 mb-3 px-3 px-md-2rem">
    <h1 class="h3 fw-700">Support Desk Tickets</h1>
</div>

<div class="px-3 px-md-2rem mb-4">
    <div class="card shadow-sm border-0 rounded-2">
        <div class="card-header row gutters-5 border-0 mt-2 align-items-center">
            <div class="col">
                <h5 class="mb-0 h6 font-weight-bold">Customer Support Tickets</h5>
            </div>
            <div class="col-md-3 ml-auto">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" id="searchTicketInput" placeholder="Type ticket ID & hit enter...">
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
                            <th>Ticket ID</th>
                            <th>Sending Date</th>
                            <th>Subject</th>
                            <th>User</th>
                            <th>Status</th>
                            <th>Last Reply</th>
                            <th class="text-right">Options</th>
                        </tr>
                    </thead>
                    <tbody id="ticketTableBody">
                        <?php 
                        $ticketList = !empty($tickets) ? $tickets : [
                            ['id' => 1, 'code' => '984321', 'date' => '2026-10-06 12:45', 'subject' => 'Payment deducted twice during checkout', 'user' => 'Paul K. Vance', 'status' => 'pending', 'new' => 1, 'last_reply' => '2026-10-06 12:45'],
                            ['id' => 2, 'code' => '984322', 'date' => '2026-10-05 15:30', 'subject' => 'Order delivery delay inquiry', 'user' => 'Sarah Connor', 'status' => 'open', 'new' => 0, 'last_reply' => '2026-10-05 17:10'],
                            ['id' => 3, 'code' => '984323', 'date' => '2026-10-02 09:15', 'subject' => 'Product return & refund request', 'user' => 'Michael Smith', 'status' => 'solved', 'new' => 0, 'last_reply' => '2026-10-03 10:00'],
                        ];
                        foreach ($ticketList as $ticket): 
                        ?>
                        <tr class="ticket-row" id="ticket_row_<?= $ticket['id'] ?>" data-search="<?= strtolower(esc($ticket['code'].' '.$ticket['subject'].' '.$ticket['user'])) ?>">
                            <td><span class="font-weight-bold text-primary">#<?= esc($ticket['code']) ?></span></td>
                            <td>
                                <?= esc($ticket['date']) ?>
                                <?php if (($ticket['new'] ?? 0) == 1): ?>
                                    <span class="badge badge-inline badge-soft-info ml-1">New</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="font-weight-bold text-dark fs-14"><?= esc($ticket['subject']) ?></span></td>
                            <td><?= esc($ticket['user']) ?></td>
                            <td>
                                <?php if ($ticket['status'] == 'pending'): ?>
                                    <span class="badge badge-inline badge-soft-danger">Pending</span>
                                <?php elseif ($ticket['status'] == 'open'): ?>
                                    <span class="badge badge-inline badge-soft-warning">Open</span>
                                <?php else: ?>
                                    <span class="badge badge-inline badge-soft-success">Solved</span>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($ticket['last_reply']) ?></td>
                            <td class="text-right">
                                <a class="btn btn-soft-primary btn-icon btn-circle btn-sm btn-view-ticket" 
                                   data-code="<?= esc($ticket['code']) ?>"
                                   data-subject="<?= esc($ticket['subject']) ?>"
                                   data-user="<?= esc($ticket['user']) ?>"
                                   data-status="<?= esc($ticket['status']) ?>"
                                   href="javascript:void(0);" title="View Details">
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

<!-- Modal: View Support Ticket -->
<div class="modal fade" id="ticketDetailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title font-weight-bold">Ticket Details: <span id="modal_ticket_code" class="text-primary">#0000</span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="bg-light p-3 rounded-2 mb-3">
                    <h6 class="font-weight-bold text-dark mb-1" id="modal_ticket_subject">Subject Title</h6>
                    <small class="text-muted">Submitted by: <strong id="modal_ticket_user">User</strong></small>
                </div>
                <div class="form-group mb-3">
                    <label class="col-from-label fs-14 fw-500">Reply Message</label>
                    <textarea class="form-control" rows="4" placeholder="Write reply message to customer..."></textarea>
                </div>
                <div class="form-group mb-0">
                    <label class="col-from-label fs-14 fw-500">Change Ticket Status</label>
                    <select class="form-control" id="modal_ticket_status">
                        <option value="pending">Pending</option>
                        <option value="open">Open</option>
                        <option value="solved">Solved</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-soft-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold">Submit Reply</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchTicketInput');
    const rows = document.querySelectorAll('.ticket-row');

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

    document.querySelectorAll('.btn-view-ticket').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const code = this.getAttribute('data-code');
            const subject = this.getAttribute('data-subject');
            const user = this.getAttribute('data-user');
            const status = this.getAttribute('data-status');

            document.getElementById('modal_ticket_code').innerText = '#' + code;
            document.getElementById('modal_ticket_subject').innerText = subject;
            document.getElementById('modal_ticket_user').innerText = user;
            document.getElementById('modal_ticket_status').value = status;

            $('#ticketDetailModal').modal('show');
        });
    });
});
</script>

<?= $this->include('admin/layouts/footer') ?>
