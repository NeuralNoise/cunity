<?php
/**
 * @package     Cunity.Installation
 *
 * @copyright   Copyright (C) 2011 - 2013 Smart In Media GmbH & Co. KG. All rights reserved.
 * @license     GNU Affero General Public License; see LICENSE.txt
 * @version     2.0
 */

defined('_CUNITY') or die;

/**
 * Default controller class for Cunity installer
 * 
 * @package     Cunity.Installation
 * @subpackage  Controller
 */
class CuInControllerDefault extends JControllerBase
{
	public function execute()
	{
		return '<h1> Helloworld Template</h1>';
	}
}