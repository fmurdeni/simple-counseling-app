<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCustomField;

class UserCustomFieldController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',            
        ]);

        $fields = UserCustomField::fields();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                
                UserCustomField::updateOrCreate(
                    [
                        'user_id' => $request->user_id,
                        'field_key' => $field['name']
                    ],
                    [
                        'field_value' => $request->{$field['name']}
                    ]
                );
               
            }
        }
            
       

        return redirect()->back()->with('success', 'Custom field saved successfully!');
    }
}
