<?php
define('MAGENTO', realpath(dirname(__FILE__)));
require_once MAGENTO . '/app/Mage.php';
Mage::app();

$all_category_paths = array();

$categories = Mage::getResourceModel('catalog/category_collection')->addAttributeToSelect('name')->load(3955)->getItems();


foreach( $categories as $_category){
    $path = array_slice(explode('/', $_category->getPath()),2);//remove array_slice if you want to include root category in path
    foreach($path as $_k => $_v){
        $path[$_k]=str_replace('/','\/', $categories[$_v]->getName());
    }
    $all_category_paths[$_category->getId()]= strtolower(join('/',$path));
    echo $_category->getId()." - ". join('/',$path)."\n";
}
