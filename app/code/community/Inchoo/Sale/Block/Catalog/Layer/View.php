<?php
/**
* Inchoo
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@magentocommerce.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Please do not edit or add to this file if you wish to upgrade
* Magento or this extension to newer versions in the future.
** Inchoo *give their best to conform to
* "non-obtrusive, best Magento practices" style of coding.
* However,* Inchoo *guarantee functional accuracy of
* specific extension behavior. Additionally we take no responsibility
* for any possible issue(s) resulting from extension usage.
* We reserve the full right not to provide any kind of support for our free extensions.
* Thank you for your understanding.
*
* @category Inchoo
* @package Sale
* @author Marko Martinović <marko.martinovic@inchoo.net>
* @copyright Copyright (c) Inchoo (http://inchoo.net/)
* @license http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*/

class Inchoo_Sale_Block_Catalog_Layer_View extends Mage_Catalog_Block_Layer_View
{
    const SALE_FILTER_POSITION = 2;

    /**
     * State block name
     *
     * @var string
     */
    protected $_saleBlockName;

    protected function _initBlocks()
    {
        parent::_initBlocks();

        $this->_saleBlockName = 'inchoo_sale/catalog_layer_filter_sale';
    }

    /**
     * Prepare child blocks
     *
     * @return Mage_Catalog_Block_Layer_View
     */
    protected function _prepareLayout()
    {
        $saleBlock = $this->getLayout()->createBlock($this->_saleBlockName)
                ->setLayer($this->getLayer())
                ->init();

        $this->setChild('sale_filter', $saleBlock);

        return parent::_prepareLayout();
    }

    public function getFilters()
    {
        $filters = parent::getFilters();

        if (($saleFilter = $this->_getSaleFilter())) {
            // Insert sale filter to the self::SALE_FILTER_POSITION position
            $filters = array_merge(
                array_slice(
                    $filters,
                    0,
                    self::SALE_FILTER_POSITION - 1
                ),
                array($saleFilter),
                array_slice(
                    $filters,
                    self::SALE_FILTER_POSITION - 1,
                    count($filters) - 1
                )
            );
        }

        return $filters;
    }

    /**
     * Get sale filter block
     *
     * @return Mage_Catalog_Block_Layer_Filter_Category
     */
    protected function _getSaleFilter()
    {
        return $this->getChild('sale_filter');
    }

}
