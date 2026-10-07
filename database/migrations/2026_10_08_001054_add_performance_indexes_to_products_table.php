<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['published', 'approved', 'featured'], 'idx_products_pub_app_feat');
            $table->index(['published', 'approved', 'auction_product', 'added_by'], 'idx_products_pub_app_auc_added');
            $table->index(['published', 'approved', 'category_id'], 'idx_products_pub_app_cat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_pub_app_feat');
            $table->dropIndex('idx_products_pub_app_auc_added');
            $table->dropIndex('idx_products_pub_app_cat');
        });
    }
};
