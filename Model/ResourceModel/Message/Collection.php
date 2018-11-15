<?php
declare(strict_types=1);

/**
 * Class Collection
 * @package Val\AdvancedContactUs\Model\ResourceModel\Message
 */

namespace Val\AdvancedContactUs\Model\ResourceModel\Message;

use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Model\Message as MessageModel;
use Val\AdvancedContactUs\Model\ResourceModel\Message as MessageResource;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = MessageInterface::ENTITY_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(MessageModel::class, MessageResource::class);
    }

    /**
     * @param bool $status
     */
    public function addIsProcessedFilter($status)
    {
        $type = ($status) ? 1 : 0;
        $this->addFilter(MessageInterface::IS_PROCESSED, $type);
    }
}
