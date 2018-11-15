<?php
declare(strict_types=1);

/**
 * Class InstallSchema
 * @package Val\AdvancedContactUs\Setup
 */

namespace Val\AdvancedContactUs\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterface;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists(MessageInterface::ENTITY_TYPE_ADVANCED_CONTACT)) {
            /**
             * Create table 'advanced_contact_us'
             */
            $table = $installer->getConnection()->newTable(
                $installer->getTable(MessageInterface::ENTITY_TYPE_ADVANCED_CONTACT)
            )->addColumn(
                MessageInterface::ENTITY_ID,
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'nullable' => false,
                    'primary'  => true,
                    'unsigned' => true
                ],
                "Message id"
            )->addColumn(
                MessageInterface::CUSTOMER_ID,
                Table::TYPE_INTEGER,
                null,
                ['nullable' => true, 'unsigned' => true],
                "User id"
            )->addColumn(
                MessageInterface::STORE_ID,
                Table::TYPE_SMALLINT,
                5,
                ['nullable => false', 'unsigned' => true],
                'Store Id'
            )->addColumn(
                MessageInterface::NAME,
                Table::TYPE_TEXT,
                64,
                ['nullable => false'],
                'User Name'
            )->addColumn(
                MessageInterface::EMAIL,
                Table::TYPE_TEXT,
                128,
                ['nullable => false'],
                'Email'
            )->addColumn(
                MessageInterface::PHONE,
                Table::TYPE_TEXT,
                255,
                ['nullable => true'],
                'Phone number'
            )->addColumn(
                MessageInterface::MESSAGE,
                Table::TYPE_TEXT,
                null,
                ['nullable => true'],
                'Message'
            )->addColumn(
                MessageInterface::CREATED_AT,
                Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
                'Request Creation Time'
            )->addColumn(
                MessageInterface::IS_PROCESSED,
                Table::TYPE_SMALLINT,
                1,
                ['default' => 0],
                'Post Status'
            )->addForeignKey(
                $installer->getFkName(
                    MessageInterface::ENTITY_TYPE_ADVANCED_CONTACT,
                    MessageInterface::CUSTOMER_ID,
                    'customer_entity',
                    'entity_id'
                ),
                MessageInterface::CUSTOMER_ID,
                $installer->getTable('customer_entity'),
                'entity_id',
                Table::ACTION_SET_NULL
            )->addForeignKey(
                $installer->getFkName(
                    MessageInterface::ENTITY_TYPE_ADVANCED_CONTACT,
                    MessageInterface::STORE_ID,
                    'store',
                    'store_id'
                ),
                MessageInterface::STORE_ID,
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_SET_NULL
            )->setComment('Email table');
            $installer->getConnection()->createTable($table);
            $installer->endSetup();
        }
    }
}
