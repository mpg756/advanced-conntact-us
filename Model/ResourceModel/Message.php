<?php
declare(strict_types=1);

/**
 * Class Message
 * @package Val\AdvancedContactUs\Model\ResourceModel
 */

namespace Val\AdvancedContactUs\Model\ResourceModel;

use Val\AdvancedContactUs\Api\Data\MessageInterface;

class Message extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Message constructor.
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(MessageInterface::ENTITY_TYPE_ADVANCED_CONTACT, MessageInterface::ENTITY_ID);
    }
}
