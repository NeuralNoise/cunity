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
	/**
	 * Execute the controller
	 * 
	 * @see JController::execute()
	 */
	public function execute()
	{
		// Get the application
		$app = $this->getApplication();
		
		// Get the document object
		$doc = $app->getDocument();
		
		//
		if (file_exists(CUNITY_CONFIGURATION_FILE) 
		 && filesize(CUNITY_CONFIGURATION_FILE) > 10
		 && fil_exists(CUNITY_INSTALLATION . '/index.php'))
		{
			$default_view = "remove";
		}
		else
		{
			$default_view = "default";
		}
		
		$vName   = $this->input->getWord('view', $default_view);
		$vFormat = $doc->getType();
		$lName   = $this->input->getWord('layout', 'default');
		
		if (strcmp($vName, $default_view) == 0)
		{
			$this->input->set('view', $default_view);
		}
		
		switch ($vName)
		{
			case 'preinstall':
				$model        = new CuInModelSetup;
				$sufficient   = $model->getPhpOptionsSufficient();
				$checkOptions = false;
				$options = $model->getOptions();
		
				if ($sufficient)
				{
					$app->redirect('index.php');
				}
		
				break;
		
			case 'languages':
			case 'defaultlanguage':
				$model = new CuInModelLanguages;
				$checkOptions = false;
				$options = array();
				break;
		
			default:
				$model        = new CuInModelSetup;
				$sufficient   = $model->getPhpOptionsSufficient();
				$checkOptions = true;
				$options = $model->getOptions();
		
				if (!$sufficient)
				{
					$app->redirect('index.php?view=preinstall');
				}
		
				break;
		}
		// Register the layout paths for the view
		$paths = new SplPriorityQueue;
		$paths->insert(CUNITY_INSTALLATION . '/view/' . $vName . '/tmpl', 'normal');
		
		$vClass = 'CuInView' . ucfirst($vName) . ucfirst($vFormat);
		
		if (!class_exists($vClass))
		{
			$vClass = 'CuInViewDefault';
		}
		
		/* @var JViewHtml $view */
		$view = new $vClass($model, $paths);
		$view->setLayout($lName);
		
		// Render our view and return it to the application.
		return $view->render();
	}
}