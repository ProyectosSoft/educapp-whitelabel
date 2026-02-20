@props(['size'=>35, 'color'=>'gray'])

@php
    switch ($color) {
        case 'gray':
                $col='#374151';
            break;
            case 'white':
                $col='#FFFFFF';
            break;
            case 'greenLime':
                $col='#5eead4';
            break;
        default:
            $col='#374151';
            break;
    }
@endphp

<?php
echo '<?xml version="1.0" encoding="utf-8"?>';
?><svg height="{{$size}}" viewBox="0 0 21 21" width="{{$size}}" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd" transform="translate(2 4)"><path d="m3 2.5h12.5l-1.5855549 5.54944226c-.2453152.85860311-1.0300872 1.45055774-1.9230479 1.45055774h-6.70131161c-1.01909844 0-1.87522688-.76627159-1.98776747-1.77913695l-.80231812-7.22086305h-2" stroke="{{$color}}" stroke-linecap="round" stroke-linejoin="round"/><g fill="{{$color}}"><circle cx="5" cy="12" r="1"/><circle cx="13" cy="12" r="1"/></g></g></svg>
