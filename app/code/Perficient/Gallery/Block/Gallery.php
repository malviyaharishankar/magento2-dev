<?php
/**
 * Created by PhpStorm.
 * User: Harishankar.Malviya
 * Date: 5/6/2016
 * Time: 12:28 PM
 */

namespace Perficient\Gallery\Block;

use Magento\Framework\View\Element\Template;
use Perficient\Gallery\Model\GalleryFactory;
use Perficient\Gallery\Model\ImagesFactory;


class Gallery extends Template
{
    protected $_resultGalleryFactory;
    protected $_resultImageFactory;
    protected $_catalogSession;

    public function __construct(
        Template\Context $context,
        GalleryFactory $galleryFactory,
        ImagesFactory $imagesFactory,
        \Magento\Catalog\Model\Session $catelogSession,
        array $data)
    {
        $this->_catalogSession=$catelogSession;
        $this->_resultGalleryFactory = $galleryFactory;
        $this->_resultImageFactory = $imagesFactory;
        parent::__construct($context, $data);
    }

    public function getGalleryData($catId = null)
    {
        error_reporting(E_ALL);
        ini_set('display_errors',1);

        $category = $this->_registry->registry('current_category');
        var_dump($category);
        echo "In side function"; exit;
        //$catId = 4;
        $gallries = $this->getGallery($catId);

        $data = array();
        foreach ($gallries->getData() as $gallery) {
            $data['title'] = $gallery['gallery_code'];
            $data['images'] = $this->getImages($gallery['image_ids'])->getData();
        }
        return $data;
    }

    public function getGallery($catId = null)
    {

        $gallery = $this->_resultGalleryFactory->create()
            ->getCollection()
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('category_ids', array('in' => $catId));

        return $gallery;
    }

    public function getImages($ids)
    {
        $images = $this->_resultImageFactory->create()
            ->getCollection()
            ->addFieldToSelect('image_url')
            ->addFieldtoFilter('status', 1)
            ->addFieldToFilter('image_id', array('in' => explode(',', $ids)));
        return $images;

    }

}
