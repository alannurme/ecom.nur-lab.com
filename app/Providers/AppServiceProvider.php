<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Services\SellerHubService;
use App\Models\SellerAdminRequest;
use App\Models\SellerAdminPromotionParticipate;
use App\Models\SellerAdminMessage;
use App\Models\SellerAdminConversation;

class AppServiceProvider extends ServiceProvider
{
  public function boot()
  {
    Schema::defaultStringLength(191);
    Paginator::useBootstrap();

    // Auto-create missing database tables if they do not exist
    try {
      if (!Schema::hasTable('seller_admin_requests')) {
        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_conversations` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `sender_id` INT(11) NOT NULL,
          `receiver_id` INT(11) NOT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_messages` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_admin_conversation_id` INT(11) NOT NULL,
          `user_id` INT(11) NOT NULL,
          `message` LONGTEXT NOT NULL,
          `seen` INT(2) NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_promotions` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `todays_deal` INT(2) NOT NULL DEFAULT 0,
          `featured_products` INT(2) NOT NULL DEFAULT 0,
          `flash_sale_id` INT(11) NULL,
          `message` LONGTEXT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_promotion_sellers` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_admin_promotion_id` INT(11) NOT NULL,
          `seller_id` INT(11) NOT NULL,
          `seen` INT(2) NOT NULL DEFAULT 0,
          `responded` INT(2) NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_notices` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `notice_type` VARCHAR(255) NOT NULL DEFAULT 'permanent',
          `notice_datetime` VARCHAR(255) NULL,
          `message` LONGTEXT NULL,
          `bg_color` VARCHAR(255) NULL,
          `save_as_preset` INT(2) NOT NULL DEFAULT 0,
          `status` INT(2) NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_notice_sellers` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_admin_notice_id` INT(11) NOT NULL,
          `seller_id` INT(11) NOT NULL,
          `seen` INT(2) NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_requests` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_id` INT(11) NOT NULL,
          `name` VARCHAR(255) NOT NULL,
          `category_name` VARCHAR(255) NULL,
          `brand_name` VARCHAR(255) NULL,
          `color_name` VARCHAR(255) NULL,
          `attribute_name` VARCHAR(255) NULL,
          `unit_name` VARCHAR(255) NULL,
          `measurement_point_name` VARCHAR(255) NULL,
          `warranty_name` VARCHAR(255) NULL,
          `seen` INT(2) NOT NULL DEFAULT 0,
          `message` LONGTEXT NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_promotion_participates` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_admin_promotion_id` INT(11) NOT NULL,
          `seller_id` INT(11) NOT NULL,
          `seen` INT(2) NOT NULL DEFAULT 0,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");

        \DB::statement("CREATE TABLE IF NOT EXISTS `seller_admin_promotion_participate_products` (
          `id` int(20) NOT NULL AUTO_INCREMENT,
          `seller_admin_promotion_participate_id` INT(11) NOT NULL,
          `product_id` INT(11) NOT NULL,
          `todays_deal` INT(2) NOT NULL DEFAULT 0,
          `featured` INT(2) NOT NULL DEFAULT 0,
          `flash_sale` INT(2) NOT NULL DEFAULT 0,
          `flash_sale_id` INT(11) NULL,
          `discount` double(20,2) NULL,
          `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
          `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          PRIMARY KEY (`id`)
        )");
      }
    } catch (\Exception $e) {
      // Ignore database connection error during setup
    }

    View::composer('seller.inc.seller_nav', function ($view) {
      if (Auth::check() && Auth::user()->user_type === 'seller') {
        if (Schema::hasTable('seller_admin_requests')) {
          $hubData = app(SellerHubService::class)->getHubData(Auth::id());
          $view->with('hasAnyUnseen', $hubData['hasAnyUnseen'] ?? false);
        } else {
          $view->with('hasAnyUnseen', false);
        }
      } else {
        $view->with('hasAnyUnseen', false);
      }
    });

    View::composer('backend.inc.admin_nav', function ($view) {
      if (Auth::check() && Auth::user()->user_type === 'admin') {
        $adminId = Auth::id();

        $hasUnseenRequests = Schema::hasTable('seller_admin_requests') 
          ? SellerAdminRequest::where('seen', 0)->exists() 
          : false;

        $hasUnseenPromotionParticipates = Schema::hasTable('seller_admin_promotion_participates') 
          ? SellerAdminPromotionParticipate::where('seen', 0)->exists() 
          : false;

        $hasUnseenMessages = false;
        if (Schema::hasTable('seller_admin_conversations') && Schema::hasTable('seller_admin_messages')) {
          $conversationIds = SellerAdminConversation::where(function ($q) use ($adminId) {
            $q->where('sender_id', $adminId)->orWhere('receiver_id', $adminId);
          })->pluck('id');

          $hasUnseenMessages = SellerAdminMessage::whereIn('seller_admin_conversation_id', $conversationIds)
            ->where('user_id', '!=', $adminId)
            ->where('seen', 0)
            ->exists();
        }

        $hasAnyUnseen = $hasUnseenRequests || $hasUnseenPromotionParticipates || $hasUnseenMessages;

        $view->with([
          'hasAnyUnseen'                   => $hasAnyUnseen,
          'hasUnseenRequests'              => $hasUnseenRequests,
          'hasUnseenPromotionParticipates' => $hasUnseenPromotionParticipates,
          'hasUnseenMessages'              => $hasUnseenMessages,
        ]);
      } else {
        $view->with([
          'hasAnyUnseen'                   => false,
          'hasUnseenRequests'              => false,
          'hasUnseenPromotionParticipates' => false,
          'hasUnseenMessages'              => false,
        ]);
      }
    });
  }

  public function register() {}
}
