<?php
    /**
     * Hello Rewrite Product ListProduct Block
     *
     * @category    Webkul
     * @package     Webkul_Hello
     * @author      Webkul Software Private Limited
     *
     */
    namespace Perficient\Overriding\Block\Rewrite\Product;

    class ListProduct extends \Magento\Catalog\Block\Product\ListProduct
    {
        /**
         * Retrieve loaded category collection
         *
         * @return AbstractCollection
         */
        protected function _getProductCollection()
        {
            echo "This page is overrieded";
            if ($this->_productCollection === null) {
                $layer = $this->getLayer();
                /* @var $layer \Magento\Catalog\Model\Layer */
                if ($this->getShowRootCategory()) {
                    $this->setCategoryId($this->_storeManager->getStore()->getRootCategoryId());
                }

                // if this is a product view page
                if ($this->_coreRegistry->registry('product')) {
                    // get collection of categories this product is associated with
                    $categories = $this->_coreRegistry->registry('product')
                        ->getCategoryCollection()->setPage(1, 1)
                        ->load();
                    // if the product is associated with any category
                    if ($categories->count()) {
                        // show products from this category
                        $this->setCategoryId(current($categories->getIterator()));
                    }
                }

                $origCategory = null;
                if ($this->getCategoryId()) {
                    try {
                        $category = $this->categoryRepository->get($this->getCategoryId());
                    } catch (NoSuchEntityException $e) {
                        $category = null;
                    }

                    if ($category) {
                        $origCategory = $layer->getCurrentCategory();
                        $layer->setCurrentCategory($category);
                    }
                }
                $this->_productCollection = $layer->getProductCollection();

                $this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

                if ($origCategory) {
                    $layer->setCurrentCategory($origCategory);
                }
            }

            return $this->_productCollection;
        }
    }