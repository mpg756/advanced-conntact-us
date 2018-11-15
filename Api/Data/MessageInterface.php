<?php
declare(strict_types=1);

/**
 * Interface MessageInterface
 * @package Val\AdvancedContactUs\Api\Data
 */

namespace Val\AdvancedContactUs\Api\Data;

/**
 * @method getId()
 * @method $this setId($id)
 */
interface MessageInterface
{
    const ENTITY_TYPE_ADVANCED_CONTACT = "advanced_contact_us";
    const ENTITY_ID = "message_id";
    const CUSTOMER_ID = "customer_id";
    const NAME = "name";
    const EMAIL = "email";
    const PHONE = "phone";
    const STORE_ID = "store_id";
    const MESSAGE = "message";
    const CREATED_AT = "created_at";
    const IS_PROCESSED = "is_processed";

    const RESPONSE_TITLE = "response_title";
    const RESPONSE_BODY = "response";

    const REGISTRY_INDEX = "advanced_contact_us_registry_id";

    /**
     * Get customer id
     *
     * @return int|null
     */
    public function getCustomerId();

    /**
     * Set customer id
     *
     * @param int|string|null $customerId
     * @return MessageInterface
     */
    public function setCustomerId($customerId): self;

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string ;

    /**
     * Set name
     *
     * @param string $name
     * @return MessageInterface
     */
    public function setName(string $name): self;

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Set email
     *
     * @param string $email
     * @return MessageInterface
     */
    public function setEmail(string $email): self;

    /**
     * Get phone number
     *
     * @return string
     */
    public function getPhone(): string;

    /**
     * Set phone number
     *
     * @param string $phone
     * @return MessageInterface
     */
    public function setPhone(string $phone): self;

    /**
     * Get store id
     *
     * @return int
     */
    public function getStoreId();

    /**
     * Set store id
     *
     * @param int $storeId
     * @return MessageInterface
     */
    public function setStoreId($storeId): self;

    /**
     * Get message from contact us form
     *
     * @return string|null
     */
    public function getMessage();

    /**
     * Set message
     *
     * @param string $message
     * @return MessageInterface
     */
    public function setMessage(string $message):self;

    /**
     * Set created at date
     *
     * @return string
     */
    public function getCreatedAt(): string;

    /**
     * Get status of message
     *
     * @return bool false is unprocessed true is processed
     */
    public function getIsProcessed(): bool;

    /**
     * Set message status
     *
     * @param bool $status
     * @return MessageInterface
     */
    public function setIsProcessed(bool $status): self;

}
