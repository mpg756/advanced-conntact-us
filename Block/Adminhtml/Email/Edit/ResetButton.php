<?php
declare(strict_types=1);

/**
 * Class ResetButton
 * @package Val\AdvancedContactUs\Block\Adminhtml\Email\Edit
 */

namespace Val\AdvancedContactUs\Block\Adminhtml\Email\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
