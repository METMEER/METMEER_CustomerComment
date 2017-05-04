<?php

namespace METMEER\CustomerComment\Plugin;

class SalesModelOrderPlugin
{
    /**
     * If a customer comment is found, prepend it to the customer note which is mentioned in the transactional emails.
     *
     * @param \Magento\Sales\Model\Order $subject
     * @param string $result
     * @return string
     */
    public function afterGetEmailCustomerNote(\Magento\Sales\Model\Order $subject, $result)
    {
        $customerComment = trim($subject->getData('customer_comment'));

        if ($customerComment) {
            $result = $customerComment . rtrim("\n\n" . $result);
        }

        return $result;
    }
}
