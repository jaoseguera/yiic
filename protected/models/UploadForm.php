<?php

class UploadForm extends CFormModel
{
    public $file,$typeselect;
	

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
       
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
          return array(
            array('file', 'file', 'types'=>'application/json', 'safe' => false)
        );
        
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
           
        );
    }
    /*
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Login the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

}