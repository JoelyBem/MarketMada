<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

namespace Tests\Integration\PrestaShopBundle\Model\Product;

use PrestaShopBundle\Model\Product\AdminModelAdapter;
use Product;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tests\Integration\Utility\ContextMockerTrait;

class AdminModelAdapterTest extends KernelTestCase
{
    use ContextMockerTrait;

    /** @var AdminModelAdapter */
    private $adminModelAdapter;

    /** @var Product */
    private $product;

    private function fakeFormData(): array
    {
        return [
            'id_product' => '',
            'step1' => [
                'type_product' => '',
                'inputPackItems' => [],
                'name' => [],
                'name_1' => 'Amazing product',
                'name_2' => 'Amazing product',
                'description' => [],
                'description_short' => [],
                'active' => '',
                'price_shortcut' => '',
                'qty_0_shortcut' => '',
                'categories' => ['tree' => []],
                'id_category_default' => '',
                'related_products' => [],
                'id_manufacturer' => '',
                'features' => [],
                'images' => [],
            ],
            'step2' => [
                'price' => '',
                'ecotax' => '',
                'id_tax_rules_group' => '',
                'on_sale' => '',
                'wholesale_price' => '',
                'unit_price' => '',
                'unity' => '',
                'specific_price' => [],
                'specificPricePriority_0' => '',
                'specificPricePriority_1' => '',
                'specificPricePriority_2' => '',
                'specificPricePriority_3' => '',
            ],
            'step3' => [
                'advanced_stock_management' => '',
                'depends_on_stock' => '',
                'qty_0' => '',
                'combinations' => [],
                'out_of_stock' => '',
                'minimal_quantity' => '',
                'low_stock_threshold' => '',
                'low_stock_alert' => '',
                'available_now' => [],
                'available_later' => [],
                'available_date' => '',
                'pack_stock_type' => '',
                'virtual_product' => [],
            ],
            'step4' => [
                'width' => '',
                'height' => '',
                'depth' => '',
                'weight' => '',
                'additional_shipping_cost' => '',
                'selectedCarriers' => [],
                'additional_delivery_times' => '',
                'delivery_in_stock' => [],
                'delivery_out_stock' => [],
            ],
            'step5' => [
                'link_rewrite' => [],
                'meta_title' => [],
                'meta_description' => [],
            ],
            'step6' => [
                'redirect_type' => '',
                'id_type_redirected' => [],
                'visibility' => '',
                'tags' => [],
                'display_options' => [],
                'upc' => '',
                'mpn' => '',
                'ean13' => '',
                'isbn' => '',
                'reference' => '',
                'condition' => '',
                'suppliers' => [],
                'default_supplier' => '',
                'custom_fields' => [],
                'attachments' => [],
                'supplier_combination_1' => [],
            ],
        ];
    }

    private function fakeCombination(): array
    {
        return ['0' => [
            'id_product_attribute' => '6',
            'id_product' => '1',
            'reference' => '',
            'supplier_reference' => '',
            'location' => '',
            'ean13' => '',
            'isbn' => '',
            'upc' => '',
            'mpn' => '',
            'wholesale_price' => '1.250000',
            'price' => '0.000000',
            'ecotax' => '0.000000',
            'ecotax_tax_excluded' => '0.000000',
            'ecotax_tax_included' => '0.000000',
            'quantity' => 300,
            'weight' => '0.000000',
            'unit_price_impact' => '0.000000',
            'default_on' => null,
            'minimal_quantity' => '1',
            'low_stock_threshold' => '2',
            'low_stock_alert' => '1',
            'available_date' => '0000-00-00',
            'id_shop' => '1',
            'id_attribute_group' => '1',
            'is_color_group' => '0',
            'group_name' => 'Taille',
            'attribute_name' => 'L',
            'id_attribute' => '3',
        ]];
    }

    private function fakeProduct(): Product
    {
        $product = new Product();
        $product->name = 'Product name';

        return $product;
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->product = $this->fakeProduct();
        $this->adminModelAdapter = new AdminModelAdapter(
            self::$kernel->getContainer()->get('prestashop.adapter.legacy.context'),
            self::$kernel->getContainer()->get('prestashop.adapter.admin.wrapper.product'),
            self::$kernel->getContainer()->get('prestashop.adapter.tools'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.product'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.supplier'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.warehouse'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.feature'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.pack'),
            self::$kernel->getContainer()->get('prestashop.adapter.shop.context'),
            self::$kernel->getContainer()->get('prestashop.adapter.data_provider.tax'),
            self::$kernel->getContainer()->get('prestashop.adapter.legacy.configuration'),
            self::$kernel->getContainer()->get('router'),
            self::$kernel->getContainer()->get('prestashop.utils.float_parser')
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->product, $this->adminModelAdapter);
    }

    /**
     * Checks that the construction of object still works as expected
     */
    public function testConstruct(): void
    {
        $this->assertInstanceOf(AdminModelAdapter::class, $this->adminModelAdapter);
    }

    public function testGetFormData(): void
    {
        $this->assertIsArray($this->adminModelAdapter->getFormData($this->product));
        $expectedArrayStructure = $this->fakeFormData();

        foreach ($expectedArrayStructure as $property => $value) {
            $this->assertArrayHasKey(
                $property,
                $this->adminModelAdapter->getFormData($this->product),
                sprintf('The expected key %s was not found', $property)
            );
        }
    }

    public function testGetModelData(): void
    {
        $this->assertIsArray($this->adminModelAdapter->getModelData($this->fakeFormData()));
    }

    /**
     * @todo find a way to check the value of `attribute_quantity` and `name` and `attribute_price_display` that depend on database
     */
    public function testGetFormCombination(): void
    {
        $expectedStructureReturn = [
            'id_product_attribute' => '6',
            'attribute_reference' => '',
            'attribute_ean13' => '',
            'attribute_isbn' => '',
            'attribute_upc' => '',
            'attribute_mpn' => '',
            'attribute_wholesale_price' => '1.250000',
            'attribute_price_impact' => 0,
            'attribute_price' => '0.000000',
            'attribute_price_display' => '$0.00',
            'final_price' => '0.000000',
            'final_price_tax_included' => '0.000000',
            'attribute_priceTI' => '',
            'product_ecotax' => '0.000000',
            'attribute_ecotax' => '0.000000',
            'attribute_weight_impact' => 0,
            'attribute_weight' => '0.000000',
            'attribute_unit_impact' => 0,
            'attribute_unity' => '0.000000',
            'attribute_minimal_quantity' => '1',
            'attribute_low_stock_threshold' => '2',
            'attribute_low_stock_alert' => '1',
            'available_date_attribute' => '0000-00-00',
            'attribute_default' => false,
            'attribute_location' => false,
            'attribute_quantity' => 300,
            'name' => 'Taille - L',
            'id_product' => null,
        ];
        $combinationDataProvider = self::$kernel->getContainer()->get('prestashop.adapter.data_provider.combination');
        $actualReturn = $combinationDataProvider->completeCombination($this->fakeCombination(), $this->product);

        foreach ($expectedStructureReturn as $property => $value) {
            $this->assertArrayHasKey($property, $actualReturn, sprintf('The expected key %s was not found', $property));
            $this->assertEquals(
                $value,
                $actualReturn[$property],
                sprintf('The expected value for property %s is wrong', $property)
            );
        }

        // Test full equals to check if there are additional unexpected fields
        $this->assertEquals($expectedStructureReturn, $actualReturn);
    }
}
