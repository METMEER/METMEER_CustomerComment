<?php
namespace METMEER\CustomerComment\Plugin\Model\Checkout;

/**
 * Class GuestValidation
 */
class GuestValidation
{
	/**
	 * @var CartRepositoryInterface
	 */
	protected $cartRepository;

	/**
	 * @var \Magento\Quote\Model\QuoteIdMaskFactory
	 */
	protected $quoteIdMaskFactory;

	/**
	 */
	public function __construct(
		\Magento\Quote\Api\CartRepositoryInterface $cartRepository,
		\Magento\Quote\Model\QuoteIdMaskFactory $quoteIdMaskFactory
	) {
		$this->cartRepository = $cartRepository;
		$this->quoteIdMaskFactory = $quoteIdMaskFactory;
	}

	/**
	 * @param \Magento\Checkout\Api\GuestPaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
	 * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformationAndPlaceOrder(
		\Magento\Checkout\Api\GuestPaymentInformationManagementInterface $subject,
		$cartId,
		$email,
		\Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
		\Magento\Quote\Api\Data\AddressInterface $billingAddress = null
	) {
		$this->addCustomerCommentToQuote($cartId, $paymentMethod);
	}

	/**
	 * @param \Magento\Checkout\Api\GuestPaymentInformationManagementInterface $subject
	 * @param int $cartId
	 * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
	 * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
	 * @return void
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 */
	public function beforeSavePaymentInformation(
		\Magento\Checkout\Api\GuestPaymentInformationManagementInterface $subject,
		$cartId,
		$email,
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
		$quoteId = $this->quoteIdMaskFactory->create()->load($cartId, 'masked_id')->getQuoteId();
		$quote = $this->cartRepository->getActive($quoteId);

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
