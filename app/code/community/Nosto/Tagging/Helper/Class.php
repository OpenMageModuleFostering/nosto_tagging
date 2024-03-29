<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category  Nosto
 * @package   Nosto_Tagging
 * @author    Nosto Solutions Ltd <magento@nosto.com>
 * @copyright Copyright (c) 2013-2016 Nosto Solutions Ltd (http://www.nosto.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

require_once __DIR__ . '/../bootstrap.php';

/**
 * Helper class for loading pluggable classes.
 *
 * @category Nosto
 * @package  Nosto_Tagging
 * @author   Nosto Solutions Ltd <magento@nosto.com>
 */
class Nosto_Tagging_Helper_Class extends Mage_Core_Helper_Abstract
{
    /*
     * Loads correct / plugable class based on payment provider
     *
     * @param Mage_Sales_Model_Order $order
     *
     * @return Nosto
     */
    public function getOrderClass(Mage_Sales_Model_Order $order)
    {
        $paymentProvider = false;
        $orderClass = false;
        $payment = $order->getPayment();
        if (is_object($payment)) {
            $paymentProvider = $payment->getMethod();
        }

        if (is_string($paymentProvider)) {
            try {
                $orderClass = Mage::getModel(
                    sprintf(
                        'nosto_tagging/meta_order_%s',
                        $paymentProvider
                    )
                );
            } catch (Exception $e) {
                $orderClass = false;
            }
        }

        if ($orderClass instanceof NostoOrderInterface) {

            return $orderClass;
        } else {

            return Mage::getModel('nosto_tagging/meta_order');
        }
    }
}
