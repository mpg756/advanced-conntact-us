<?php
declare(strict_types=1);

/**
 * Class GenericButton
 * @package Val\AdvancedContactUs\Block\Adminhtml\Email\Edit
 */

namespace Val\AdvancedContactUs\Block\Adminhtml\Email\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;
use Val\AdvancedContactUs\Api\Data\MessageInterface;

class GenericButton
{
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * Registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * Constructor
     *
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        Registry $registry
    ) {
        $this->urlBuilder = $context->getUrlBuilder();
        $this->registry = $registry;
    }

    /**
     * Return the synonyms group Id.
     *
     * @return int|null
     */
    public function getBlockId()
    {
        $contact = $this->registry->registry(MessageInterface::REGISTRY_INDEX);
        return ($contact) ? $contact->getId() : null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
