<?php
//
// iTop module definition file
//

SetupWebPage::AddModule(
	__FILE__, // Path to the current file, all other file names are relative to the directory containing this file
	'sample-new-attribute-type/1.0.0',
	array(
		// Identification
		//
		'label' => 'Sample: New attribute type',
		'category' => 'business',

		// Setup
		//
		'dependencies' => array(
			'itop-structure/3.1.0',
			'itop-portal/3.1.0',
			'itop-request-mgmt/3.1.0',
		),
		'mandatory' => false,
		'visible' => true,

		// Components
		//
		'datamodel' => array(
			'vendor/autoload.php',
			// Attributes definitions must be explicitly loaded (and not have a namespace)
			'src/AttributeDefinition/AttributeStringCustomField.php',
			'src/AttributeDefinition/AttributeStringMaxLength.php',
		),
		'webservice' => array(
			
		),
		'data.struct' => array(
			// add your 'structure' definition XML files here,
		),
		'data.sample' => array(
			// add your sample data XML files here,
		),
		
		// Documentation
		//
		'doc.manual_setup' => '', // hyperlink to manual setup documentation, if any
		'doc.more_information' => '', // hyperlink to more information, if any 

		// Default settings
		//
		'settings' => array(
			// Module specific settings go here, if any
		),
	)
);


?>
