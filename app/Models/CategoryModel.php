<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';

    public function __construct()
    {
        parent::__construct();
        $this->ensureSchemaIntegrity();
    }

    public function ensureSchemaIntegrity(): void
    {
        static $done = false;
        if ($done) return;
        $done = true;

        try {
            $db = \Config\Database::connect();
            if (!$db->tableExists('categories')) return;

            $requiredColumns = [
                'home_showcase' => "TINYINT(1) DEFAULT 0",
                'hot_category'  => "VARCHAR(10) DEFAULT '0'",
                'featured'      => "INT(11) DEFAULT 0",
                'cover_image'   => "VARCHAR(100) NULL DEFAULT NULL"
            ];

            foreach ($requiredColumns as $column => $definition) {
                if (!$db->fieldExists($column, 'categories')) {
                    $db->query("ALTER TABLE `categories` ADD COLUMN `{$column}` {$definition}");
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'CategoryModel schema auto-repair notice: ' . $e->getMessage());
        }
    }

    public function getAllDescendantIds(int $categoryId): array
    {
        $db = \Config\Database::connect();
        $ids = [];
        $children = $db->table('categories')->select('id')->where('parent_id', $categoryId)->get()->getResultArray();
        foreach ($children as $child) {
            $ids[] = (int)$child['id'];
            $ids = array_merge($ids, $this->getAllDescendantIds((int)$child['id']));
        }
        return $ids;
    }

    public function getAllSubcategoriesRecursive(int $categoryId): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories c');
        $builder->select('c.*, u.file_name as icon_img');
        $builder->join('uploads u', 'c.icon = u.id', 'left');
        $builder->where('c.parent_id', $categoryId);
        $builder->orderBy('c.order_level', 'DESC');
        $children = $builder->get()->getResultArray();

        $allSubs = [];
        foreach ($children as $child) {
            $allSubs[] = $child;
            $grandChildren = $this->getAllSubcategoriesRecursive((int)$child['id']);
            if (!empty($grandChildren)) {
                $allSubs = array_merge($allSubs, $grandChildren);
            }
        }
        return $allSubs;
    }

    public function getMainCategories(int $limit = 50): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories c');
        $builder->select('c.*, u.file_name as icon_img, ub.file_name as banner_img');
        $builder->join('uploads u', 'c.icon = u.id', 'left');
        $builder->join('uploads ub', 'c.banner = ub.id', 'left');
        $builder->where('c.parent_id', 0);
        $builder->orderBy('c.order_level', 'DESC');
        $builder->limit($limit);
        
        $categories = $builder->get()->getResultArray();

        foreach ($categories as &$cat) {
            $cat['subcategories'] = $this->getAllSubcategoriesRecursive((int)$cat['id']);

            $descendantIds = $this->getAllDescendantIds((int)$cat['id']);
            $catIds = array_merge([(int)$cat['id']], $descendantIds);

            $cat['product_count'] = $db->table('products')
                                       ->whereIn('category_id', $catIds)
                                       ->where('published', 1)
                                       ->countAllResults();
        }

        return $categories;
    }

    public function getFeaturedCategories(int $limit = 8): array
    {
        $this->ensureSchemaIntegrity();
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('c.*, u.file_name as banner_img');
            $builder->join('uploads u', 'c.banner = u.id', 'left');
            $builder->where('c.featured', 1);
            $builder->limit($limit);

            return $builder->get()->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function getHotCategories(int $limit = 8): array
    {
        $this->ensureSchemaIntegrity();
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('c.*, u.file_name as banner_img, u2.file_name as icon_img');
            $builder->join('uploads u', 'c.banner = u.id', 'left');
            $builder->join('uploads u2', 'c.icon = u2.id', 'left');
            $builder->where('c.hot_category', '1');
            $builder->limit($limit);

            return $builder->get()->getResultArray();
        } catch (\Throwable $e) {
            return [];
        }
    }

    public function getHomeShowcaseCategories(int $limit = 6): array
    {
        $this->ensureSchemaIntegrity();
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('categories c');
            $builder->select('c.*, u.file_name as banner_img, u2.file_name as icon_img, u3.file_name as cover_img');
            $builder->join('uploads u', 'c.banner = u.id', 'left');
            $builder->join('uploads u2', 'c.icon = u2.id', 'left');
            $builder->join('uploads u3', 'c.cover_image = u3.id', 'left');
            $builder->where('c.home_showcase', 1);
            $builder->limit($limit);

            $categories = $builder->get()->getResultArray();

            if (empty($categories)) {
                return [];
            }

            $result = [];
            foreach ($categories as $cat) {
                $descendantIds = $this->getAllDescendantIds((int)$cat['id']);
                $catIds = array_merge([(int)$cat['id']], $descendantIds);

                $prodBuilder = $db->table('products p');
                $prodBuilder->select('p.*, COALESCE(u.file_name, p.thumbnail_img) as thumbnail_img');
                $prodBuilder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
                $prodBuilder->where('p.published', 1);
                $prodBuilder->whereIn('p.category_id', $catIds);
                $prodBuilder->orderBy('p.id', 'DESC');
                $prodBuilder->limit(10);
                $cat['products'] = $prodBuilder->get()->getResultArray();

                // Only include if category has at least 1 product
                if (!empty($cat['products'])) {
                    $result[] = $cat;
                }
            }

            return $result;
        } catch (\Throwable $e) {
            log_message('error', 'getHomeShowcaseCategories error: ' . $e->getMessage());
            return [];
        }
    }
}
