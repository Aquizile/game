<?php
//------------------------------------------------------
//  Import Categories from XML File
//------------------------------------------------------
	echo "Started " . date("d/m/y h:i:s") . PHP_EOL;

	ini_set('max_execution_time', 0);
	set_time_limit(0);
    define('MAGENTO', realpath(dirname(__FILE__)));
    require_once MAGENTO . '/app/Mage.php';
    Mage::app();
	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);

	$level1MageId = 0;
	$level2MageId = 0;
	$level3MageId = 0;
	$level4MageId = 0;
	$level5MageId = 0;
	
	$baseURL = Mage::getBaseDir();
	$xmlFile = $baseURL . "/var/tmp/Categories.xml";
	
	$fileHandle = fopen($xmlFile,'r') or die("Can't open XML file - ". $xmlFile . PHP_EOL);
	$xmlData = fread($fileHandle, filesize($xmlFile));
	fclose($fileHandle);
	
	//echo "--- Raw XML Data  ---" . PHP_EOL;
	//print_r($xmlData);
	//echo "---------------------" . PHP_EOL;
	
	$xmlParser = xml_parser_create();
	xml_parse_into_struct($xmlParser, $xmlData, $rawCategories);
	xml_parser_free($xmlParser);

	//echo "--- XML in Array  ---" . PHP_EOL;
	//print_r($rawCategories);
	//echo "---------------------" . PHP_EOL;
	
	
	echo "--- XML in Array  ---" . PHP_EOL;
	foreach ($rawCategories as $thisRecord)
	{
		if (isset($thisRecord['attributes']['LEVEL']))
		{
			echo "Adding Category: (" . $thisRecord['attributes']['LEVEL'] . ") " . $thisRecord['attributes']['NAME'] . PHP_EOL;
			_addCategory($thisRecord['attributes']['LEVEL'], $thisRecord['attributes']['NAME']);
		}
	}
	echo "---------------------" . PHP_EOL;
	
	echo "Ended ".date("d/m/y h:i:s") . PHP_EOL;
	exit();

	
	function _addCategory($_level, $_name)
	{
		global 	$level1MageId, $level2MageId, $level3MageId, $level4MageId, $level5MageId;
		
		switch ($_level)
		{
			case 1:
				$parentId = 2;
				break;
			case 2:
				$parentId = $level1MageId;
				break;
			case 3:
				$parentId = $level2MageId;
				break;
			case 4:
				$parentId = $level3MageId;
				break;
			case 5:
				$parentId = $level4MageId;
				break;
		}
		
		try 
		{
			$thiscategory = new Mage_Catalog_Model_Category();
			$thiscategory->setName($_name);
			//$thiscategory->setUrlKey('new-category');
			$thiscategory->setIsActive(1);
			$thiscategory->setDisplayMode('PRODUCTS');
			$thiscategory->setIsAnchor(1);
			
			$parentCategory = Mage::getModel('catalog/category')->load($parentId);
			$parentCategoryPath = $parentCategory->getPath();
			$thiscategory->setPath($parentCategoryPath);
			
			$thiscategory->save();
			$thisCategoryId = $thiscategory->getId();
			unset($thiscategory);
	
			switch ($_level)
			{
				case 1:
					$level1MageId = $thisCategoryId;
					break;
				case 2:
					$level2MageId = $thisCategoryId;
					break;
				case 3:
					$level3MageId = $thisCategoryId;
					break;
				case 4:
					$level4MageId = $thisCategoryId;
					break;
				case 5:
					$level5MageId = $thisCategoryId;
					break;
			}
		} 
		catch (Exception $e)
		{
			echo "ERROR: ";
			var_dump($e);
			echo "**************************";
			echo PHP_EOL;
		}
		
	}	