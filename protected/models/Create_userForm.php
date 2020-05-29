<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 **/
class Create_userForm extends CFormModel
{
	public $compy_legalname, $compy_street, $compy_houseno, $compy_city, $compy_state, $compy_postalcode, $compy_telephone, $compy_fax, $compy_timezone, $compy_tinno;
	public $plant_legalname, $plant_street, $plant_houseno, $plant_city, $plant_state, $plant_postalcode, $plant_telephone, $plant_fax, $plant_timezone, $plant_tinno;
	public $sales_legalname, $sales_street, $sales_houseno, $sales_city, $sales_state, $sales_postalcode, $sales_telephone, $sales_fax, $sales_timezone, $sales_tinno;
	public $purch_legalname, $purch_street, $purch_houseno, $purch_city, $purch_state, $purch_postalcode, $purch_telephone, $purch_fax, $purch_timezone, $purch_tinno;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			// array('firstname, lastname, email, password, repassword, secques1, secans1, secques2, secans2,  street, city, state, country, phone, company', 'required'),
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
			'I_COMPANY'=>'Company ID',
			'I_NAME'=>'Name',
			'I_ADDRESS'=>'Address',
			'I_LOGO'=>'Logo'
		);
	}
}