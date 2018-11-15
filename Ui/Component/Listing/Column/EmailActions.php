<?php
declare(strict_types=1);

/**
 * Class EmailActions
 * @package Val\AdvancedContactUs\Ui\Component\Listing\Column
 */

namespace Val\AdvancedContactUs\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;
use Val\AdvancedContactUs\Api\Data\MessageInterface;

class EmailActions extends Column
{
    /** Url path */
    const EMAIL_URL_PATH_EDIT = 'advancedcontact/email/edit';
    const EMAIL_URL_PATH_DELETE = 'advancedcontact/email/delete';

    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::EMAIL_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl = $editUrl;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item[MessageInterface::ENTITY_ID])) {
                    $item[$name]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            $this->editUrl,
                            [MessageInterface::ENTITY_ID => $item[MessageInterface::ENTITY_ID]]
                        ),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href' => $this->urlBuilder->getUrl(
                            self::EMAIL_URL_PATH_DELETE,
                            [MessageInterface::ENTITY_ID => $item[MessageInterface::ENTITY_ID]]
                        ),
                        'label' => __('Delete'),
                        'confirm' => [
                            'title' => __('Delete "${ $.$data.email }"'),
                            'message' => __('Are you sure you wan\'t to delete a "${ $.$data.email }" record?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}
