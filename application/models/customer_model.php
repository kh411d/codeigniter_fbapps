<?php
 Class Customer_model extends CI_Model {
 
	function __construct()
	{
		parent::__construct();
	}
	
	/*
	*
	* Retrieve Customer Data 
	*
	* @param array('key' => 'email', 'value'=>example@example.com)
	* key can be username, email, or customer_id
	* 
	* @return Customer Single array data row
	*
	*/
	
	function retrieve(array $clauses)
	{
		$sql = $this->db->get_where('customer', $clauses);
		
		$query = $this->db->query($sql);
		$results = $query->row_array();
		
		if ($query->num_rows() <= 0) {
			return false;
		}
		
		return $results;
	}
	
	
   
	
	
 
 }