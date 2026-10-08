<?= view('admin/layouts/header', [
    'page_title' => $page_title ?? '',
    'site_name'  => $site_name ?? ''
]) ?>

<?= $this->renderSection('content') ?>

<?= view('admin/layouts/footer') ?>
