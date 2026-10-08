<?= view('admin/layouts/header', ['page_title' => $page_title, 'site_name' => $site_name]) ?>

<div class="row">
    <div class="col-10 col-sm-10 col-lg-10 mx-auto">
        <div class="aiz-titlebar text-left pb-5px">
            <div class="row align-items-center">
                <div class="col-auto">
                    <h1 class="h3 fw-bold">All Rating & Reviews</h1>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="d-flex align-items-center justify-content-between flex-wrap border-bottom border-light px-25px">
                <div class="table-tabs-container">
                    <ul class="nav nav-tabs border-0" id="myTab" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link px-0 pb-15px fs-14 fw-500 active">All Reviews</button>
                        </li>
                    </ul>
                </div>

                <div>
                    <a href="javascript:void(0);" class="position-relative overflow-hidden add-new-btn">
                        <span class="position-relative z-2 pr-15px fs-14 fw-500 text-blue label-text">Add New Custom Review</span>
                        <span class="position-absolute top-0 right-0 h-100 w-40px bg-blue d-flex align-items-center justify-content-end z-1 plus-icon-container m-0 p-0 rounded-pill">
                            <svg id="plus-icon" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12">
                                <path id="Path_45216" data-name="Path 45216" d="M141.874-812.13a.706.706,0,0,1-.515-.21.7.7,0,0,1-.212-.514V-817.4h-4.553a.7.7,0,0,1-.514-.209.694.694,0,0,1-.21-.511.706.706,0,0,1,.21-.515.7.7,0,0,1,.514-.212h4.549v-4.557a.7.7,0,0,1,.209-.514.694.694,0,0,1,.511-.21.7.7,0,0,1,.515.21.7.7,0,0,1,.212.514v4.553h4.557a.7.7,0,0,1,.514.208.694.694,0,0,1,.21.511.706.706,0,0,1-.21.515.7.7,0,0,1-.514.212h-4.553v4.553a.7.7,0,0,1-.209.514A.694.694,0,0,1,141.874-812.13Z" transform="translate(-135.87 824.13)" fill="#fff" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="tab-filter-bar">
                <form id="sort_reviews" action="" method="GET">
                    <div class="card-header row border-0 pb-0 mt-2">
                        <div class="col pl-0 pl-md-3">
                            <div class="input-group mb-0 border border-light px-3 bg-light rounded-1">
                                <div class="input-group-prepend">
                                    <span class="input-group-text border-0 bg-transparent px-0" id="search">
                                        <svg id="Group_38844" data-name="Group 38844" xmlns="http://www.w3.org/2000/svg" width="16.001" height="16" viewBox="0 0 16.001 16">
                                            <path id="Path_3090" data-name="Path 3090" d="M8.248,14.642a6.394,6.394,0,1,1,6.394-6.394A6.4,6.4,0,0,1,8.248,14.642Zm0-11.509a5.115,5.115,0,1,0,5.115,5.115A5.121,5.121,0,0,0,8.248,3.133Z" transform="translate(-1.854 -1.854)" fill="#a5a5b8" />
                                            <path id="Path_3091" data-name="Path 3091" d="M23.011,23.651a.637.637,0,0,1-.452-.187l-4.92-4.92a.639.639,0,0,1,.9-.9l4.92,4.92a.639.639,0,0,1-.452,1.091Z" transform="translate(-7.651 -7.651)" fill="#a5a5b8" />
                                        </svg>
                                    </span>
                                </div>
                                <input type="text" class="form-control form-control-sm border-0 px-2 bg-transparent" id="search_input" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search Reviews ...">
                            </div>
                        </div>

                        <div class="col-md-2 ml-auto mb-1 mb-md-0 px-0 px-md-1">
                            <div class="dropdown w-100">
                                <button class="btn border border-light px-3 w-100 d-flex justify-content-between align-items-center dropdown-toggle" type="button" data-toggle="dropdown">
                                    <span class="text-secondary fs-14 fw-400">Filter By Seller</span>
                                </button>
                                <div class="dropdown-menu py-3 w-100">
                                    <div class="form-check hover-bg-light py-2 d-flex align-items-center px-3">
                                        <input class="input-check" type="checkbox" id="seller_all" checked>
                                        <label class="form-check-label fs-14 px-2 mb-0" for="seller_all">All</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2 ml-auto pr-0 pr-md-3 pl-0 inner-select">
                            <select class="form-control aiz-selectpicker mb-2 mb-md-0 bg-light" name="type">
                                <option value="">Sort by Rating</option>
                                <option value="rating,desc">Rating (High to Low)</option>
                                <option value="rating,asc">Rating (Low to High)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body">
                <table class="table mb-0" id="aiz-data-table">
                    <thead>
                        <tr>
                            <th class="">#</th>
                            <th class="text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Product</th>
                            <th class="hide-xs text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Owner</th>
                            <th class="hide-xs text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Rating</th>
                            <th class="hide-xs text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Reviews</th>
                            <th class="hide-sm text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Custom Reviews</th>
                            <th class="hide-xs text-right text-uppercase fs-10 fs-md-12 fw-700 text-secondary">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($reviews)): ?>
                            <?php foreach ($reviews as $key => $review): ?>
                                <tr class="data-row">
                                    <td class="align-middle h-40">
                                        <div class="form-group d-inline-block mb-0 pr-3">
                                            <?= $key + 1 ?>
                                        </div>
                                    </td>
                                    <td class="align-middle w-500px w-md-500px mw-500 pr-5" data-label="Product Name">
                                        <div class="row gutters-5">
                                            <div class="col">
                                                <span class="fs-14 fw-400 text-dark"><?= esc($review['product_name'] ?? '—') ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle hide-xs" data-label="Owner">
                                        <span class="fs-14 fw-400 text-dark"><?= esc($review['user_name'] ?? 'In House') ?></span>
                                    </td>
                                    <td class="align-middle hide-xs" data-label="Rating">
                                        <span class="fs-14 fw-400 text-dark"><?= esc($review['rating'] ?? 5) ?></span>
                                    </td>
                                    <td class="align-middle hide-xs" data-label="Reviews">
                                        <span class="fs-14 fw-400 text-dark">1</span>
                                    </td>
                                    <td class="hide-sm align-middle" data-label="Custom Reviews">
                                        <span class="fs-14 fw-400 text-dark">0</span>
                                    </td>
                                    <td class="align-middle hide-xs text-right" data-label="Options">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <div class="dropdown float-right">
                                                <button class="btn btn-light w-35px h-35px action-toggle d-flex align-items-center justify-content-center p-0" type="button" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="3" height="16" viewBox="0 0 3 16">
                                                        <g id="Group_38888" data-name="Group 38888" transform="translate(-1653 -342)">
                                                            <circle id="Ellipse_1018" data-name="Ellipse 1018" cx="1.5" cy="1.5" r="1.5" transform="translate(1653 348.5)" />
                                                            <circle id="Ellipse_1019" data-name="Ellipse 1019" cx="1.5" cy="1.5" r="1.5" transform="translate(1653 342)" />
                                                            <circle id="Ellipse_1020" data-name="Ellipse 1020" cx="1.5" cy="1.5" r="1.5" transform="translate(1653 355)" />
                                                        </g>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                                    <div class="table-options">
                                                        <a href="javascript:void(0)" class="d-flex align-items-center px-20px py-10px hov-bg-light hov-text-blue">
                                                            <span class="fs-14 text-danger fw-500">Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No reviews found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if (isset($pager)): ?>
                    <div class="aiz-pagination mt-3">
                        <?= $pager->links('default', 'aiz_pagination') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= view('admin/layouts/footer') ?>
