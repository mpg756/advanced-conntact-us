<?php
declare(strict_types=1);

/**
 * Class Save
 * @package Val\AdvancedContactUs\Controller\Adminhtml\Email
 */

namespace Val\AdvancedContactUs\Controller\Adminhtml\Email;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Val\AdvancedContactUs\Api\MessageRepositoryInterface;
use Val\AdvancedContactUs\Helper\SendEmail;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Psr\Log\LoggerInterface;

class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Val_AdvancedContactUs::save';
    /**
     * @var SendEmail
     */
    protected $emailHelper;
    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param SendEmail $emailHelper
     * @param MessageRepositoryInterface $messageRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        Action\Context $context,
        SendEmail $emailHelper,
        MessageRepositoryInterface $messageRepository,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->emailHelper = $emailHelper;
        $this->messageRepository = $messageRepository;
        $this->logger = $logger;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $request = $this->getRequest();
        $messageId = $request->getParam(MessageInterface::ENTITY_ID);
        $resultRedirect = $this->resultRedirectFactory->create();

        try {
            $message = $this->messageRepository->getById($messageId);
        } catch (NoSuchEntityException $e) {
            $this->sendErrorMessage();
            $this->logError($e);
            return $resultRedirect->setPath('*/*/index', ['_current' => true]);
        }
        $receiverInfo = [
            'name' => $request->getParam(MessageInterface::NAME),
            'email' => $request->getParam(MessageInterface::EMAIL)
        ];
        $emailTemplateVariables = [
            'user_name' => $request->getParam(MessageInterface::NAME),
            'response_header' => $request->getParam(MessageInterface::RESPONSE_TITLE),
            'response_body' => $request->getParam(MessageInterface::RESPONSE_BODY)
        ];
        $result = $this->emailHelper->sendEmail($emailTemplateVariables, $receiverInfo);
        if ($result) {
            $this->messageManager->addSuccessMessage(__('Email has been sent.'));
            $message->setIsProcessed(true);
            try {
                $this->messageRepository->save($message);
            } catch (CouldNotSaveException $e) {
                $this->logError($e);
                $this->sendErrorMessage();
            }
        } else {
            $this->sendErrorMessage();
        }
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }

    /**
     * @param LocalizedException $e
     */
    protected function logError(LocalizedException $e)
    {
        $this->logger->error(__('Error in %1: %2', self::class, $e->getMessage()));
    }

    /**
     * @return \Magento\Framework\Message\ManagerInterface
     */
    protected function sendErrorMessage()
    {
        return $this->messageManager->addErrorMessage(
            __('Unable to send an email. Error occurred. See error logs for the details')
        );
    }
}
