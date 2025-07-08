<?php

class Task extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'task';
    }

    public function rules()
    {
        return array(
            array('title', 'required'),
            array('title', 'length', 'max'=>255),
            array('is_done', 'boolean'),
        );
    }
}
