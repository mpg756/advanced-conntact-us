<?php
declare(strict_types=1);

/**
 * Class IsProcessed
 * @package Val\AdvancedContactUs\Model\Message\Source
 */

namespace Val\AdvancedContactUs\Model\Message\Source;

class IsProcessed implements \Magento\Framework\Data\OptionSourceInterface
{

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        $options = [
            ['label' => 'Processed', 'value' => '1'],
            ['label' => 'Unprocessed', 'value' => '0']
        ];
        return $options;
    }
}
