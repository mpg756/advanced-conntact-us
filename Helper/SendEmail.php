<?php
declare(strict_types=1);

/**
 * Class SendEmail
 * @package Val\AdvancedContactUs\Helper
 */

namespace Val\AdvancedContactUs\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Exception\MailException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class SendEmail extends \Magento\Framework\App\Helper\AbstractHelper
{
    const EMAIL_TEMPLATE_FIELD_PATH = 'advanced_contact_us/general/template';
    const GENERAL_CONTACT_EMAIL = 'trans_email/ident_support/email';
    const GENERAL_CONTACT_NAME = 'trans_email/ident_support/name';
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var string
     */
    protected $templateId;
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * SendEmail constructor.
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        LoggerInterface $logger
    ) {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * @param string $path
     * @return mixed
     */
    protected function getConfigValue($path)
    {
        return $this->scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return int
     */
    protected function getStoreId()
    {
        $storeId = 0;
        try {
            $storeId = $this->storeManager->getStore()->getId();
        } catch (NoSuchEntityException $e) {
        }
        return $storeId;
    }

    /**
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     * @return $this
     */
    protected function generateTemplate($emailTemplateVariables, $receiverInfo, $senderInfo): self
    {
        $this->transportBuilder->setTemplateIdentifier($this->templateId)
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => $this->getStoreId(),
                ]
            )
            ->setTemplateVars($emailTemplateVariables)
            ->setFrom($senderInfo)
            ->addTo($receiverInfo['email'], $receiverInfo['name']);
        return $this;
    }

    /**
     * Send Email
     *
     * @param $emailTemplateVariables
     * @param $senderInfo
     * @param $receiverInfo
     *
     * @return bool
     */
    public function sendEmail($emailTemplateVariables, $receiverInfo, $senderInfo = null)
    {
        if (!$senderInfo) {
            $senderInfo = $this->getGeneralContact();
        }
        $this->templateId = $this->getConfigValue(self::EMAIL_TEMPLATE_FIELD_PATH);
        $this->inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $receiverInfo, $senderInfo);
        $transport = $this->transportBuilder->getTransport();
        try {
            $transport->sendMessage();
        } catch (MailException $e) {
            $this->logger->error(__("Unable to send an email: %1", $e->getMessage()));
            return false;
        }
        $this->inlineTranslation->resume();
        return true;
    }

    /**
     * @return array
     */
    protected function getGeneralContact(): array
    {
        return [
            'name' => $this->getConfigValue(self::GENERAL_CONTACT_NAME),
            'email' => $this->getConfigValue(self::GENERAL_CONTACT_EMAIL)
        ];
    }
}
