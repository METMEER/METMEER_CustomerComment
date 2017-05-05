<?php
namespace METMEER\CustomerComment\Plugin\Model\Checkout;

/**
 * Class Validation
 */
class Validation
{
	/**
	 * @var CartRepositoryInterface
	 */
	protected $cartRepository;

	/**
	 */
	public function __construct(
		\Magento\Quote\Api\CartRepositoryInterface $cartRepository
	) {
		$this->cartRepository = $cartRepository;
	}

	/**
	 * @param \Magento\Checkout\Api\PaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
	 * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformationAndPlaceOrder(
		\Magento\Checkout\Api\PaymentInformationManagementInterface $subject,
		$cartId,
		\Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
		\Magento\Quote\Api\Data\AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param \Magento\Checkout\Api\PaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
	 * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformation(
		\Magento\Checkout\Api\PaymentInformationManagementInterface $subject,
		$cartId,
		\Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
		\Magento\Quote\Api\Data\AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param int $cartId
	 * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
	 * @throws \Magento\Framework\Exception\CouldNotSaveException
	 * @return void
	 */
	protected function addCustomerCommentToQuote($cartId, \Magento\Quote\Api\Data\PaymentInterface $paymentMethod)
	{
		if (!$paymentMethod->getExtensionAttributes()) {
			return;
		}

		$customer_comment = $paymentMethod->getExtensionAttributes()->getCustomerComment();
		$quote = $this->cartRepository->getActive($cartId);

		try {
			$quote->setCustomerComment($customer_comment);
			$quote->save();
		}
		catch (Exception $e) {
			throw new \Magento\Framework\Exception\CouldNotSaveException(
				__('Error saving customer comment.')
			);
		}
	}

}
