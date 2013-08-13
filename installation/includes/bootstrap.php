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

// Define base path
define('CUNITY_BASE', dirname(__DIR__));

// Import all defines
require_once __DIR__ . '/defines.php';

// Launch the Joomla! Platform
require_once __DIR__ . '/framework.php';

// Register the Installation application
JLoader::registerPrefix('CuIn', CUNITY_INSTALLATION);

// Register the application due to non-standard include
JLoader::register('CuInInstaller', __DIR__ . '/cunity.php');