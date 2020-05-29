<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 **/
class RegisterForm extends CFormModel
{
	public $firstname;
	public $lastname;
	public $email;
	public $password;
	public $repassword;
	public $secques1;
	public $secques2;
	public $secans1;
	public $secans2;
	public $street;
	public $city;
	public $state;
	public $country;
	public $phone;
	public $company;
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('firstname, lastname, email, password, repassword, secques1, secans1, secques2, secans2,  street, city, state, country, phone, company', 'required'),
			// email has to be a valid email address
			// array('email', 'email'),
                        // phone has to be a valid phone number
                        // array('phone', 'application.extensions.UKPhoneValidator'),
			// verifyCode needs to be entered correctly
			// array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'firstname'=>'First Name',
			'lastname'=>'Last Name',
			'email'=>'Email Address',
			'password'=>'Password',
			'repassword'=>'Retype password',
			'verifyCode'=>'Verification Code',
			'secques1'=>'Secret Question 1',
			'secques2'=>'Secret Question 2',
			'secans1'=>'Secret Answer',
			'secans2'=>'Secret Answer',
			'street'=>'Street',
			'city'=>'City',
			'country'=>'Country',
			'state'=>'State',
			'phone'=>'Phone',  
			'company'=>'Company Name',  
		);
	}
}