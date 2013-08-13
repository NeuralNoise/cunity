<?php
/**
 * @package     Cunity.Installation
 *
 * @copyright   Copyright (C) 2011 - 2013 Smart In Media GmbH & Co. KG. All rights reserved.
 * @license     GNU Affero General Public License; see LICENSE.txt
 * @version     2.0
 */

// Direct access not allowed
defined('_CUNITY') or die;

// Fix magic quotes
@ini_set('magic_quotes_runtime', 0);

// Set display errors on true
ini_set('display_errors', true);

// Display all errors
error_reporting(E_ALL);

/*
 * Check if a configuration file already exists,
 * then redirect to Cunity Site.
 */
if(file_exists(CUNITY_CONFIGURATION_FILE)
    && (filesize(CUNITY_CONFIGURATION_FILE) > 10)
    && !file_exists(CUNITY_INSTALLATION . '/index.php'))
{
	header('Location: ../index.php');
	exit();
}

// Import Joomla Platform
require_once CUNITY_LIBRARIES . '/import.php';

// Make sure that the Joomla Platform has been successfully loaded
if (!class_exists('JLoader'))
{
	die('Joomla Platform not loaded.');
}

// Set error handler to echo
JLog::addLogger(array('logger' => 'echo'), JLog::ALL);

