<?php
class View {
	 
	protected $variables = array();
	protected $_controller;
	protected $_action;
	 
	function __construct($controller,$action) {
		$this->_controller = $controller;
		$this->_action = $action;
	}

	/** Set Variables **/
	function set($name,$value) {
		$this->variables[$name] = $value;
	}

	/** Display Template **/	 
	function render() {
		extract($this->variables);
		 
		if (file_exists(VWPATH . $this->_controller . DS . 'header.php')) {
			include (VWPATH . $this->_controller . DS . 'header.php');
		} else {
			include (VWPATH . 'header.php');
		}

		include (VWPATH . $this->_controller . DS . $this->_action . '.php');
		 
		if (file_exists(VWPATH . $this->_controller . DS . 'footer.php')) {
			include (VWPATH . $this->_controller . DS . 'footer.php');
		} else {
			include (VWPATH . 'footer.php');
		}
	}

}