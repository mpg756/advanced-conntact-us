<?php
declare(strict_types=1);

/**
 * Class SaveButton
 * @package Val\AdvancedContactUs\Block\Adminhtml\Email\Edit
 */

namespace Val\AdvancedContactUs\Block\Adminhtml\Email\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Send Email'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
