<?php
/**
 * @package     Cunity.Installation
 *
 * @copyright   Copyright (C) 2011 - 2013 Smart In Media GmbH & Co. KG. All rights reserved.
 * @license     GNU Affero General Public License; see LICENSE.txt
 * @version     2.0
 */

defined('_CUNITY') or die;

// Get path pieces from CUNITY_BASE
$path_parts = explode(DIRECTORY_SEPARATOR, CUNITY_BASE);

// Remove last directory from $path_parts to get CUNITY_ROOT
array_pop($path_parts);

// Now create defines
define('CUNITY_ROOT',               implode(DIRECTORY_SEPARATOR, $path_parts));
define('CUNITY_SITE',               CUNITY_ROOT);
define('CUNITY_CONFIGURATION_FILE', CUNITY_ROOT . '/configuration.php');
define('CUNITY_ADMINISTRATOR',      CUNITY_ROOT . '/admin');
define('CUNITY_LIBRARIES',          CUNITY_ROOT . '/libraries');
define('CUNITY_PLUGINS',            CUNITY_ROOT . '/plugins');
define('CUNITY_INSTALLATION',       CUNITY_ROOT . '/installation');
define('CUNITY_THEMES',             CUNITY_BASE);
define('CUNITY_CACHE',              CUNITY_BASE . '/cache');
define('CUNITY_MANIFESTS',          CUNITY_ADMINISTRATOR . '/manifests');

// Defines for Joomla Platform compatibility
define('JPATH_BASE', CUNITY_BASE);