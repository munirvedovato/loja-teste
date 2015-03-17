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
 * Vedovatogrid front contrller
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_VedovatogridController extends Mage_Core_Controller_Front_Action
{

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
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if (Mage::helper('vedovato_vedovatogrid/vedovatogrid')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Home'),
                        'link'  => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'vedovatogrids',
                    array(
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrids'),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', Mage::helper('vedovato_vedovatogrid/vedovatogrid')->getVedovatogridsUrl());
        }
        if ($headBlock) {
            $headBlock->setTitle(Mage::getStoreConfig('vedovato_vedovatogrid/vedovatogrid/meta_title'));
            $headBlock->setKeywords(Mage::getStoreConfig('vedovato_vedovatogrid/vedovatogrid/meta_keywords'));
            $headBlock->setDescription(Mage::getStoreConfig('vedovato_vedovatogrid/vedovatogrid/meta_description'));
        }
        $this->renderLayout();
    }

    /**
     * init Vedovatogrid
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Model_Vedovatogrid
     * @author Ultimate Module Creator
     */
    protected function _initVedovatogrid()
    {
        $vedovatogridId   = $this->getRequest()->getParam('id', 0);
        $vedovatogrid     = Mage::getModel('vedovato_vedovatogrid/vedovatogrid')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($vedovatogridId);
        if (!$vedovatogrid->getId()) {
            return false;
        } elseif (!$vedovatogrid->getStatus()) {
            return false;
        }
        return $vedovatogrid;
    }

    /**
     * view vedovatogrid action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function viewAction()
    {
        $vedovatogrid = $this->_initVedovatogrid();
        if (!$vedovatogrid) {
            $this->_forward('no-route');
            return;
        }
        Mage::register('current_vedovatogrid', $vedovatogrid);
        $this->loadLayout();
        $this->_initLayoutMessages('catalog/session');
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('checkout/session');
        if ($root = $this->getLayout()->getBlock('root')) {
            $root->addBodyClass('vedovatogrid-vedovatogrid vedovatogrid-vedovatogrid' . $vedovatogrid->getId());
        }
        if (Mage::helper('vedovato_vedovatogrid/vedovatogrid')->getUseBreadcrumbs()) {
            if ($breadcrumbBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbBlock->addCrumb(
                    'home',
                    array(
                        'label'    => Mage::helper('vedovato_vedovatogrid')->__('Home'),
                        'link'     => Mage::getUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'vedovatogrids',
                    array(
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrids'),
                        'link'  => Mage::helper('vedovato_vedovatogrid/vedovatogrid')->getVedovatogridsUrl(),
                    )
                );
                $breadcrumbBlock->addCrumb(
                    'vedovatogrid',
                    array(
                        'label' => $vedovatogrid->getNome(),
                        'link'  => '',
                    )
                );
            }
        }
        $headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->addLinkRel('canonical', $vedovatogrid->getVedovatogridUrl());
        }
        if ($headBlock) {
            if ($vedovatogrid->getMetaTitle()) {
                $headBlock->setTitle($vedovatogrid->getMetaTitle());
            } else {
                $headBlock->setTitle($vedovatogrid->getNome());
            }
            $headBlock->setKeywords($vedovatogrid->getMetaKeywords());
            $headBlock->setDescription($vedovatogrid->getMetaDescription());
        }
        $this->renderLayout();
    }

    /**
     * vedovatogrids rss list action
     *
     * @access public
     * @return void
     * @author Ultimate Module Creator
     */
    public function rssAction()
    {
        if (Mage::helper('vedovato_vedovatogrid/vedovatogrid')->isRssEnabled()) {
            $this->getResponse()->setHeader('Content-type', 'text/xml; charset=UTF-8');
            $this->loadLayout(false);
            $this->renderLayout();
        } else {
            $this->getResponse()->setHeader('HTTP/1.1', '404 Not Found');
            $this->getResponse()->setHeader('Status', '404 File not found');
            $this->_forward('nofeed', 'index', 'rss');
        }
    }

    /**
     * Submit new comment action
     * @access public
     * @author Ultimate Module Creator
     */
    public function commentpostAction()
    {
        $data   = $this->getRequest()->getPost();
        $vedovatogrid = $this->_initVedovatogrid();
        $session    = Mage::getSingleton('core/session');
        if ($vedovatogrid) {
            if ($vedovatogrid->getAllowComments()) {
                if ((Mage::getSingleton('customer/session')->isLoggedIn() ||
                    Mage::getStoreConfigFlag('vedovato_vedovatogrid/vedovatogrid/allow_guest_comment'))) {
                    $comment  = Mage::getModel('vedovato_vedovatogrid/vedovatogrid_comment')->setData($data);
                    $validate = $comment->validate();
                    if ($validate === true) {
                        try {
                            $comment->setVedovatogridId($vedovatogrid->getId())
                                ->setStatus(Vedovato_VedovatoGrid_Model_Vedovatogrid_Comment::STATUS_PENDING)
                                ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                                ->setStores(array(Mage::app()->getStore()->getId()))
                                ->save();
                            $session->addSuccess($this->__('Your comment has been accepted for moderation.'));
                        } catch (Exception $e) {
                            $session->setVedovatogridCommentData($data);
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    } else {
                        $session->setVedovatogridCommentData($data);
                        if (is_array($validate)) {
                            foreach ($validate as $errorMessage) {
                                $session->addError($errorMessage);
                            }
                        } else {
                            $session->addError($this->__('Unable to post the comment.'));
                        }
                    }
                } else {
                    $session->addError($this->__('Guest comments are not allowed'));
                }
            } else {
                $session->addError($this->__('This vedovatogrid does not allow comments'));
            }
        }
        $this->_redirectReferer();
    }
}
