<?php

class PDOCore {
	protected $_dbHandle;
	protected $_result;
	protected $_query;
	protected $_colName;
	protected $_stmt;
	protected $_rColData = array();

	/** Connects to database **/
	function connect($dsn, $host, $username, $passwd, $dbname) {
		try{
			$this->_dbHandle = new PDO($dsn . ':host=' . $host . ';dbname=' . $dbname, $username, $passwd);
		}	catch(PDOException $e){
			echo $e->getMessage();
		}
	}
	
	/** Disconnects from database **/
	function disconnect() {
		if($this->_dbHandle != NULL){
			$this->_dbHandle = NULL;	
		}
	}
	   
		 
	/** Custom SQL Query **/
	function cQuery(){
		$this->_result = mysql_query($this->_query, $this->_dbHandle);
		
		if(mysql_error() != '')	{
			/** Error handler **/
			echo "<br />Custom Query ERROR!: " . mysql_error();
			echo "<br />Query: " . $this->query;	
		}
		
		return $this->_result;
		$this->clear();		
			
	}

	/** Clears all variable **/
	function clear(){
		$this->_query = null;
		$this->_result = null;
	}

	/** Get number of rows **/
	function getNumRows() {
		return mysql_num_rows($this->_result);
	}

	/** Free resources allocated by a query **/
	function freeResult() {
		mysql_free_result($this->_result);
	}

	/** Get error string **/
	function getError() {
		return mysql_error($this->_dbHandle);
	}
}