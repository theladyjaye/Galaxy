<?php
require '../../system/Configuration.php';
require '../../../phorm/database/couchdb/CouchDB.php';

$type = strtr($_GET['format'], array(" " =>""));
$type = filter_var($type, FILTER_SANITIZE_STRING);

$result = result();
switch($type)
{
	case 'xml':
		out_Xml($result);
		break;
	case 'json':
		out_Json($result);
		break;
	default:
		out_Xml($result);
		break;
}

function result()
{
	$options = array('database' => Configuration::kDatabaseName);
	$db      = new CouchDB($options);
	return $db->view('categories/all');
}

function out_Xml($result)
{
	header('Content-Type:text/xml');
	$writer = new XMLWriter();
	$writer->openURI('php://output'); 
	$writer->startDocument( '1.0' , 'UTF-8' );
	$writer->startElement('Categories');
	
	$parent_id = null;
	foreach($result as $category)
	{
		if($category['parent'] == null && $category['_id'] != $parent_id)
		{
			if($parent_id){
				$writer->endElement(); // Children
				$writer->endElement(); // Category
			}
			$parent_id = $category['_id'];
			$writer->startElement('Category');
			$writer->writeElement('label', $category['label']);
			$writer->writeElement('short_label', $category['short_label']);
			$writer->startElement('Children');
		}
		else
		{
			$writer->startElement('Category');
			$writer->writeElement('label', $category['label']);
			$writer->writeElement('short_label', $category['short_label']);
			$writer->endElement();
		}
		
	}
	
	$writer->endElement(); // Children 
	$writer->endElement(); // Category
	$writer->endElement(); // Categories
	$writer->endDocument();
}

function out_Json($result)
{
	header('Content-Type:application/json');
	$json = array();
	
	$parent_id    = null;
	$parent_label = null;
	$currentChild = null;
	$key = 0;
	
	foreach($result as $category)
	{
		if($category['parent'] == null && $category['_id'] != $parent_id)
		{
			if($parent_id){
				++$key;
			}
			$parent_id    = $category['_id'];
			$parent_label = $category['label'];

			$json['categories'][$key]['label'] = $parent_label;
			$json['categories'][$key]['short_label'] = $category['short_label'];
			
		}
		else
		{
			$currentChild = array();
			$currentChild['label']       = $category['label'];
			$currentChild['short_label'] = $category['short_label'];
			$json['categories'][$key]['children'][] = $currentChild;
		}
	}
	
	echo json_encode($json);
}




foreach($result as $category)
{
	
}
?>