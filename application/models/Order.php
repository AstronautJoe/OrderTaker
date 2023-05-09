<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Model {
	public function __construct(){
		parent::__construct();
/*	DOCU: to set the default time and automatically set the proper date format .
	Owner: Joel */
		date_default_timezone_set('Asia/Hong_Kong');
/*	DOCU: Level 3: View + Model Form validations: skinny controller, fat models .
	Owner: Joel */
		$this->load->library('form_validation');
	}

/*	DOCU: Main reusable method for first cleaning the post data. Returns ALL post data.
	Owner: Joel */
	public function sanitize_post_data(){
		$post = $this->input->post(NULL, TRUE);
		$postData = $this->security->xss_clean($post);
		$this->security->csrf_verify();
		return $postData;
	}

/*	DOCU: Method for sanitizing the ID only and returning a safe ID. Used for when grabbing IDs only.
	Owner: Joel */
	public function sanitization_security($id){
		$this->security->csrf_verify();
		$safeId = $this->security->xss_clean($id);

		return $safeId;
	}

/*	DOCU: Validates form inputs with error messages for each error.
	Owner: Joel */	
	public function validate_order(){
		$this->form_validation->set_rules('order_content', 'Order', 'trim|required|min_length[5]', array(
			'required' => 'The %s field is required.',
			'min_length' => 'The %s must have atleast 10 alphabetical characters.'
		));
		return $this->form_validation->run();
	}

/*	DOCU: Validates form inputs with error messages for each error.
	Owner: Joel */	
	public function add_order_record($postData){
		$query = "INSERT INTO orders(order_content, created_at, updated_at) VALUES(?, NOW(), NOW())";
		$values = array($postData['order_content']);
		return $this->db->query($query, $values);
	}

/*	DOCU: Retrieves all orders from the database and stores in a result_array.
	Owner: Joel */	
	public function get_all_orders(){
		$query = "SELECT * FROM orders;";
		return $this->db->query($query)->result_array();
	}

/*	DOCU: Deletes the order record from the database.
	Owner: Joel */	
	public function remove_order_record($safeId){
		$query = "DELETE FROM orders WHERE id = ?";
		$values = array($safeId);
		return $this->db->query($query, $values);
	}

/*	DOCU: Retrieves specific order record with all included fields.
	Owner: Joel */	
	public function get_order($id){
		$safeId = $this->security->xss_clean($id);
		$query = "SELECT * FROM orders WHERE id = ?";
		$values = array($safeId);
		return $this->db->query($query, $values)->row_array();
	}

/*	DOCU: Updates the order record in the database.
	Owner: Joel */	
	public function update_order_record($postData, $safeId){
		$query = "UPDATE orders SET order_content = ? WHERE id = ?";
		$values = array($postData['order_content'], $safeId);
		return $this->db->query($query, $values);
	}

}