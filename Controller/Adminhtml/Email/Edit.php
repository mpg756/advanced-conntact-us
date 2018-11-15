<?php
declare(strict_types=1);

/**
 * Class Edit
 * @package Val\AdvancedContactUs\Controller\Adminhtml\Email
 */

namespace Val\AdvancedContactUs\Controller\Adminhtml\Email;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Result\PageFactory;
use Val\AdvancedContactUs\Api\Data\MessageInterface;
use Val\AdvancedContactUs\Api\MessageRepositoryInterface;
use Magento\Framework\Controller\Result\Redirect;


class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Val_AdvancedContactUs::save';
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var MessageRepositoryInterface
     */
    protected $messageRepository;


    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        MessageRepositoryInterface $messageRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
        $this->messageRepository = $messageRepository;
    }


    /**
     * @return ResponseInterface|Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
//        $id = $this->getRequest()->getParam(MessageInterface::ENTITY_ID);
//        $resultRedirect = $this->resultRedirectFactory->create();
//        if (!$id) {
//            return $this->throwErrorAndRedirect($resultRedirect);
//        }
//        try {
//            $messageModel = $this->messageRepository->getById($id);
//            if (!$messageModel->getId()) {
//                return $this->throwErrorAndRedirect($resultRedirect);
//            }
//        } catch (NoSuchEntityException $e) {
//            return $this->throwErrorAndRedirect($resultRedirect);
//        }
//        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        return $this->resultPageFactory->create();
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
