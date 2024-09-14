@if (session()->has('success'))
<div id="success-flash-message" class="mt-12 mx-4 px-4 rounded-md border-l-4 border-green-500 bg-green-50 md:max-w-2xl md:mx-auto">
  <div class="flex justify-between py-3">
    <div class="flex">
      <div class="self-center ml-3">
        <span class="text-green-600 font-semibold">
          Success
        </span>
        <p class="text-green-600 mt-1">
          {!!session('success')!!}
        </p>
      </div>
    </div>
    <button onclick="(hideThis('success-flash-message'))" class="self-start text-green-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fillRule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clipRule="evenodd" />
      </svg>
    </button>
  </div>
</div>
@endif

@if (session()->has('error'))
<div id="error-flash-message" class="mt-12 mx-4 px-4 rounded-md border-l-4 border-red-500 bg-red-50 md:max-w-2xl md:mx-auto">
  <div class="flex justify-between py-3">
    <div class="flex">
      <div class="self-center ml-3">
        <span class="text-red-600 font-semibold">
          Error
        </span>
        <p class="text-red-600 mt-1">
          {!!session('error')!!}
        </p>
      </div>
    </div>
    <button onclick="hideThis('error-flash-message')" class="self-start text-red-500">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fillRule="evenodd"
          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
          clipRule="evenodd" />
      </svg>
    </button>
  </div>
</div>
@endif

@if (session()->has('warning'))
<div class="mt-12 mx-4 px-4 rounded-md bg-amber-50 md:max-w-2xl md:mx-auto">
  <div class="py-3">
    <div class="flex">
      <div class="self-center ml-3">
        <span class="text-amber-600 font-semibold">
          Warning
        </span>
        <p class="text-amber-600 mt-1">
          {!!session('warning')!!}
        </p>
      </div>
    </div>
  </div>
</div>
@endif

@if (session()->has('info'))
<div class="max-w-5xl mx-auto px-4 md:px-8">
  <div class="flex justify-between p-4 rounded-md bg-blue-50 border border-blue-300">
      <div class="flex gap-3">
          <div>
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                  <path strokeLinecap="round" strokeLinejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
          </div>
          <div class="self-center">
              <span class="text-blue-600 font-medium">
                  New update available
              </span>
              <div class="text-blue-600">
                  <div class="mt-2">
                    {{session('info')}}
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endif