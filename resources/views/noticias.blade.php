@extends('app')

@section('content')
<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
    <h2>Raspagem da CGM</h2>
    @foreach ($resultado as $value)
        <li>
            <span>{{ $value['date'] }} de {{ $value['month'] }}</span>
            <a href="{{ $value['link'] }}" target="_blank" rel="noopener noreferrer">{{ $value['link'] }}</a>
        </li>
    @endforeach
</div>
@endsection