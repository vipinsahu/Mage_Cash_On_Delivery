<?php
/***************************************
 *** Cash On Delivery ***
 ***************************************
 *
 * @copyright   Copyright (c) 2015
 * @company     NetAttingo Technologies
 * @package     Netgo_Cod
 * @author 		NetGo
 * @dev			netattingomails@gmail.com
 *
 */
class Netgo_Cod_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * convert array to options
     *
     * @access public
     * @param $options
     * @return array
     * @author NetGo
     */
    public function convertOptions($options)
    {
        $converted = array();
        foreach ($options as $option) {
            if (isset($option['value']) && !is_array($option['value']) &&
                isset($option['label']) && !is_array($option['label'])) {
                $converted[$option['value']] = $option['label'];
            }
        }
        return $converted;
    }
	public function getConfigData()
    { 
		$configData = array();
		$configData['zip_status'] = Mage::getStoreConfig('netgo_cod/cod/zip_status');
		$configData['suc_msg'] = Mage::getStoreConfig('netgo_cod/cod/suc_msg');
		$configData['err_msg'] = Mage::getStoreConfig('netgo_cod/cod/err_msg');
		$configData['emp_msg'] = Mage::getStoreConfig('netgo_cod/cod/emp_msg'); 
        return $configData;
    }
}
