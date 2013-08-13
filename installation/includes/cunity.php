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
 * Cunity(R) Installation Application class
 *
 * @package     Cunity.Installation
 * @subpackage  Application
 * @since       2.0
 */
final class CuInInstaller extends JApplicationWeb
{
	/**
	 * The application message queue.
	 *
	 * @var    array
	 * @since  3.1
	 */
	protected $_messageQueue = array();
	
	/**
	 * Class constructor
	 * 
	 */
	public function __construct(JInput $input = null, JRegistry $config = null, JApplicationWebClient $client = null)
	{
		// Run the parent constructor
		parent::__construct($input, $config, $client);
		
		// Load and set the dispatcher
		$this->loadDispatcher();

		// Enable sessions by default.
		if (is_null($this->config->get('session')))
		{
			$this->config->set('session', true);
		}
		
		// Set the session default name.
		if (is_null($this->config->get('session_name')))
		{
			$this->config->set('session_name', 'cunity_installer');
		}
		
		// Create the session if a session name is passed.
		if ($this->config->get('session') !== false)
		{
			$this->loadSession();
		
			// Register the session with JFactory
			JFactory::$session = $this->getSession();
		}

		// Register the config to JFactory
		JFactory::$config = $this->config;

		// Register the application to JFactory
		JFactory::$application = $this;

		// Set the root in the URI based on the application name
		JUri::root(null, str_ireplace('/installation', '', JUri::base(true)));
	}
	
	/**
	 * Get the system message queue.
	 *
	 * @return  array  The system message queue.
	 */
	public function getMessageQueue()
	{
		// For empty queue, if messages exists in the session, enqueue them.
		if (!count($this->_messageQueue))
		{
			$session = JFactory::getSession();
			$sessionQueue = $session->get('application.queue');
	
			if (count($sessionQueue))
			{
				$this->_messageQueue = $sessionQueue;
				$session->set('application.queue', null);
			}
		}
	
		return $this->_messageQueue;
	}

	/**
	 * Gets the name of the current template
	 * 
	 *  @return string Name of the template
	 */
	public function getTemplate($params = false)
	{
		if ($params)
		{
			$template = new stdClass;
			$template->template = 'template';
			$template->params = new JRegistry;
			return $template;
		}

		return 'template';
	}

	/**
	 * Allows the application to load a custom or default session.
	 * 
	 * @param   JSession  $session  An optional session object. If omitted, the session is created.
	 * @return  JApplicationWeb This method is chainable.
	 */
	/**public function loadSession(JSession $session = null)
	{
		jimport('legacy.application.application');
	
		$options = array();
		$options['name'] = JApplication::getHash($this->config->get('session_name'));
	
		$session = JFactory::getSession($options);
		$session->initialise($this->input);
		$session->start();
		if (!$session->get('registry') instanceof JRegistry)
		{
			// Registry has been corrupted somehow
			$session->set('registry', new JRegistry('session'));
		}
	
		// Set the session object.
		$this->session = $session;
	
		return $this;
	}**/

	/**
	 * Method render to pushing the document buffers into template
	 * placeholders
	 * 
	 * @return void
	 */
	public function render()
	{
		// Get template file from input if set
		$file = $this->input->getCmd('tmpl', 'index');

		// Set template options
		$options = array(
				'template' => 'template',
				'file' => $file . '.php',
				'directory' => CUNITY_THEMES,
				'params' => '{}'
		);

		// Parse the document.
		$this->document->parse($options);

		// Render the document.
		$data = $this->document->render($this->get('cache_enabled'), $options);

		// Set the application output data.
		$this->setBody($data);
	}

	/**
	 * Method to run the web application
	 * 
	 * @return void
	 */
	protected function doExecute()
	{
		// Initialize the application
		//$this->initialise();

		// Dispatch the application
		$this->dispatch();
	}

	/**
	 * Method to dispatch the application
	 * 
	 * @return void
	 */
	public function dispatch()
	{
		try
		{
			// Load the document to the API
			$this->loadDocument();
		
			// Set up the params
			$document = $this->getDocument();
		
			// Register the document object with JFactory
			JFactory::$document = $document;
		
			if ($document->getType() == 'html')
			{
				// Set metadata
				$document->setTitle(JText::_('INSTALLER_PAGE_TITLE'));
			}
		
			// Define component path
			//define('JPATH_COMPONENT', CUNITY_BASE);
			//define('JPATH_COMPONENT_SITE', CUNITY_SITE);
			//define('JPATH_COMPONENT_ADMINISTRATOR', CUNITY_ADMINISTRATOR);
		
			// Execute the task.
			try
			{
				$controller = $this->fetchController($this->input->getCmd('task'));
				$contents   = $controller->execute();
			}
			catch (RuntimeException $e)
			{
				echo $e->getMessage();
				$this->close($e->getCode());
			}
		
			// If debug language is set, append its output to the contents
			if ($this->config->get('debug_lang'))
			{
				$contents .= $this->debugLanguage();
			}

			$document->setBuffer($contents, 'component');
			$document->setTitle(JText::_('INSTALLER_PAGE_TITLE'));
		}
		
		// Mop up any uncaught exceptions.
		catch (Exception $e)
		{
			echo $e->getMessage();
			$this->close($e->getCode());
		}
	}

	/**
	 * Method to get a controller object
	 * 
	 * @param   string  $task  The installation step which beeing executed
	 * @return  JController
	 * @throws  RuntimeException
	 */
	protected function fetchController($task)
	{
		// When no step is given set to 'default'
		if (is_null($task))
		{
			$task = 'default';
		}
		
		// Set the controller class name based on the step
		$class = 'CuInController' . ucfirst($task);
		
		if (class_exists($class))
		{
			return new $class;
		}
		
		// Class not found exception
		throw new RuntimeException('Class ' . $class . ' not found');
	}
}