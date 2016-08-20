<?php 
	class Grafico {

		/*Atributos*/
		public $db = '';

	   function __construct($db) {
	       $this->db = $db;
	   }

	   function get($tableName, $fields = null, $filters = null, $orderby = null, $groupby = null, $limit = null)
	   {


	   		$stringFields ="*";
	   		if($fields != null){
	   			$stringFields="";
	   			foreach ($fields as $value) {
	   				if ($stringFields != ""){
	   					$stringFields .= ", ";
	   				}
	   				$stringFields .= $value;
	   			}
	   		}

	   		$stringFilters = "";
	   		if ($filters!=null){
	   			$stringFilters .= "WHERE ";

	   			foreach ($filters as $fieldname => $fieldvalue) {
	   				if ($stringFilters != "WHERE "){
	   					$stringFilters .= " AND ";
	   				}

	   				$condition = "=";

	   				if (isset($fieldvalue['condition'])){
	   					$condition = $fieldvalue['condition'];
	   					if ($condition == "LIKE" or $condition == "like"){
	   						$condition = " ".$condition." ";
	   					}
	   				}

	   				$value = "";
	   				if (isset($fieldvalue['value'])){
	   					$value = $fieldvalue['value'];

	   				}

	   				$stringFilters .= $fieldname . $condition . $value;
	   			}

	   		}

	   		$stringOrder = "";
	   		if ($orderby!=null){
	   			$stringOrder = " ORDER BY ";
	   			foreach ($orderby as $fieldname => $order) {
	   				$stringOrder.= $fieldname ." ".$order;
	   			}
	   		}

	   		$stringGroup = "";
	   		if ($groupby!=null){
	   			$stringGroup = " GROUP BY ";
	   			foreach ($groupby as $field) {
	   				$stringGroup.= $field;
	   			}
	   		}

	   		$stringLimit = "";
	   		if ($limit!=null){
	   			$stringLimit = " LIMIT ";
	   			foreach ($limit as $field) {
	   				$stringLimit.= $field;
	   			}
	   		}

	   		//$query = $this->db->prepare("select fecha, emision, tipo, precio FROM $tableName");

	   		$queryString = "select ".$stringFields." FROM ".$tableName." ".$stringFilters.$stringGroup.$stringOrder.$stringLimit;
	   		//exit(var_export($queryString));
	   	 	$query = $this->db->prepare($queryString);
	      	$query->execute();

	      	$output = $query->fetchAll();
	      	unset($this->db); 
	      	unset($query);	      	
	      	return $output;
	   }

	   function __destruct() {
	       //print "Destruyendo " . $this->name . "\n";
	   }
	}

?>