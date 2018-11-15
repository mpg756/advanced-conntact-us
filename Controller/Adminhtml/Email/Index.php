<?php
declare(strict_types=1);

/**
 * Class Index
 * @package Val\AdvancedContactUs\Controller\Adminhtml\Email
 */

namespace Val\AdvancedContactUs\Controller\Adminhtml\Email;

use Magento\Framework\App\ResponseInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Val_AdvancedContactUs::config';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Val_AdvancedContactUs::email_list');
        $resultPage->addBreadcrumb(__('Email list'), __('Email list'));
        $resultPage->getConfig()->getTitle()->prepend(__('Email list'));

        return $resultPage;
    }
}
