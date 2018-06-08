<?php
/**
 * @package Custom_Module
 * @author  Deepak K
 * @copyright Copyright © 2018 Corra. All rights reserved.
 */

namespace Custom\Module\Setup;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    protected $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * UpgradeData constructor.
     * @param CustomerSetupFactory $customerSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        if (version_compare($context->getVersion(), '1.0.1', '<')) {

            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            $attributeSet = $this->attributeSetFactory->create();
            $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute('customer_address', 'residential_type', [
                'type' => 'varchar',
                'label' => 'Residential Type',
                'input' => 'select',
                'source' => 'Custom\Module\Model\Attribute\Source\ResType',
                'required' => false,
                'visible' => true,
                'visible_on_front' => true,
                'is_user_defined' => 1,
                'sort_order' => 43,
                'position' => 43
            ]);

            $attribute = $customerSetup->getEavConfig()->getAttribute('customer_address', 'residential_type')
                ->addData([
                    'attribute_set_id' => $attributeSetId,
                    'attribute_group_id' => $attributeGroupId,
                    'used_in_forms' => ['adminhtml_customer_address', 'customer_address_edit', 'customer_register_address','customer_address'],
                ]);
            $attribute->save();
        }

        if(version_compare($context->getVersion(), '1.0.2', '<'))
        {
            $tableNames = [
                'quote_address',
                'sales_order_address'
            ];

            $connection = $setup->getConnection();
            foreach ($tableNames as $tableName) {

                $connection->addColumn($tableName, 'residential_type', [
                    'type' => Table::TYPE_TEXT,
                    'nullable' => true,
                    'default' => null,
                    'length' => 255,
                    'comment' => 'Residential Type',
                ]);

            }
        }

        $setup->endSetup();
    }


}
