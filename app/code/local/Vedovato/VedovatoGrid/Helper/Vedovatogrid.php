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
 * Vedovatogrid helper
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Helper_Vedovatogrid extends Mage_Core_Helper_Abstract
{

    /**
     * get the url to the vedovatogrids list page
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getVedovatogridsUrl()
    {
        if ($listKey = Mage::getStoreConfig('vedovato_vedovatogrid/vedovatogrid/url_rewrite_list')) {
            return Mage::getUrl('', array('_direct'=>$listKey));
        }
        return Mage::getUrl('vedovato_vedovatogrid/vedovatogrid/index');
    }

    /**
     * check if breadcrumbs can be used
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function getUseBreadcrumbs()
    {
        return Mage::getStoreConfigFlag('vedovato_vedovatogrid/vedovatogrid/breadcrumbs');
    }

    /**
     * check if the rss for vedovatogrid is enabled
     *
     * @access public
     * @return bool
     * @author Ultimate Module Creator
     */
    public function isRssEnabled()
    {
        return  Mage::getStoreConfigFlag('rss/config/active') &&
            Mage::getStoreConfigFlag('vedovato_vedovatogrid/vedovatogrid/rss');
    }

    /**
     * get the link to the vedovatogrid rss list
     *
     * @access public
     * @return string
     * @author Ultimate Module Creator
     */
    public function getRssUrl()
    {
        return Mage::getUrl('vedovato_vedovatogrid/vedovatogrid/rss');
    }
}
