<?php

namespace Drupal\Tests\acm_sku\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * @coversDefaultClass \Drupal\acm_sku\CategoryManager
 *
 * @group acm_sku
 */
class CategoryManagerTest extends BrowserTestBase {
  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'system',
    'config',
    'field',
    'filter',
    'text',
    'file',
    'image',
    'options',
    'key_value_field',
    'node',
    'user',
    'taxonomy',
    'language',
    'rest',
    'simple_oauth',
    'simple_oauth_extras',
    'serialization',
    'acm',
    'acm_sku',
    'acquia_commercemanager',
    'pcb',
  ];

  /**
   * Category Manager service.
   *
   * @var \Drupal\acm_sku\CategoryManager
   */
  protected $categoryManager;

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setup();
    // Load categories data.
    module_load_include('data', 'acm_sku', 'tests/data/categories_en');

    $this->categoryManager = $this->container->get('acm_sku.category_manager');
  }

  /**
   * Test category sync.
   */
  public function testSyncCategory() {
    global $_acm_commerce_categories_create;
    $result = $this->categoryManager->synchronizeTreeOffline('acm_product_category', $_acm_commerce_categories_create[0]['children']);
    $this->assertSame(count($result['created']), 9);

    global $_acm_commerce_categories_update;
    $result = $this->categoryManager->synchronizeTreeOffline('acm_product_category', $_acm_commerce_categories_update);
    $this->assertSame(count($result['updated']), 1);
  }

}
