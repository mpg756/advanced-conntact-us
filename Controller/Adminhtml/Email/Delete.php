<?php
declare(strict_types=1);

/**
 * Class Delete
 * @package Val\AdvancedContactUs\Controller\Adminhtml\Email
 */

namespace Val\AdvancedContactUs\Controller\Adminhtml\Email;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Api\MessageRepositoryInterface;
use Magento\Framework\Controller\Result\Redirect;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Val_AdvancedContactUs::delete';

    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param MessageRepositoryInterface $messageRepository
     */
    public function __construct(
        Action\Context $context,
        MessageRepositoryInterface $messageRepository

    ) {
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
    }


    /**
     * Execute action based on request and return result
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(MessageInterface::ENTITY_ID);
        $resultRedirect = $this->resultRedirectFactory->create(ResultFactory::TYPE_REDIRECT);
        try {
            if ($this->messageRepository->deleteById($id)) {
                $this->messageManager->addSuccessMessage(__('Message with id %1 has been deleted !', $id));
            } else {
                return $this->throwErrorAndRedirect($resultRedirect);
            }
        } catch (NoSuchEntityException $e) {
            return $this->throwErrorAndRedirect($resultRedirect);
        } catch (CouldNotDeleteException $e) {
            return $this->throwErrorAndRedirect($resultRedirect);
        }
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }

    /**
     * @param Redirect $resultRedirect
     * @return Redirect
     */
    protected function throwErrorAndRedirect(Redirect $resultRedirect): Redirect
    {
        $this->messageManager->addErrorMessage(__('Unable to proceed. Error occurred.'));
        return $resultRedirect->setPath('*/*/index', ['_current' => true]);
    }
}
