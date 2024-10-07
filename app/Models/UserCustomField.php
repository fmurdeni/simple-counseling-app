<?php

// app/Models/UserCustomField.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCustomField extends Model
{
    use HasFactory;

    public static function fields(){
        return array(
            array(
                'label' => __('Jenis Kelamin'),
                'name' => 'sex',
                'type' => 'radio',
                'value' => '',
                'required' => true,
                'options' => array(
                    'm' => __( 'Laki-laki' ), 
                    'f' => __( 'Perempuan' )
                )
            ),

            array(
                'label' => __('Alamat'),
                'name' => 'address',
                'class' => 'form-control',
                'type' => 'textarea',
                'value' => '',
                'placeholder' => __('Masukkan alamat'),
                'required' => false
            ),

            /* array(
                'label' => __('Is active'),
                'name' => 'is_active',
                'type' => 'checkbox',
                'input_text' => __('Yes'),
                'value' => 'on',
                'required' => false
            ), */
            
        );
    }

    public static function thisfillable(){
        $fields = ['user_id', 'field_key', 'field_value'];
        if (!empty(self::fields())) {
            foreach(self::fields() as $field){
                $fields[] = $field['name'];
            }
        }

        return $fields;
    }

    public function getFillable()
    {
        return self::thisfillable();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getValue($user_id, $field_key){
        return UserCustomField::where('user_id', $user_id)->where('field_key', $field_key)->first()->field_value ?? '';
    }
    
}

