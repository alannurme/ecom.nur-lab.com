<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<section class="mb-4">
    <div class="row gutters-10">
        <!-- Products Grid & Search Filter -->
        <div class="col-md">
            <div class="row gutters-10 mb-3">
                <div class="col-md-6 mb-2 mb-md-0">
                    <div class="form-group mb-0">
                        <input class="form-control form-control-lg bg-white border" type="text" id="pos-search" placeholder="Search by Product Name/Barcode" onkeyup="filterPosProducts()">
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <select id="pos-category" class="form-control form-control-lg bg-white border" onchange="filterPosProducts()">
                        <option value="">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= esc($cat['id']) ?>"><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-3 col-6">
                    <select id="pos-brand" class="form-control form-control-lg bg-white border" onchange="filterPosProducts()">
                        <option value="">All Brands</option>
                        <?php if (!empty($brands)): ?>
                            <?php foreach ($brands as $b): ?>
                                <option value="<?= esc($b['id']) ?>"><?= esc($b['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <!-- Product Cards List -->
            <div class="aiz-pos-product-list c-scrollbar-light overflow-auto p-2 bg-white border rounded" style="max-height: 600px;">
                <div class="row gutters-10" id="pos-product-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-6 mb-3 pos-item" data-name="<?= strtolower(esc($product['name'])) ?>" data-category="<?= esc($product['category_id'] ?? '') ?>">
                                <div class="card h-100 mb-0 shadow-none border position-relative hov-shadow-out c-pointer" onclick="addToPosCart(<?= esc(json_encode($product)) ?>)">
                                    <div class="card-body p-2 text-center">
                                        <div class="img-container position-relative overflow-hidden mb-2" style="height: 120px;">
                                            <img class="img-fit h-100 mw-100 mx-auto" 
                                                 src="<?= !empty($product['thumbnail_path']) ? base_url($product['thumbnail_path']) : base_url('assets/img/placeholder.jpg') ?>" 
                                                 alt="<?= esc($product['name']) ?>"
                                                 onerror="this.src='<?= base_url('assets/img/placeholder.jpg') ?>'">
                                        </div>
                                        <h4 class="fs-13 fw-600 text-dark text-truncate-2 mb-1" style="height: 36px; overflow: hidden;"><?= esc($product['name']) ?></h4>
                                        <div class="fs-14 fw-700 text-primary">৳<?= number_format($product['unit_price'], 2) ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5 text-muted">No products available.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- POS Cart Panel -->
        <div class="col-md-auto w-md-350px w-lg-400px w-xl-450px">
            <div class="card mb-3 border">
                <div class="card-body">
                    <div class="d-flex border-bottom pb-3 mb-3">
                        <div class="flex-grow-1">
                            <select id="pos-customer" class="form-control border">
                                <option value="">Walk In Customer</option>
                                <?php if (!empty($customers)): ?>
                                    <?php foreach ($customers as $c): ?>
                                        <option value="<?= esc($c['id']) ?>"><?= esc($c['name']) ?> (<?= esc($c['phone'] ?? $c['email']) ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <!-- Cart Item List -->
                    <div id="pos-cart-list" class="aiz-pos-cart-list mb-4 c-scrollbar-light overflow-auto" style="max-height: 300px;">
                        <div class="text-center py-5 text-muted" id="empty-cart-msg">
                            <i class="las la-shopping-basket la-3x opacity-50 mb-2"></i>
                            <p class="mb-0">No products added yet</p>
                        </div>
                        <ul class="list-group list-group-flush d-none" id="cart-items-ul">
                        </ul>
                    </div>

                    <!-- Summary calculation -->
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between fw-600 mb-2 text-dark fs-13">
                            <span>Sub Total</span>
                            <span id="pos-subtotal">৳0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-600 mb-2 text-dark fs-13">
                            <span>Tax</span>
                            <span id="pos-tax">৳0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-600 mb-2 text-dark fs-13">
                            <span>Shipping</span>
                            <span id="pos-shipping-disp">৳0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-600 mb-2 text-dark fs-13">
                            <span>Discount</span>
                            <span id="pos-discount-disp">৳0.00</span>
                        </div>
                        <div class="d-flex justify-content-between fw-700 fs-18 border-top pt-2 text-primary">
                            <span>Total</span>
                            <span id="pos-grand-total">৳0.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pos-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-outline-secondary font-weight-bold" onclick="resetPosCart()">Reset</button>
                    <button type="button" class="btn btn-primary font-weight-bold px-4 py-2" onclick="processPosOrder()">Place Order</button>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let posCart = [];

function filterPosProducts() {
    let query = $('#pos-search').val().toLowerCase();
    let cat = $('#pos-category').val();
    
    $('.pos-item').each(function() {
        let name = $(this).data('name');
        let itemCat = $(this).data('category');
        
        let matchName = !query || name.includes(query);
        let matchCat = !cat || itemCat == cat;
        
        if (matchName && matchCat) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
}

function addToPosCart(product) {
    let existing = posCart.find(item => item.id === product.id);
    if (existing) {
        existing.qty += 1;
    } else {
        posCart.push({
            id: product.id,
            name: product.name,
            price: parseFloat(product.unit_price),
            qty: 1
        });
    }
    renderPosCart();
}

function updatePosQty(index, qty) {
    qty = parseInt(qty);
    if (qty <= 0) {
        posCart.splice(index, 1);
    } else {
        posCart[index].qty = qty;
    }
    renderPosCart();
}

function removePosItem(index) {
    posCart.splice(index, 1);
    renderPosCart();
}

function renderPosCart() {
    let $ul = $('#cart-items-ul');
    $ul.empty();
    
    if (posCart.length === 0) {
        $('#empty-cart-msg').removeClass('d-none');
        $ul.addClass('d-none');
        $('#pos-subtotal').text('৳0.00');
        $('#pos-grand-total').text('৳0.00');
        return;
    }
    
    $('#empty-cart-msg').addClass('d-none');
    $ul.removeClass('d-none');
    
    let subtotal = 0;
    
    posCart.forEach((item, index) => {
        let itemTotal = item.price * item.qty;
        subtotal += itemTotal;
        
        let html = `
            <li class="list-group-item py-2 px-0 border-bottom">
                <div class="d-flex align-items-center justify-content-between">
                    <div style="max-width: 180px;">
                        <div class="text-truncate fw-600 fs-13">${item.name}</div>
                        <div class="fs-12 text-muted">৳${item.price.toFixed(2)} x ${item.qty}</div>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="number" value="${item.qty}" min="1" class="form-control form-control-sm text-center mr-2" style="width: 50px;" onchange="updatePosQty(${index}, this.value)">
                        <span class="fw-700 fs-13 mr-2">৳${itemTotal.toFixed(2)}</span>
                        <button type="button" class="btn btn-sm btn-icon text-danger" onclick="removePosItem(${index})"><i class="las la-trash"></i></button>
                    </div>
                </div>
            </li>
        `;
        $ul.append(html);
    });
    
    $('#pos-subtotal').text('৳' + subtotal.toFixed(2));
    $('#pos-grand-total').text('৳' + subtotal.toFixed(2));
}

function resetPosCart() {
    posCart = [];
    renderPosCart();
}

function processPosOrder() {
    if (posCart.length === 0) {
        alert('Please add at least one product to the POS cart.');
        return;
    }
    alert('POS Order placed successfully!');
    resetPosCart();
}
</script>

<?= view('admin/layouts/footer') ?>
