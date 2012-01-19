<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once 'Zend/Acl.php'; 
require_once 'Zend/Acl/Role.php';
require_once 'Zend/Acl/Resource.php';
//echo $acl->isAllowed('administrator', 'frontend', 'add') ?
//     "allowed" : "denied";

 class Acl {
  var $permission;
  var $CI;
	
  function Acl(){  
	$this->CI = & get_instance();	
  	$this->permission = new Zend_Acl();
		$this->initrules();
  }

  function initrules(){
  	        //Setup Roles
			$this->set_roles_hierarchy();
			//Setup Resources
			$this->set_resources_hierarchy();
			//Setup Access Control
			$this->set_acl();
  }
  
  function isAllowed($role,$resource,$privilege){
  	return $this->permission->isAllowed($role, $resource, $privilege);
  }
  
  function set_roles_hierarchy($parent = ''){
	$this->CI->db->where('inherit',$parent);
	$result = $this->CI->db->get('acl_roles');

   if($result->num_rows()>0){
	foreach ($result->result_array() as $row){				
		$role = new Zend_Acl_Role($row['name']);
		$this->permission->addRole($role,$parent ? $parent : NULL);
		$this->set_roles_hierarchy($row['name']);	
	}	
   }
  }
  
  function set_resources_hierarchy($parent = ''){
	$this->CI->db->where('inherit',$parent);
	$result = $this->CI->db->get('acl_resources');

   if($result->num_rows()>0){
	foreach ($result->result_array() as $row){				
		$role = new Zend_Acl_Resource($row['name']);
		$this->permission->add($role,$parent ? $parent : NULL);
		$this->set_resources_hierarchy($row['name']);	
	}	
   }
  }
  
  function set_acl(){
	$result = $this->CI->db->get('acl');
	foreach ($result->result_array() as $row){				
		$this->permission->$row['access']($row['role']?$row['role']:NULL,
										 $row['resource']?$row['resource']:NULL,
										 $row['privilege']?$row['privilege']:NULL);
	}		
  }
  
 }
