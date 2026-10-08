<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AizUploader extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        return '
        <div class="modal fade" id="aizUploaderModal" data-backdrop="static" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content h-100">
                    <div class="modal-header border-bottom p-3">
                        <h5 class="modal-title font-weight-bold">Select File</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3" style="max-height: 70vh; overflow-y: auto;">
                        <div class="aiz-uploader-all">
                            <div class="px-2 pb-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <div class="input-group input-group-sm mb-2 mb-md-0" style="max-width: 300px;">
                                    <input type="text" class="form-control" id="aiz-uploader-search" placeholder="Search files...">
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <select class="form-control form-control-sm aiz-selectpicker" name="aiz-uploader-sort">
                                        <option value="newest">Sort by newest</option>
                                        <option value="oldest">Sort by oldest</option>
                                        <option value="smallest">Sort by smallest</option>
                                        <option value="largest">Sort by largest</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-3">
                                <div class="aiz-uploader-selecte-file-list row gutters-5 my-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between border-top p-3">
                        <div class="text-muted fs-12 font-weight-bold">
                            <span class="aiz-uploader-selected">0</span> File Selected
                        </div>
                        <div>
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-sm font-weight-bold" data-toggle="aizUploaderAddSelected">Add Files</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    public function getUploadedFiles()
    {
        $search = $this->request->getGet('search') ?? $this->request->getPost('search');
        $sort = $this->request->getGet('sort') ?? $this->request->getPost('sort');
        $type = $this->request->getGet('type') ?? $this->request->getPost('type');

        $builder = $this->db->table('uploads');

        if (!empty($search)) {
            $builder->like('file_original_name', $search);
        }

        if (!empty($type) && $type !== 'all') {
            $builder->where('type', $type);
        }

        if ($sort === 'oldest') {
            $builder->orderBy('id', 'ASC');
        } elseif ($sort === 'smallest') {
            $builder->orderBy('file_size', 'ASC');
        } elseif ($sort === 'largest') {
            $builder->orderBy('file_size', 'DESC');
        } else {
            $builder->orderBy('id', 'DESC');
        }

        $files = $builder->get()->getResultArray();

        $formattedFiles = [];
        foreach ($files as $f) {
            $formattedFiles[] = [
                'id'                 => (int)$f['id'],
                'file_original_name' => $f['file_original_name'] ?? 'File',
                'file_name'          => $f['file_name'],
                'file_size'          => (int)($f['file_size'] ?? 0),
                'extension'          => $f['extension'] ?? 'jpg',
                'type'               => $f['type'] ?? 'image',
                'created_at'         => $f['created_at'] ?? ''
            ];
        }

        return $this->response->setJSON([
            'data'  => $formattedFiles,
            'links' => ['next' => null, 'prev' => null],
            'meta'  => ['current_page' => 1, 'last_page' => 1]
        ]);
    }

    public function getFileByIds()
    {
        $ids = $this->request->getPost('ids');
        if (empty($ids)) {
            return $this->response->setJSON([]);
        }

        if (is_string($ids)) {
            $idArray = array_map('intval', explode(',', $ids));
        } else {
            $idArray = array_map('intval', (array)$ids);
        }

        $idArray = array_filter($idArray);
        if (empty($idArray)) {
            return $this->response->setJSON([]);
        }

        $files = $this->db->table('uploads')->whereIn('id', $idArray)->get()->getResultArray();

        $formatted = [];
        foreach ($files as $f) {
            $formatted[] = [
                'id'                 => (int)$f['id'],
                'file_original_name' => $f['file_original_name'] ?? 'File',
                'file_name'          => $f['file_name'],
                'file_size'          => (int)($f['file_size'] ?? 0),
                'extension'          => $f['extension'] ?? 'jpg',
                'type'               => $f['type'] ?? 'image'
            ];
        }

        return $this->response->setJSON($formatted);
    }
}
