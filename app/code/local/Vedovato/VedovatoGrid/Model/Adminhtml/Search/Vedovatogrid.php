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
 * Admin search model
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Model_Adminhtml_Search_Vedovatogrid extends Varien_Object
{
    /**
     * Load search results
     *
     * @access public
     * @return Vedovato_VedovatoGrid_Model_Adminhtml_Search_Vedovatogrid
     * @author Ultimate Module Creator
     */
    public function load()
    {
        $arr = array();
        if (!$this->hasStart() || !$this->hasLimit() || !$this->hasQuery()) {
            $this->setResults($arr);
            return $this;
        }
        $collection = Mage::getResourceModel('vedovato_vedovatogrid/vedovatogrid_collection')
            ->addFieldToFilter('nome', array('like' => $this->getQuery().'%'))
            ->setCurPage($this->getStart())
            ->setPageSize($this->getLimit())
            ->load();
        foreach ($collection->getItems() as $vedovatogrid) {
            $arr[] = array(
                'id'          => 'vedovatogrid/1/'.$vedovatogrid->getId(),
                'type'        => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid'),
                'name'        => $vedovatogrid->getNome(),
                'description' => $vedovatogrid->getNome(),
                'url' => Mage::helper('adminhtml')->getUrl(
                    '*/vedovatogrid_vedovatogrid/edit',
                    array('id'=>$vedovatogrid->getId())
                ),
            );
        }
        $this->setResults($arr);
        return $this;
    }
}
