<?php
declare(strict_types=1);

/**
 * Class MessageRepository
 * @package Val\AdvancedContactUs\Model
 */

namespace Val\AdvancedContactUs\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterfaceFactory;
use Val\AdvancedContactUs\Api\Data\MessagesSearchResultInterface;
use Val\AdvancedContactUs\Api\Data\MessagesSearchResultInterfaceFactory;
use Val\AdvancedContactUs\Api\MessageRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Val\AdvancedContactUs\Model\ResourceModel\Message\Collection;
use Val\AdvancedContactUs\Model\ResourceModel\Message\CollectionFactory;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * @var MessageInterfaceFactory
     */
    protected $messageFactory;
    /**
     * @var ResourceModel\Message
     */
    protected $resourceModel;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var MessagesSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    public function __construct(
        MessageInterfaceFactory $messageFactory,
        StoreManagerInterface $storeManager,
        ResourceModel\Message $resourceModel,
        CollectionFactory $collectionFactory,
        MessagesSearchResultInterfaceFactory $searchResultsFactory
    ) {
        $this->messageFactory = $messageFactory;
        $this->resourceModel = $resourceModel;
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritdoc
     */
    public function save(MessageInterface $message): MessageInterface
    {
        if ($message->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $message->setStoreId($storeId);
        }
        try {
            $this->resourceModel->save($message);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__(
                'Could not save the message: %1',
                $e->getMessage()
            ));
        }
        return $message;
    }

    /**
     * @inheritdoc
     */
    public function getById($messageId)
    {
        /**
         * @var $messageModel Message
         */
        $messageModel = $this->messageFactory->create();
        $this->resourceModel->load($messageModel, $messageId);
        if (!$messageModel->getId()) {
            throw new NoSuchEntityException(__('Requested message with id %1 does not exist'), $messageId);
        }
        return $messageModel;
    }

    /**
     * @inheritdoc
     */
    public function delete(MessageInterface $message): bool
    {
        try {
            $this->resourceModel->delete($message);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__(
                'Could not delete the message: %1',
                $e->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function deleteById($messageId): bool
    {
        return $this->delete($this->getById($messageId));
    }
}
