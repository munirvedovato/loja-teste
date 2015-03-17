<?php
/**
 * Vedovato_VedovatoGrid extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Vedovato
 * @package        Vedovato_VedovatoGrid
 * @copyright      Copyright (c) 2015
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Vedovatogrid admin controller
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Adminhtml_Vedovatogrid_VedovatogridController extends Vedovato_VedovatoGrid_Controller_Adminhtml_VedovatoGrid
{
    /**
     * init the vedovatogrid
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Model_Vedovatogrid
     */
    protected function _initVedovatogrid()
    {
        $vedovatogridId  = (int) $this->getRequest()->getParam('id');
        $vedovatogrid    = Mage::getModel('vedovato_vedovatogrid/vedovatogrid');
        if ($vedovatogridId) {
            $vedovatogrid->load($vedovatogridId);
        }
        Mage::register('current_vedovatogrid', $vedovatogrid);
        return $vedovatogrid;
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
        $this->_title(Mage::helper('vedovato_vedovatogrid')->__('Vedovato'))
             ->_title(Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrids'));
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
     * edit vedovatogrid - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function editAction()
    {
        $vedovatogridId    = $this->getRequest()->getParam('id');
        $vedovatogrid      = $this->_initVedovatogrid();
        if ($vedovatogridId && !$vedovatogrid->getId()) {
            $this->_getSession()->addError(
                Mage::helper('vedovato_vedovatogrid')->__('This vedovatogrid no longer exists.')
            );
            $this->_redirect('*/*/');
            return;
        }
        $data = Mage::getSingleton('adminhtml/session')->getVedovatogridData(true);
        if (!empty($data)) {
            $vedovatogrid->setData($data);
        }
        Mage::register('vedovatogrid_data', $vedovatogrid);
        $this->loadLayout();
        $this->_title(Mage::helper('vedovato_vedovatogrid')->__('Vedovato'))
             ->_title(Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrids'));
        if ($vedovatogrid->getId()) {
            $this->_title($vedovatogrid->getNome());
        } else {
            $this->_title(Mage::helper('vedovato_vedovatogrid')->__('Add vedovatogrid'));
        }
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
        $this->renderLayout();
    }

    /**
     * new vedovatogrid action
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
     * save vedovatogrid - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost('vedovatogrid')) {
            try {
                $vedovatogrid = $this->_initVedovatogrid();
                $vedovatogrid->addData($data);
                $vedovatogrid->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $vedovatogrid->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setVedovatogridData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            } catch (Exception $e) {
                Mage::logException($e);
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_vedovatogrid')->__('There was a problem saving the vedovatogrid.')
                );
                Mage::getSingleton('adminhtml/session')->setVedovatogridData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('vedovato_vedovatogrid')->__('Unable to find vedovatogrid to save.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * delete vedovatogrid - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function deleteAction()
    {
        if ( $this->getRequest()->getParam('id') > 0) {
            try {
                $vedovatogrid = Mage::getModel('vedovato_vedovatogrid/vedovatogrid');
                $vedovatogrid->setId($this->getRequest()->getParam('id'))->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid was successfully deleted.')
                );
                $this->_redirect('*/*/');
                return;
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_vedovatogrid')->__('There was an error deleting vedovatogrid.')
                );
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                Mage::logException($e);
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(
            Mage::helper('vedovato_vedovatogrid')->__('Could not find vedovatogrid to delete.')
        );
        $this->_redirect('*/*/');
    }

    /**
     * mass delete vedovatogrid - action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function massDeleteAction()
    {
        $vedovatogridIds = $this->getRequest()->getParam('vedovatogrid');
        if (!is_array($vedovatogridIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('vedovato_vedovatogrid')->__('Please select vedovatogrids to delete.')
            );
        } else {
            try {
                foreach ($vedovatogridIds as $vedovatogridId) {
                    $vedovatogrid = Mage::getModel('vedovato_vedovatogrid/vedovatogrid');
                    $vedovatogrid->setId($vedovatogridId)->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('vedovato_vedovatogrid')->__('Total of %d vedovatogrids were successfully deleted.', count($vedovatogridIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_vedovatogrid')->__('There was an error deleting vedovatogrids.')
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
        $vedovatogridIds = $this->getRequest()->getParam('vedovatogrid');
        if (!is_array($vedovatogridIds)) {
            Mage::getSingleton('adminhtml/session')->addError(
                Mage::helper('vedovato_vedovatogrid')->__('Please select vedovatogrids.')
            );
        } else {
            try {
                foreach ($vedovatogridIds as $vedovatogridId) {
                $vedovatogrid = Mage::getSingleton('vedovato_vedovatogrid/vedovatogrid')->load($vedovatogridId)
                            ->setStatus($this->getRequest()->getParam('status'))
                            ->setIsMassupdate(true)
                            ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d vedovatogrids were successfully updated.', count($vedovatogridIds))
                );
            } catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('vedovato_vedovatogrid')->__('There was an error updating vedovatogrids.')
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
        $fileName   = 'vedovatogrid.csv';
        $content    = $this->getLayout()->createBlock('vedovato_vedovatogrid/adminhtml_vedovatogrid_grid')
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
        $fileName   = 'vedovatogrid.xls';
        $content    = $this->getLayout()->createBlock('vedovato_vedovatogrid/adminhtml_vedovatogrid_grid')
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
        $fileName   = 'vedovatogrid.xml';
        $content    = $this->getLayout()->createBlock('vedovato_vedovatogrid/adminhtml_vedovatogrid_grid')
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
        return Mage::getSingleton('admin/session')->isAllowed('vedovato_vedovatogrid/vedovatogrid');
    }
}
