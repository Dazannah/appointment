<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ $pageTitle }} | Appointment</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    /*.rotate-45 {
        --transform-rotate: 45deg;
        transform: rotate(45deg);
    }

    .group:hover .group-hover\:flex {
        display: flex;
    }*/
</style>
</head>
<body>
  <div class="h-screen flex text-gray-700 dark:text-gray-400 dark:bg-gray-900">
      @include('components/sidebar')
      <div class="w-max h-screen flex flex-col flex-grow">
        @include('components/menu', ['pageTitle' => isset($pageTitle) ? $pageTitle : null])
        @include('components/flash-message')
        <div class="flex overflow-y-auto">
          {{ $slot }}
        </div>
      </div>
    </div>
  </body>
@include('components/footer')
