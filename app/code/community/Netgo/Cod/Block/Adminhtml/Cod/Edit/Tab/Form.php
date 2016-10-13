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
class Netgo_Cod_Block_Adminhtml_Cod_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Netgo_Cod_Block_Adminhtml_Cod_Edit_Tab_Form
     * @author NetGo
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('cod_');
        $form->setFieldNameSuffix('cod');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'cod_form',
            array('legend' => Mage::helper('netgo_cod')->__('COD'))
        );
        $fieldset->addType(
            'file',
            Mage::getConfig()->getBlockClassName('netgo_cod/adminhtml_cod_helper_file')
        );

		$item_id = $this->getRequest()->getParam('id');
		
		if($item_id != ''){
			$fieldset->addField(
				'zipcode',
				'text',
				array(
					'label' => Mage::helper('netgo_cod')->__('Zip Code'),
					'name'  => 'zipcode',  
			   )
			); 
			$fieldset->addField(
				'days',
				'text',
				array(
					'label' => Mage::helper('netgo_cod')->__('Days'),
					'name'  => 'days', 
			   )
			);
		}
		if($item_id == ''){
			$fieldset->addField(
				'csvfile',
				'file',
				array(
					'label' => Mage::helper('netgo_cod')->__('File'),
					'name'  => 'csvfile', 
			   )
			);
		}
		
		if($item_id != ''){
			$fieldset->addField(
				'status',
				'select',
				array(
					'label'  => Mage::helper('netgo_cod')->__('Status'),
					'name'   => 'status',
					'values' => array(
						array(
							'value' => 1,
							'label' => Mage::helper('netgo_cod')->__('Enabled'),
						),
						array(
							'value' => 0,
							'label' => Mage::helper('netgo_cod')->__('Disabled'),
						),
					),
				)
			);
		}else{
			$fieldset->addField(
				'days',
				'hidden',
				array(
					'label' => Mage::helper('netgo_cod')->__('Days'),
					'name'  => 'status', 
			    )
			);
		}
        $formValues = Mage::registry('current_cod')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getCodData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getCodData());
            Mage::getSingleton('adminhtml/session')->setCodData(null);
        } elseif (Mage::registry('current_cod')) {
            $formValues = array_merge($formValues, Mage::registry('current_cod')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
