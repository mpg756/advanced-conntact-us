<?php
declare(strict_types=1);

/**
 * Interface MessageRepositoryInterface
 * @package Val\AdvancedContactUs\Api
 */

namespace Val\AdvancedContactUs\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Api\Data\MessagesSearchResultInterface;

interface MessageRepositoryInterface
{
    /**
     * Save the message object
     *
     * @param MessageInterface $message
     * @return MessageInterface
     *
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(MessageInterface $message): MessageInterface;

    /**
     * Get message by id
     *
     * @param $messageId
     * @return MessageInterface
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($messageId);

    /**
     * Remove message
     *
     * @param MessageInterface $message
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(MessageInterface $message): bool;

    /**
     * Remove message by id
     *
     * @param $messageId
     * @return bool Will returned True if deleted
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById($messageId): bool;
}
