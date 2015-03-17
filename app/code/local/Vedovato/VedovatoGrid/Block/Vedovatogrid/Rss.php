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
 * Vedovatogrid RSS block
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Vedovatogrid_Rss extends Mage_Rss_Block_Abstract
{
    /**
     * Cache tag constant for feed reviews
     *
     * @var string
     */
    const CACHE_TAG = 'block_html_vedovatogrid_vedovatogrid_rss';

    /**
     * constructor
     *
     * @access protected
     * @return void
     * @author Ultimate Module Creator
     */
    protected function _construct()
    {
        $this->setCacheTags(array(self::CACHE_TAG));
        /*
         * setting cache to save the rss for 10 minutes
         */
        $this->setCacheKey('vedovato_vedovatogrid_vedovatogrid_rss');
        $this->setCacheLifetime(600);
    }

    /**
     * toHtml method
     *
     * @access protected
     * @return string
     * @author Ultimate Module Creator
     */
    protected function _toHtml()
    {
        $url    = Mage::helper('vedovato_vedovatogrid/vedovatogrid')->getVedovatogridsUrl();
        $title  = Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrids');
        $rssObj = Mage::getModel('rss/rss');
        $data  = array(
            'title'       => $title,
            'description' => $title,
            'link'        => $url,
            'charset'     => 'UTF-8',
        );
        $rssObj->_addHeader($data);
        $collection = Mage::getModel('vedovato_vedovatogrid/vedovatogrid')->getCollection()
            ->addFieldToFilter('status', 1)
            ->addStoreFilter(Mage::app()->getStore())
            ->addFieldToFilter('in_rss', 1)
            ->setOrder('created_at');
        $collection->load();
        foreach ($collection as $item) {
            $description = '<p>';
            $description .= '<div>'.
                Mage::helper('vedovato_vedovatogrid')->__('Nome').': 
                '.$item->getNome().
                '</div>';
            $description .= '<div>'.
                Mage::helper('vedovato_vedovatogrid')->__('Telefone').': 
                '.$item->getTelefone().
                '</div>';
            $description .= '<div>'.
                Mage::helper('vedovato_vedovatogrid')->__('Descrição').': 
                '.$item->getDescricao().
                '</div>';
            $description .= '</p>';
            $data = array(
                'title'       => $item->getNome(),
                'link'        => $item->getVedovatogridUrl(),
                'description' => $description
            );
            $rssObj->_addEntry($data);
        }
        return $rssObj->createRssXml();
    }
}
