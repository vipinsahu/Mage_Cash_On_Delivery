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
 * Socialfeed admin controller
 *
 * @category    Netgo
 * @package     Netgo_Socialfeeds
 * @author      Ultimate Module Creator
 */
class Netgo_Socialfeeds_Adminhtml_Socialfeeds_SocialfeedController extends Netgo_Socialfeeds_Controller_Adminhtml_Socialfeeds
{
    /**
     * init the socialfeed
     *
     * @access protected
     * @return Netgo_Socialfeeds_Model_Socialfeed
     */
    protected function _initSocialfeed()
    {
        $socialfeedId  = (int) $this->getRequest()->getParam('id');
        $socialfeed    = Mage::getModel('netgo_socialfeeds/socialfeed');
        if ($socialfeedId) {
            $socialfeed->load($socialfeedId);
        }
        Mage::register('current_socialfeed', $socialfeed);
        return $socialfeed;
    }

    /**
     * default action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function indexAction()
    {
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_socialfeeds')->__('Social Feeds'))
             ->_title(Mage::helper('netgo_socialfeeds')->__('Socialfeeds'));
        $this->renderLayout();
    }

    /**
     * grid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function gridAction()
    {
        $this->loadLayout()->renderLayout();
    }

    /**
     * edit socialfeed - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $socialfeedId    = $this->getRequest()->getParam('id');
        $socialfeed      = $this->_initSocialfeed();
        if ($socialfeedId && !$socialfeed->getId()) {
            $this->_getSession()->addError(
                Mage::helper('netgo_socialfeeds')->__('This socialfeed no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getSocialfeedData(true);
        if (!empty($data)) {
            $socialfeed->setData($data);
        }
        Mage::register('socialfeed_data', $socialfeed);
        $this->loadLayout();
        $this->_title(Mage::helper('netgo_socialfeeds')->__('Social Feeds'))
             ->_title(Mage::helper('netgo_socialfeeds')->__('Socialfeeds'));
        if ($socialfeed->getId()) {
            $this->_title($socialfeed->getSocialfeedsStatus());
        } else {
            $this->_title(Mage::helper('netgo_socialfeeds')->__('Add socialfeed'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new socialfeed action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * save socialfeed - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('socialfeed')) {
            try {
                $socialfeed = $this->_initSocialfeed();
                $socialfeed->addData($data);
                $socialfeed->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_socialfeeds')->__('Socialfeed was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $socialfeed->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setSocialfeedData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_socialfeeds')->__('There was a problem saving the socialfeed.')
                );
                Mage::getSingleton('adminhtml/session')->setSocialfeedData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('netgo_socialfeeds')->__('Unable to find socialfeed to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete socialfeed - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $socialfeed = Mage::getModel('netgo_socialfeeds/socialfeed');
                $socialfeed->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_socialfeeds')->__('Socialfeed was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_socialfeeds')->__('There was an error deleting socialfeed.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('netgo_socialfeeds')->__('Could not find socialfeed to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete socialfeed - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $socialfeedIds = $this->getRequest()->getParam('socialfeed');
        if (!is_array($socialfeedIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('netgo_socialfeeds')->__('Please select socialfeeds to delete.')
            );
        } else {
            try {
                foreach ($socialfeedIds as $socialfeedId) {
                    $socialfeed = Mage::getModel('netgo_socialfeeds/socialfeed');
                    $socialfeed->setId($socialfeedId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('netgo_socialfeeds')->__('Total of %d socialfeeds were successfully deleted.', count($socialfeedIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_socialfeeds')->__('There was an error deleting socialfeeds.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * mass status change - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massStatusAction()
    {
        $socialfeedIds = $this->getRequest()->getParam('socialfeed');
        if (!is_array($socialfeedIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('netgo_socialfeeds')->__('Please select socialfeeds.')
            );
        } else {
            try {
                foreach ($socialfeedIds as $socialfeedId) {
                $socialfeed = Mage::getSingleton('netgo_socialfeeds/socialfeed')->load($socialfeedId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d socialfeeds were successfully updated.', count($socialfeedIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('netgo_socialfeeds')->__('There was an error updating socialfeeds.')
                );
                Mage::logException($e);
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * export as csv - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportCsvAction()
    {
        $fileName   = 'socialfeed.csv';
        $content    = $this->getLayout()->createBlock('netgo_socialfeeds/adminhtml_socialfeed_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as MsExcel - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportExcelAction()
    {
        $fileName   = 'socialfeed.xls';
        $content    = $this->getLayout()->createBlock('netgo_socialfeeds/adminhtml_socialfeed_grid')
            ->getExcelFile();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * export as xml - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function exportXmlAction()
    {
        $fileName   = 'socialfeed.xml';
        $content    = $this->getLayout()->createBlock('netgo_socialfeeds/adminhtml_socialfeed_grid')
            ->getXml();
        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Check if admin has permissions to visit related pages
     *
     * @access protected
     * @return boolean
     * @author Ultimate Module Creator
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('netgo_socialfeeds/socialfeed');
    }
}
