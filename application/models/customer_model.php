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
	* @param array('key' => 'email or username or customer_id', 'value'=>example@example.com)
	* 
	* @return array Customer Single array data row
	*/
	
	public function retrieve(array $clauses)
	{
		$sql = $this->db->get_where('customer', $clauses);
		
		$query = $this->db->query($sql);
		$results = $query->row_array();
		
		if ($query->num_rows() <= 0) {
			return false;
		}
		
		return $results;
	}
	
	
	/*
	*
	* Add Record to customer Database
	*
	* @param array('username','email','password','name')
	*
	* @return int Last Insert customer_id
	*/
	
	public function register(array $registrant_data)
	{
	 $this->load->library('passwordhash',array('iteration'=> 8,'portable'=> TRUE));
	 $registrant_data['password'] = $this->passwordhash->HashPassword($registrant_data['password']);
	 
	  $sql = $this->db->insert('customer', $registrant_data); 

	  return $this->db->insert_id();
	}
	
	
	
	
   
	
	
 
 }