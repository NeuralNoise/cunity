<?php
/**
 * @package    Joomla.Installation
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_CUNITY') or die;

$doc = JFactory::getDocument();

// Add Stylesheets
//$doc->addStyleSheet('../media/jui/css/bootstrap.css');
//$doc->addStyleSheet('../media/jui/css/bootstrap-extended.css');
//$doc->addStyleSheet('../media/jui/css/bootstrap-responsive.css');
$doc->addStyleSheet('template/css/install.css');

//if ($this->direction === 'rtl')
//{
//	$doc->addStyleSheet('../media/jui/css/bootstrap-rtl.css');
//}

// Load the JavaScript behaviors
//JHtml::_('bootstrap.framework');
//JHtml::_('formbehavior.chosen', 'select');
//JHtml::_('behavior.framework', true);
//JHtml::_('behavior.keepalive');
//JHtml::_('behavior.formvalidation');
//JHtml::_('script', 'installation/template/js/installation.js', true, false, false, false);
$doc->addScriptDeclaration('template/js/install.js');
// Load the JavaScript translated messages
//JText::script('INSTL_PROCESS_BUSY');
//JText::script('INSTL_FTP_SETTINGS_CORRECT');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<jdoc:include type="head" />
	</head>
