<?php 
class StripeModal extends AppModel{
	
	public $useTable = false;
	
	public function cc_information_validate(){
		$validate = array(
			'full_name' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter your full name.',
					'allowEmpty' => false
				)
			),
			'card_number' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your state.',
					'allowEmpty' => false
				),
				'rule2' => array(
					'rule' => '/^[0-9]*$/',
					'message' => 'Only integer are allowed in card number'
				),
				'min_length' => array(
					'rule' => array('minLength', '16'), 
					'message' => 'Card number should be 16 number'
				),
				'maxLength' => array(
					'rule' => array('maxLength', '16'), 
					'message' => 'Card number should be 16 number'
				)
			),
			'exp_month' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your expiry month.',
					'allowEmpty' => false
				)
			),
			'exp_year' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please select your expiry year.',
					'allowEmpty' => false
				)
			),
			'cvc' => array(
				'rule1' => array(
					'rule' => array('notEmpty'),
					'message' => 'Please enter cvc number.',
					'allowEmpty' => false
				)
			)
		);
		$this->validate = $validate;
		return $this->validates();
	}
	
}
?>
