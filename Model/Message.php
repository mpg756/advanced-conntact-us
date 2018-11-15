<?php
declare(strict_types=1);

/**
 * Class Message
 * @package Val\AdvancedContactUs\Model
 */

namespace Val\AdvancedContactUs\Model;

use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Model\ResourceModel\Message as MessageResource;

class Message extends \Magento\Framework\Model\AbstractModel implements MessageInterface
{
    protected $_cacheTag = 'val_advanced_contact_us_message';
    protected $_eventPrefix = 'val_advanced_contact_us_message';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(MessageResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerId()
    {
        return $this->getData(self::CUSTOMER_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerId($customerId): MessageInterface
    {
        $this->setData(self::CUSTOMER_ID, $customerId);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return $this->getData(self::NAME);
    }

    /**
     * @inheritdoc
     */
    public function setName(string $name): MessageInterface
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setEmail(string $email): MessageInterface
    {
        $this->setData(self::EMAIL, $email);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhone(): string
    {
        return $this->getData(self::PHONE);
    }

    /**
     * @inheritdoc
     */
    public function setPhone(string $phone): MessageInterface
    {
        $this->setData(self::PHONE, $phone);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->getData(self::STORE_ID);
    }

    /**
     * @inheritdoc
     */
    public function setStoreId($storeId): MessageInterface
    {
        $this->setData(self::STORE_ID, $storeId);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->getData(self::MESSAGE);
    }

    /**
     * @inheritdoc
     */
    public function setMessage(string $message): MessageInterface
    {
        $this->setData(self::MESSAGE, $message);
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * @inheritdoc
     */
    public function getIsProcessed(): bool
    {
        return ($this->getData(self::IS_PROCESSED) === 1) ? true : false;
    }

    /**
     * @inheritdoc
     */
    public function setIsProcessed(bool $status): MessageInterface
    {
        $isProcessed = ($status) ? 1 : 0;
        $this->setData(self::IS_PROCESSED, $isProcessed);
        return $this;
    }
}
