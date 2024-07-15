@if (session()->has('success'))
  <div class="mt-12 mx-4 px-4 rounded-md border-l-4 border-green-500 bg-green-100 dark:bg-green-50 md:max-w-2xl md:mx-auto">
    <div class="flex justify-between py-3">
        <div class="self-center ml-3">
          <p class="text-green-600 mt-1">
            {{session('success')}}
          </p>
        </div>
    </div>
  </div>
@endif
@if (session()->has('error'))
  <div class="mt-12 mx-4 px-4 rounded-md border-l-4 border-red-500 bg-red-100 dark:bg-red-50 md:max-w-2xl md:mx-auto">
    <div class="flex justify-between py-3">
      <div class="flex">
        <div class="self-center ml-3">
          <p class="text-red-600 mt-1">
            {{session('error')}}
          </p>
        </div>
      </div>
    </div>
  </div>
@endif