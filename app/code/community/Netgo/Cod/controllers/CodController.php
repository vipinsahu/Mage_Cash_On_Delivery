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
class Netgo_Cod_CodController extends Mage_Core_Controller_Front_Action
{ 
    /**
     * view cod action
     *
     * @access public
     * @return void
     * @author NetGo
     */
    public function checkAction()
    {
		$msgData = Mage::helper('netgo_cod')->getConfigData(); 
		
		$cod = $this->getRequest()->getPost('zipcode'); 
		$codObj = Mage::getModel('netgo_cod/cod')->getCollection()->addFieldToFilter('zipcode', trim($cod));
		$codData = $codObj->getData();
		 
		if($codData[0]['zipcode'] != '' && $codData[0]['status'] != 0){
			echo '<span class="cod-suc">'.$msgData['suc_msg'];
			if($codData[0]['days'] != ''){
				echo ' within '.$codData[0]['days'].' days ';
			}
			echo '.</span>';
		}else{
			echo '<span class="cod-error">'.$msgData['err_msg'].'</span>';
		} 
    }
}
