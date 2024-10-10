@props(['emotion'])
@php 
$positive = array('happy', 'interest', 'surprise');
$negative = array('sad', 'angry', 'disappointed', 'fear', 'disgust');
$neutral = array('neutral', 'confused');
$emotion_text = $emotion;
switch($emotion){
    case 'happy':
        $emotion_text = 'senang';
        break;
    case 'interest':
        $emotion_text = 'tertarik';
        break;
    case 'surprise':
        $emotion_text = 'kaget';
        break;
    case 'sad':
        $emotion_text = 'sedih';
        break;
    case 'angry':
        $emotion_text = 'marah';
        break;
    case 'disappointed':
        $emotion_text = 'kecewa';
        break;
    case 'fear':
        $emotion_text = 'takut';
        break;
    case 'disgust':
        $emotion_text = 'muak';
        break;
    case 'neutral':
        $emotion_text = 'netral';
        break;
    case 'confused':
        $emotion_text = 'bingung';
        break;
    
}

@endphp
@if (in_array($emotion, $positive))
    <span {{ $attributes->merge(['class' => 'text-green-500 dark:text-green-400 font-semibold']) }}> {{ ucfirst($emotion_text) }} </span>
@elseif (in_array($emotion, $negative))
    <span {{ $attributes->merge(['class' => 'text-red-500 dark:text-red-400 font-semibold']) }}> {{ ucfirst($emotion_text) }} </span>
@else
    <span {{ $attributes->merge(['class' => 'text-gray-500 dark:text-gray-400 font-semibold']) }}> {{ ucfirst($emotion_text) }} </span>
@endif
