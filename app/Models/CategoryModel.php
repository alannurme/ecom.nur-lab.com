<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';

    public function getMainCategories(int $limit = 12): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories c');
        $builder->select('c.*, u.file_name as icon_img');
        $builder->join('uploads u', 'c.icon = u.id', 'left');
        $builder->where('c.parent_id', 0);
        $builder->orderBy('c.order_level', 'DESC');
        $builder->limit($limit);
        
        return $builder->get()->getResultArray();
    }

    public function getFeaturedCategories(int $limit = 8): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('categories c');
        $builder->select('c.*, u.file_name as banner_img');
        $builder->join('uploads u', 'c.banner = u.id', 'left');
        $builder->where('c.featured', 1);
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }
}
