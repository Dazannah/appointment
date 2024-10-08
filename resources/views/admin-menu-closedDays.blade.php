<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    @include('components/admin-secondary-menu')
    <div class="grid grid-cols-4 gap-3 m-auto">
        <form class="col-span-3" action="/admin/menu/closed-days" method="GET">
            <div class="grid grid-cols-3 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            ID
                        </label>
                        <input value="{{Request::get('closedDayId') ?? '' }}" name="closedDayId" type="number" placeholder="Closed day ID" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Start date
                        </label>
                        <input value="{{Request::get('startDate') ?? '' }}" name="startDate" type="date" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            End date
                        </label>
                        <input value="{{Request::get('endDate') ?? '' }}" name="endDate" type="date" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>

                    <div class="grid grid-cols-2 w-max justify-items-center items-center">
                        <div class="col-span-1">
                            <input type="submit" value="Submit" class="border-black dark:border-white w-max hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                        </div>
                        <div class="col-span-1">
                            <a href="/admin/menu/closed-days?currentYear=on" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                    </div>
                    <div class="grid content-center justify-center">
                        <a href="/admin/closed-days/create" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Create closed day</a>
                    </div>
                    <div class="grid content-center justify-center">
                        <div>
                            <input type="checkbox" name="holidays" id="holidays" {{Request::get('holidays') == 'on' ? 'checked' : '' }}>
                            <label for="holidays">Holidays</label>
                        </div>
                        <div>
                            <input type="checkbox" name="currentYear" id="currentYear" {{Request::get('currentYear') == 'on' ? 'checked' : '' }}>
                            <label for="holidays">Current year</label>
                        </div>
                    </div>
            </div>
        </form>

        @if (count($closedDays) > 0)
            <div class="col-span-4">
                <div class="grid grid-cols-1 gap-1 h-fit py-3 rounded-sm border border-stroke border-black pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-white dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($closedDays as $closedDay)
                    <a {{--href="/admin/closed-day/{{$closedDay->id}}"--}} class="px-7.5 py-3 border-b border-black dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                        <div class="grid grid-cols-4 justify-items-center items-center border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-white">
                            <div class="col-span-1">
                                <span>{{$closedDay->id}}</span>
                            </div>
                            <div class="col-span-1">
                                <input type="date" value="{{$closedDay->start}}" class="bg-gray-50 border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                            </div>
                            <div class="col-span-1">
                                <input type="date" value="{{$closedDay->end}}" class="bg-gray-50 border border-black text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 border-black dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                            </div>
                            <div class="col-span-1">
                                <form action="/admin/closed-days/delete/{{$closedDay->id}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <input class="border-black dark:border-white hover:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black dark:text-white dark:bg-gray-900" type="submit" value="Delete">
                                </form>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div> 
                <div class="p-2">
                    {{$closedDays->appends(request()->query())->links()}}
                </div>
            </div>
        @else
        <div class="col-span-4">
            <div class="grid grid-cols-1 gap-3 h-fit py-3 rounded-sm border border-stroke bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                <span class="text-2xl justify-self-center self-center">No matching result.</span>
            </div>
        </div>
        @endif

        
    </div>
  </x-app-layout>