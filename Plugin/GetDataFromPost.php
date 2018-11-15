<?php
declare(strict_types=1);

/**
 * Plugin Class GetDataFromPost
 * @see Magento\Contact\Controller\Index\Post
 * @package Val\AdvancedContactUs\Plugin
 */

namespace Val\AdvancedContactUs\Plugin;

use \Magento\Contact\Controller\Index\Post;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Store\Model\StoreManagerInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterfaceFactory;
use Val\AdvancedContactUs\Api\MessageRepositoryInterface;
use Val\AdvancedContactUs\Helper\Configuration;
use Val\AdvancedContactUs\Helper\GetCustomerIdByEmail;
use Psr\Log\LoggerInterface;

class GetDataFromPost
{
    /**
     * @var \Magento\Framework\Controller\Result\RedirectFactory
     */
    private $redirectFactory;
    /**
     * @var MessageInterfaceFactory
     */
    private $messageFactory;
    /**
     * @var MessageRepositoryInterface
     */
    private $messageRepository;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var GetCustomerIdByEmail
     */
    private $customerIdByEmail;
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * Post constructor.
     * @param \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory
     * @param MessageInterfaceFactory $messageFactory
     * @param MessageRepositoryInterface $messageRepository
     * @param GetCustomerIdByEmail $customerIdByEmail
     * @param LoggerInterface $logger
     * @param StoreManagerInterface $storeManager
     * @param Configuration $configuration
     */
    public function __construct(
        \Magento\Framework\Controller\Result\RedirectFactory $redirectFactory,
        MessageInterfaceFactory $messageFactory,
        MessageRepositoryInterface $messageRepository,
        GetCustomerIdByEmail $customerIdByEmail,
        LoggerInterface $logger,
        StoreManagerInterface $storeManager,
        Configuration $configuration
    ) {
        $this->redirectFactory = $redirectFactory;
        $this->messageFactory = $messageFactory;
        $this->messageRepository = $messageRepository;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->customerIdByEmail = $customerIdByEmail;
        $this->configuration = $configuration;
    }

    /**
     * @param Post $post
     * @param $result
     * @return Redirect
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function afterExecute(Post $post, $result): Redirect
    {
        if (!$this->configuration->isModuleEnabled()) {
            return $result;
        }

        $data = new DataObject($post->getRequest()->getParams());
        /**
         * @var $message MessageInterface
         */
        $message = $this->messageFactory->create();
        $customerId = $this->customerIdByEmail->getCustomerId($data->getEmail());
        $message->setName($data->getName())
            ->setEmail($data->getEmail())
            ->setPhone($data->getTelephone())
            ->setMessage($data->getComment())
            ->setStoreId($this->getStoreId())
            ->setCustomerId($customerId);
        try {
            $this->messageRepository->save($message);
        } catch (CouldNotSaveException $e) {
            $this->logger->error($e->getMessage());
        }
        return $result;
    }

    /**
     * Get store identifier
     *
     * @return  int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getStoreId()
    {
        return (int)$this->storeManager->getStore()->getId();
    }
}
