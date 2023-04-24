<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders extends CI_Controller {

	public function __construct(){
		parent::__construct();
		/* Set the default time and automatically set the proper date format */
		date_default_timezone_set('Asia/Hong_Kong');
		/* Load the model and form validation library */
		$this->load->model('Order');
	}

/* 	DOCU: This method gets all orders from database and populates the view page with it
	Owner: JOEL */
	public function index(){
		$viewData = array(
			'orders' => $this->Order->get_all_orders()
		);
		$this->load->view('orders/index.php', $viewData);
	}

/* 	DOCU: This method gets all orders from database and populates the view page with it
	Owner: JOEL */
	public function index_html(){
		$viewData = array(
			'orders' => $this->Order->get_all_orders()
		);
		$this->load->view('partials/orders', $viewData);
	}


/* 	DOCU: This method adds orders and sends an HTML response to be inserted into div.orders
	Owner: JOEL */
	public function add_order(){
		$postData = $this->Order->sanitize_post_data();

		if($this->Order->validate_order() == TRUE){
			$this->Order->add_order_record($postData);
		}
		$this->index_html();
	}

	public function remove($id){
		$safeId = $this->Order->sanitization_security($id);
		$this->Order->remove_order_record($safeId);
		$this->index_html();
	}

	public function update($id){
		$postData = $this->Order->sanitize_post_data();
		$safeId = $this->security->xss_clean($id);

		if($this->Order->validate_order() == TRUE){
			$this->Order->update_order_record($postData, $safeId);
		}
		$this->index_html();
	}

	public function show_update_form($id){
		$viewData = array(
			'order' => $this->Order->get_order($id)
		);
		$this->load->view('partials/update_order_form', $viewData);
	}
	
}