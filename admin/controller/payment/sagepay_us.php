<?php 
class ControllerPaymentSagepayUS extends Controller {
	private $error = array(); 

	public function index() {
		$this->language->load('payment/sagepay_us');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
			
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('sagepay_us', $this->request->post);				
			
			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_all_zones'] = $this->language->get('text_all_zones');
		
		$this->data['entry_merchant_id'] = $this->language->get('entry_merchant_id');
		$this->data['entry_merchant_key'] = $this->language->get('entry_merchant_key');
		$this->data['entry_total'] = $this->language->get('entry_total');	
		$this->data['entry_order_status'] = $this->language->get('entry_order_status');		
		$this->data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['merchant_id'])) {
			$this->data['error_merchant_id'] = $this->error['merchant_id'];
		} else {
			$this->data['error_merchant_id'] = '';
		}

 		if (isset($this->error['merchant_key'])) {
			$this->data['error_merchant_key'] = $this->error['merchant_key'];
		} else {
			$this->data['error_merchant_key'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),       		
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_payment'),
			'href'      => $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('payment/sagepay_us', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
				
		$this->data['action'] = $this->url->link('payment/sagepay_us', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/payment', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->post['sagepay_us_merchant_id'])) {
			$this->data['sagepay_us_merchant_id'] = $this->request->post['sagepay_us_merchant_id'];
		} else {
			$this->data['sagepay_us_merchant_id'] = $this->config->get('sagepay_us_merchant_id');
		}
		
		if (isset($this->request->post['sagepay_us_merchant_key'])) {
			$this->data['sagepay_us_merchant_key'] = $this->request->post['sagepay_us_merchant_key'];
		} else {
			$this->data['sagepay_us_merchant_key'] = $this->config->get('sagepay_us_merchant_key');
		}
		
		if (isset($this->request->post['sagepay_us_total'])) {
			$this->data['sagepay_us_total'] = $this->request->post['sagepay_us_total'];
		} else {
			$this->data['sagepay_us_total'] = $this->config->get('sagepay_us_total'); 
		} 
		
		if (isset($this->request->post['sagepay_us_order_status_id'])) {
			$this->data['sagepay_us_order_status_id'] = $this->request->post['sagepay_us_order_status_id'];
		} else {
			$this->data['sagepay_us_order_status_id'] = $this->config->get('sagepay_us_order_status_id'); 
		} 

		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();
		
		if (isset($this->request->post['sagepay_us_geo_zone_id'])) {
			$this->data['sagepay_us_geo_zone_id'] = $this->request->post['sagepay_us_geo_zone_id'];
		} else {
			$this->data['sagepay_us_geo_zone_id'] = $this->config->get('sagepay_us_geo_zone_id'); 
		} 
		
		$this->load->model('localisation/geo_zone');
										
		$this->data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();
		
		if (isset($this->request->post['sagepay_us_status'])) {
			$this->data['sagepay_us_status'] = $this->request->post['sagepay_us_status'];
		} else {
			$this->data['sagepay_us_status'] = $this->config->get('sagepay_us_status');
		}
		
		if (isset($this->request->post['sagepay_us_sort_order'])) {
			$this->data['sagepay_us_sort_order'] = $this->request->post['sagepay_us_sort_order'];
		} else {
			$this->data['sagepay_us_sort_order'] = $this->config->get('sagepay_us_sort_order');
		}

		$this->template = 'payment/sagepay_us.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'payment/sagepay_us')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->request->post['sagepay_us_merchant_id']) {
			$this->error['merchant_id'] = $this->language->get('error_merchant_id');
		}

		if (!$this->request->post['sagepay_us_merchant_key']) {
			$this->error['merchant_key'] = $this->language->get('error_merchant_key');
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
}
?>