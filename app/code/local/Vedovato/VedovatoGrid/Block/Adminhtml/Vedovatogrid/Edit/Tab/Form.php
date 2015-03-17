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
 * Vedovatogrid edit form tab
 *
 * @category    Vedovato
 * @package     Vedovato_VedovatoGrid
 * @author      Ultimate Module Creator
 */
class Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * prepare the form
     *
     * @access protected
     * @return Vedovato_VedovatoGrid_Block_Adminhtml_Vedovatogrid_Edit_Tab_Form
     * @author Ultimate Module Creator
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('vedovatogrid_');
        $form->setFieldNameSuffix('vedovatogrid');
        $this->setForm($form);
        $fieldset = $form->addFieldset(
            'vedovatogrid_form',
            array('legend' => Mage::helper('vedovato_vedovatogrid')->__('Vedovatogrid'))
        );
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

        $fieldset->addField(
            'nome',
            'text',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Nome'),
                'name'  => 'nome',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'telefone',
            'text',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Telefone'),
                'name'  => 'telefone',
            'required'  => true,
            'class' => 'required-entry',

           )
        );

        $fieldset->addField(
            'descricao',
            'editor',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Descrição'),
                'name'  => 'descricao',
            'config' => $wysiwygConfig,
            'required'  => true,
            'class' => 'required-entry',

           )
        );
        $fieldset->addField(
            'url_key',
            'text',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Url key'),
                'name'  => 'url_key',
                'note'  => Mage::helper('vedovato_vedovatogrid')->__('Relative to Website Base URL')
            )
        );
        $fieldset->addField(
            'status',
            'select',
            array(
                'label'  => Mage::helper('vedovato_vedovatogrid')->__('Status'),
                'name'   => 'status',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Enabled'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Disabled'),
                    ),
                ),
            )
        );
        $fieldset->addField(
            'in_rss',
            'select',
            array(
                'label'  => Mage::helper('vedovato_vedovatogrid')->__('Show in rss'),
                'name'   => 'in_rss',
                'values' => array(
                    array(
                        'value' => 1,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('Yes'),
                    ),
                    array(
                        'value' => 0,
                        'label' => Mage::helper('vedovato_vedovatogrid')->__('No'),
                    ),
                ),
            )
        );
        if (Mage::app()->isSingleStoreMode()) {
            $fieldset->addField(
                'store_id',
                'hidden',
                array(
                    'name'      => 'stores[]',
                    'value'     => Mage::app()->getStore(true)->getId()
                )
            );
            Mage::registry('current_vedovatogrid')->setStoreId(Mage::app()->getStore(true)->getId());
        }
        $fieldset->addField(
            'allow_comment',
            'select',
            array(
                'label' => Mage::helper('vedovato_vedovatogrid')->__('Allow Comments'),
                'name'  => 'allow_comment',
                'values'=> Mage::getModel('vedovato_vedovatogrid/adminhtml_source_yesnodefault')->toOptionArray()
            )
        );
        $formValues = Mage::registry('current_vedovatogrid')->getDefaultValues();
        if (!is_array($formValues)) {
            $formValues = array();
        }
        if (Mage::getSingleton('adminhtml/session')->getVedovatogridData()) {
            $formValues = array_merge($formValues, Mage::getSingleton('adminhtml/session')->getVedovatogridData());
            Mage::getSingleton('adminhtml/session')->setVedovatogridData(null);
        } elseif (Mage::registry('current_vedovatogrid')) {
            $formValues = array_merge($formValues, Mage::registry('current_vedovatogrid')->getData());
        }
        $form->setValues($formValues);
        return parent::_prepareForm();
    }
}
