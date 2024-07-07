<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'Appointment') }}</title>
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
      <div class="w-max min-h-screen flex flex-col flex-grow">
        @include('components/menu')
        <div class="flex overflow-y-auto">
          {{ $slot }}
        </div>
      </div>
    </div>
  </body>

  <script>
    if(!localStorage.getItem('dark-mode')){
      localStorage.setItem('dark-mode', window.matchMedia('(prefers-color-scheme: dark)').matches)
    }

    if (localStorage.getItem('dark-mode') === 'true' || (!('dark-mode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
      document.querySelector('html').classList.add('dark');
    } else {
      document.querySelector('html').classList.remove('dark');
    }
  
    const lightSwitches = document.querySelectorAll('.light-switch');
    
    if (lightSwitches.length > 0) {
      lightSwitches.forEach((lightSwitch, i) => {
        if (localStorage.getItem('dark-mode') === 'true') {
          lightSwitch.checked = true;
        }
        lightSwitch.addEventListener('change', () => {
          const { checked } = lightSwitch;
          lightSwitches.forEach((el, n) => {
            if (n !== i) {
              el.checked = checked;
            }
          });
          if (lightSwitch.checked) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('dark-mode', true);
          } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('dark-mode', false);
          }
        });
      });
    }
  </script>
</html>