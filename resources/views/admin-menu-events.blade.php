<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    @include('components/admin-secondary-menu')
    <div class="grid grid-cols-5 gap-3 m-auto">
        <form class="col-span-6" action="/admin/menu/events" method="GET">
            <div class="grid grid-cols-5 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Appointment ID
                        </label>
                        <input value="{{Request::get('appointmentId') ?? '' }}" name="appointmentId" type="number" placeholder="Appointment ID" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            User name
                        </label>
                        <input value="{{Request::get('userName') ?? '' }}" name="userName" type="text" placeholder="User name" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Created at
                        </label>
                        <input value="{{Request::get('createdAt') ?? '' }}" name="createdAt" type="date" class="border-black dark:border-white hover:cursor-pointer w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Status
                        </label>
                        <select name="status" class="border-black dark:border-white hover:cursor-pointer w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">
                            <option {{Request::get('status') == 0 ? 'selected' : '' }} value="0">All</option>
                            @foreach ($statuses as $status)
                                <option {{Request::get('status') == $status->id ? 'selected' : '' }} value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Work type
                        </label>
                        <select name="workType" class="border-black dark:border-white hover:cursor-pointer w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">
                            <option {{Request::get('workType') == 0 ? 'selected' : '' }} value="0">All</option>
                            @foreach ($workTypes as $workType)
                                <option {{Request::get('workType') == $workType->id ? 'selected' : '' }} value="{{$workType->id}}">{{$workType->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 w-max justify-items-center items-center">
                        <div class="col-span-1">
                            <input type="submit" value="Submit" class="border-black dark:border-white w-max hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                        </div>
                        <div class="col-span-1">
                            <a href="/admin/menu/events" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                    </div>
            </div>
        </form>

        @if (count($events) > 0)
            <div class="col-span-5">
                <div class="grid grid-cols-1 gap-1 h-fit py-3 rounded-sm border border-stroke border-black bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-white dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($events as $event)
                    <a href="/admin/event/{{$event->id}}?from={{Request::path()}}&{{http_build_query(Request::query())}}" class="px-7.5 py-3 border-b border-black dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                        <div class="grid grid-cols-5 justify-items-center items-center border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                            <div class="col-span-1">
                                <span>{{$event->id}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$event->user->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <input class="bg-gray-50 border border-black dark:border-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" type="datetime-local" value="{{$event->created_at}}" disabled>
                            </div>
                            <div class="col-span-1">
                                <span>{{$event->status->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$event->workType->name}}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div> 
                <div class="p-2">
                    {{$events->appends(request()->query())->links()}}
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