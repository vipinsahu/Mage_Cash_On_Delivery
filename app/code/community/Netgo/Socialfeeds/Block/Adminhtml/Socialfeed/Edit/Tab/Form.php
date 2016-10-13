<?php
/**
 * Netgo_Socialfeeds extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Netgo
 * @package        Netgo_Socialfeeds
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Socialfeed edit form tab
 *
 * @category    Netgo
 * @package     Netgo_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Netgo_Socialfeeds_Block_Adminhtml_Socialfeed_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('socialfeed_');
        $form->setFieldNameSuffix('socialfeed');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'socialfeed_form',
            array('legend' => Mage::helper('netgo_socialfeeds')->__('Socialfeed'))
        );

        $fieldset->addField(
            'socialfeeds_status',
            'text',
            array(
                'label' => Mage::helper('netgo_socialfeeds')->__('Socialfeeds Status'),
                'name'  => 'socialfeeds_status',
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('netgo_socialfeeds')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('netgo_socialfeeds')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('netgo_socialfeeds')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('netgo_socialfeeds')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('netgo_socialfeeds')->__('Disabled'),
                    ),
                ),
            )
        );
        $formValues = Mage::registry('current_socialfeed')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getSocialfeedData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getSocialfeedData());
            Mage::getSingleton('adminhtml/session')->setSocialfeedData(null);
        } elseif (Mage::registry('current_socialfeed')) {
            $formValues = array_merge($formValues, Mage::registry('current_socialfeed')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
