<?php 
	class Grafico {

		/*Atributos*/
		public $db = '';

	   function __construct($db) {
	       $this->db = $db;
	   }

	   function get($tableName)
	   {
	   	 	$query = $this->db->prepare("select fecha FROM $tableName");
	      	$query->execute();
	      	$output = $query->fetch();
	      	unset($this->db); 
	      	unset($query);	      	
	      	return $output;
	   }

	   function __destruct() {
	       //print "Destruyendo " . $this->name . "\n";
	   }
	}

?>