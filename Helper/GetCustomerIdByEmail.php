<?php
declare(strict_types=1);

/**
 * Class GetCustomerIdByEmail
 * @package Val\AdvancedContactUs\Helper
 */

namespace Val\AdvancedContactUs\Helper;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class GetCustomerIdByEmail
{
    /**
     * @var Session
     */
    protected $customerSession;
    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    /**
     * GetCustomerIdByEmail constructor.
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepositoryInterface
     */
    public function __construct(
        Session $customerSession,
        CustomerRepositoryInterface $customerRepositoryInterface
    ) {
        $this->customerSession = $customerSession;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }

    /**
     * Get customer id by email or by session
     *
     * @param string $email
     * @return int|null
     */
    public function getCustomerId(string $email)
    {
        $customerId = $this->customerSession->getCustomerId();
        if (!$customerId) {
            try {
                $customer = $this->customerRepositoryInterface->get($email);
                $customerId = $customer->getId();
            } catch (NoSuchEntityException $e) {
                $customerId = null;
            } catch (LocalizedException $e) {
                $customerId = null;
            }
        }
        return $customerId;
    }
}
