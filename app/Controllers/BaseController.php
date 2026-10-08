<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Auto-install database tables silently if uploading to live server for the first time
        $this->autoInstallDatabaseIfMissing();
    }

    protected function autoInstallDatabaseIfMissing(): void
    {
        static $checked = false;
        if ($checked) return;
        $checked = true;

        try {
            $db = \Config\Database::connect();
            if (!$db->tableExists('categories') || !$db->tableExists('products')) {
                $schemaPath = defined('ROOTPATH') ? ROOTPATH . 'schema.sql' : __DIR__ . '/../../schema.sql';
                if (!file_exists($schemaPath)) {
                    $schemaPath = defined('ROOTPATH') ? ROOTPATH . 'database.sql' : __DIR__ . '/../../database.sql';
                }

                if (file_exists($schemaPath)) {
                    $sql = file_get_contents($schemaPath);
                    $db->disableForeignKeyChecks();
                    
                    $queries = preg_split("/;\s*[\r\n]+/", $sql);
                    foreach ($queries as $q) {
                        $q = trim($q);
                        if (!empty($q) && strpos($q, '--') !== 0) {
                            try {
                                $db->query($q);
                            } catch (\Throwable $e) {
                                // Continue importing queries
                            }
                        }
                    }
                    $db->enableForeignKeyChecks();
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'Auto DB install notice: ' . $e->getMessage());
        }
    }
}
