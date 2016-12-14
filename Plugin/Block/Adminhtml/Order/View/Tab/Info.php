<?php
namespace METMEER\CustomerComment\Plugin\Block\Adminhtml\Order\View\Tab;

class Info
{
	/**
	 * @var \Magento\Framework\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \Magento\Framework\View\Element\BlockFactory $objectManager
	 */
	public function __construct(\Magento\Framework\View\Element\BlockFactory $blockFactory)
	{
		$this->_blockFactory = $blockFactory;
	}

	public function afterGetGiftOptionsHtml(\Magento\Sales\Block\Adminhtml\Order\View\Tab\Info $subject, $html)
	{
		$order = $subject->getOrder();

		$block = $this->_blockFactory
			->createBlock('Magento\Framework\View\Element\Template')
			->setTemplate('METMEER_CustomerComment::customer_comment.phtml')
		;
//		$block = $this->objectManager->create('Magento\Framework\View\Element\Template');
//		$block->setCustomerComment($order->getCustomerComment());
//		$block->setTemplate('METMEER_CustomerComment::customer_comment.phtml');

		return $block->toHtml() . 'test' . $html;
	}
}