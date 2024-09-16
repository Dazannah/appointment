<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    @include('components/admin-secondary-menu')
    <div class="grid grid-cols-4 gap-3 m-auto">
        <form class="col-span-4" action="/admin/menu/worktypes" method="GET">
            <div class="grid grid-cols-4 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            ID
                        </label>
                        <input value="{{Request::get('worktypeId') ?? '' }}" name="worktypeId" type="number" placeholder="ID" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Name
                        </label>
                        <input value="{{Request::get('name') ?? '' }}" name="name" type="text" placeholder="Name" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Duration(mins)
                        </label>
                        <input value="{{Request::get('duration') ?? '' }}" name="duration" type="number" placeholder="Duration" class="border-black dark:border-white w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Price
                        </label>
                        <select name="priceId" class="border-black dark:border-white hover:cursor-pointer w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">
                            <option {{Request::get('priceId') == 0 ? 'selected' : '' }} value="0">All</option>
                            @foreach ($prices as $price)
                                <option {{Request::get('priceId') == $price->id ? 'selected' : '' }} value="{{$price->id}}">{{$price->price}} HUF</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 w-max justify-items-center items-center">
                        <div class="col-span-1">
                            <input type="submit" value="Submit" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                        </div>
                        <div class="col-span-1">
                            <a href="/admin/menu/worktypes" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                    </div>

                    <div class="grid content-center justify-center">
                        <a href="/admin/worktype/create" class="border-black dark:border-white hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Create worktype</a>
                    </div>
                </div>
        </form>
        @if (count($worktypes) > 0)
            <div class="col-span-4">
                <div class="grid grid-cols-1 gap-3 h-fit py-3 rounded-sm border border-stroke border-black bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800  dark:border-white dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($worktypes as $worktype)
                    <a href="/admin/worktype/{{$worktype->id}}?from={{Request::path()}}&{{http_build_query(Request::query())}}" class="px-7.5 py-3 border-b border-black dark:border-white hover:bg-gray-300 dark:hover:bg-gray-900">
                        <div class="grid grid-cols-4 justify-items-center items-center border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                            <div class="col-span-1">
                                <span>{{$worktype->id}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->duration}} mins</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$worktype->price->price}} HUF</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div> 
                <div class="p-2">
                    {{$worktypes->appends(request()->query())->links()}}
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