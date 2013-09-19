<?php
class MySql extends PDOCore{
	/** Get column names of table **/
	function getColNames(){
		if(isset($this->_table)){
			try{
				$this->_query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '" . $this->_table . "'";
				
				$this->_stmt = $this->_dbHandle->prepare($this->_query);
				$this->_stmt->setFetchMode(PDO::FETCH_ASSOC);
				
				if($this->_stmt->execute()){
					$this->_rColData = $this->_stmt->fetchAll();
					
					/** Loop trough Raw Column Data(_rColData) **/ 
					foreach($this->_rColData as $key => $array)	{	/** $outerkey = Column properties, $value = the value of the column properties **/
						foreach($array as $key => $value){
							if($key == 'COLUMN_NAME')	{
								$this->colNames[] = $value;	
							}
						}				
					}
					return true;
					
				}	else {
					/** ERROR Handler **/
					echo "Can't execute getColNames";
				}	
				return true;
				
			}	catch(PDOException $e ){
				echo $e->getMessage();
			}
		}	else {
			/** ERROR Handler **/
			echo 'Get Column Name ERROR!: No table selected!';
		}
	}
	
	function selectAll() {
		$query = 'SELECT * FROM `'.$this->_table . '`';
		return $this->query($query);
	}
	
	function select($id) {
		$query = 'SELECT * FROM `'.$this->_table . '` WHERE `id` = \''.mysql_real_escape_string($id).'\'';
		
		return $this->_db->query($query);
	}
	
	/** Delete selected by id, from database **/
	function delete() {	
		if($this->id){		
			try {
				$this->_query = 'DELETE FROM ' . $this->_table . ' WHERE `id`=\'' . mysql_real_escape_string($this->id) . '\'';
				
				return $this->_dbHandle->exec($this->_query);
			}
			catch (PDOException $e){
				echo $e->getMessage();
			}
			
		}	else {
			/** Error Handler **/
			echo "Delete Query ERROR!";
			
		}
		$this->clear();
		$this->disconnect();
		
	}
	
	function update(){
		if(isset($this->id)){
			try{
				$this->_query = 'SHOW COLUMS FROM ' . $this->_table;
				
				
				
			}	catch (PDOException $e){
				echo $e->getMessage();
			}	
		}
	} 
	
	function insert($data){
		$query = 'INSERT INTO `' . $this->_table . '(' . $data . ')';
	}
}