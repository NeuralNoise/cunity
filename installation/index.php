<?php
/**
 * @package     Cunity.Installation
 *
 * @copyright   Copyright (C) 2011 - 2013 Smart In Media GmbH & Co. KG. All rights reserved.
 * @license     GNU Affero General Public License; see LICENSE.txt
 * @version     2.0
 */

// Check needed PHP version - min. 5.3.1
if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
	die('Your host needs to use PHP 5.3.1 or higher to run Cunity&reg;');
}

// Constant that is checked in included files to prevent direct access.
define('_CUNITY', 1);

// Bootstrap the application
require_once __DIR__ . '/includes/bootstrap.php';

// Create application instance
$app = JApplicationWeb::getInstance('CuInInstaller');
	
// Execute the application
$app->execute();