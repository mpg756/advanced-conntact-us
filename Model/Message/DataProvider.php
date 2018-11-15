<?php
declare(strict_types=1);

/**
 * Class DataProvider
 * @package Val\AdvancedContactUs\Model\Message
 */

namespace Val\AdvancedContactUs\Model\Message;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Val\AdvancedContactUs\Model\ResourceModel\Message\Collection;
use Val\AdvancedContactUs\Model\Message;
use Val\AdvancedContactUs\Model\ResourceModel\Message\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var array
     */
    protected $loadedData;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var $message Message*/
        foreach ($items as $message) {
            $this->loadedData[$message->getId()] = $message->getData();
        }
        return $this->loadedData;
    }
}
