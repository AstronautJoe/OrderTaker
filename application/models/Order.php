<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Model {
	public function __construct(){
		parent::__construct();
		/* to set the default time and automatically set the proper date format */
		date_default_timezone_set('Asia/Hong_Kong');
		/* Level 3: View + Model Form validations: skinny controller, fat models */
		$this->load->library('form_validation');
	}

	public function sanitize_post_data(){
		/* cleanse form	 */
		$post = $this->input->post(NULL, TRUE);
		$postData = $this->security->xss_clean($post);

		/* validate csrf token */
		$this->security->csrf_verify();

		return $postData;
	}

	public function validate_order(){
		/* Validate the form inputs with error messages for each error */
		$this->form_validation->set_rules('order_content', 'Order', 'trim|required|min_length[5]', array(
			'required' => 'The %s field is required.',
			'min_length' => 'The %s must have atleast 10 alphabetical characters.'
		));
		return $this->form_validation->run();
	}

	public function add_order_record($postData){
		$query = "INSERT INTO orders(order_content, created_at, updated_at) VALUES(?, NOW(), NOW())";
		$values = array($postData['order_content']);
		return $this->db->query($query, $values);
	}

	public function get_all_orders(){
		$query = "SELECT * FROM orders;";
		return $this->db->query($query)->result_array();
	}

	public function sanitization_security($id){
		$this->security->csrf_verify();
		$safeId = $this->security->xss_clean($id);

		return $safeId;
	}

	public function remove_order_record($safeId){
		$query = "DELETE FROM orders WHERE id = ?";
		$values = array($safeId);
		return $this->db->query($query, $values);
	}

	public function get_order($id){
		$safeId = $this->security->xss_clean($id);
		$query = "SELECT * FROM orders WHERE id = ?";
		$values = array($safeId);
		return $this->db->query($query, $values)->row_array();
	}

	public function update_order_record($postData, $safeId){
		$query = "UPDATE orders SET order_content = ? WHERE id = ?";
		$values = array($postData['order_content'], $safeId);
		return $this->db->query($query, $values);
	}

}