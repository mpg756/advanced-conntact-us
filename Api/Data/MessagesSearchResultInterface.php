<?php
declare(strict_types=1);

/**
 * Interface MessagesSearchResultInterface
 * @package Val\AdvancedContactUs\Api\Data
 */

namespace Val\AdvancedContactUs\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface MessagesSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get messages list.
     *
     * @return MessageInterface[]
     */
    public function getItems();

    /**
     * Set messages list.
     *
     * @param MessageInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
