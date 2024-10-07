<form action="{{ route('user.custom.fields.store') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    @foreach(App\Models\UserCustomField::fields() as $field)
        <div>
            <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
           
            @if (in_array($field['type'], ['text', 'number', 'password', 'email', 'url', 'tel']))
                <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}" 
                    class="{{ isset($field['class']) ? $field['class'] : '' }}" value="{{ $user->customFields()->where('user_id', $user->id)->where('field_key', $field['name'])->first()->field_value ?? '' }}"
                    {{ isset($field['required']) ? 'required' : '' }}
                    {{ isset($field['autofocus']) ? 'autofocus' : '' }}
                    {{ isset($field['autocomplete']) ? 'autocomplete="' . $field['autocomplete'] . '"' : '' }}
                >
            @endif
                
        </div>
    @endforeach
    
    <button type="submit">Save</button>
</form>
