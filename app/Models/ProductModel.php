<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $allowedFields = [
        'name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider',
        'unit_price', 'purchase_price', 'unit', 'current_stock', 'slug',
        'published', 'approved', 'wholesale_product', 'created_at', 'updated_at'
    ];

    private function baseQuery()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('products p');
        $builder->select('p.*, u.file_name as thumbnail_path, c.name as category_name');
        $builder->join('uploads u', 'p.thumbnail_img = u.id', 'left');
        $builder->join('categories c', 'p.category_id = c.id', 'left');
        $builder->where('p.published', 1);

        return $builder;
    }

    public function getFeaturedProducts(int $limit = 10): array
    {
        $builder = $this->baseQuery();
        $builder->where('p.featured', 1);
        $builder->orderBy('p.id', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    public function getTodaysDeals(int $limit = 10): array
    {
        $builder = $this->baseQuery();
        $builder->where('p.todays_deal', 1);
        $builder->orderBy('p.id', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    public function getLatestProducts(int $limit = 12): array
    {
        $builder = $this->baseQuery();
        $builder->orderBy('p.id', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    public function getProductsByCategory(int $categoryId, int $limit = 6): array
    {
        $builder = $this->baseQuery();
        $builder->where('p.category_id', $categoryId);
        $builder->orderBy('p.id', 'DESC');
        $builder->limit($limit);

        return $builder->get()->getResultArray();
    }

    public function calculateFinalPrice(array $product): float
    {
        $price = (float) $product['unit_price'];
        $discount = (float) $product['discount'];
        
        if ($discount <= 0) {
            return $price;
        }

        if ($product['discount_type'] === 'percent') {
            return $price - ($price * ($discount / 100));
        }

        return max(0, $price - $discount);
    }
}
