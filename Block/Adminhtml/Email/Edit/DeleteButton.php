<?php
declare(strict_types=1);

/**
 * Class DeleteButton
 * @package Val\AdvancedContactUs\Block\Adminhtml\Email\Edit
 */

namespace Val\AdvancedContactUs\Block\Adminhtml\Email\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getBlockId()) {
            $data = [
                'label' => __('Delete Block'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\'' .
                    __('Are you sure you want to do this?') .
                    '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['block_id' => $this->getBlockId()]);
    }
}
