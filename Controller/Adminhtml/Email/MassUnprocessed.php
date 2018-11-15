<?php
declare(strict_types=1);

/**
 * Class MassUnprocessed
 * @package Val\AdvancedContactUs\Controller\Adminhtml\Email
 */

namespace Val\AdvancedContactUs\Controller\Adminhtml\Email;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Val\AdvancedContactUs\Model\ResourceModel\Message\CollectionFactory;
use Val\AdvancedContactUs\Model\ResourceModel\Message\Collection;
use Magento\Ui\Component\MassAction\Filter;

class MassUnprocessed extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Val_AdvancedContactUs::config';
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var Filter
     */
    private $filter;

    /**
     * MassDelete constructor.
     * @param Action\Context $context
     * @param CollectionFactory $collectionFactory
     * @param Filter $filter
     */
    public function __construct(
        Action\Context $context,
        CollectionFactory $collectionFactory,
        Filter  $filter
    ) {
        parent::__construct($context);
        $this->collectionFactory = $collectionFactory;
        $this->filter = $filter;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect|ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function execute()
    {
        /** @var $messageCollection  Collection*/
        $messageCollection = $this->collectionFactory->create();
        $filterCollection = $this->filter->getCollection($messageCollection);
        $collectionSize = $filterCollection->getSize();
        foreach ($filterCollection as $item) {
            $item->setIsProcessed(false);
            $item->save();
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 element(s) have been updated.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
