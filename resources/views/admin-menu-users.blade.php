<x-app-layout>
    <x-slot:pageTitle>{{ $pageTitle ?? 'Page Title'}}</x-slot>
    @include('components/admin-secondary-menu')
    <div class="grid grid-cols-5 gap-3">
        <form class="col-span-5" action="/admin/menu/users" method="GET">
            <div class="grid grid-cols-5 gap-1">
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            User ID
                        </label>
                        <input value="{{Request::get('userId') ?? '' }}" name="userId" type="number" placeholder="User ID" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Name
                        </label>
                        <input value="{{Request::get('name') ?? '' }}" name="name" type="text" placeholder="Name" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            E-mail
                        </label>
                        <input value="{{Request::get('email') ?? '' }}" name="email" type="text" placeholder="E-mail" class="w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:text-white dark:focus:border-primary">
                    </div>
                    <div class="col-span-1">
                        <label class="mb-3 block text-sm font-medium text-black dark:text-white">
                            Status
                        </label>
                        <select name="status" class="hover:cursor-pointer w-full rounded-lg border-[1.5px] border-stroke bg-transparent px-5 py-3 font-normal text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:hover:bg-gray-800 border dark:text-white dark:bg-gray-900">
                            <option {{Request::get('status') == 0 ? 'selected' : '' }} value="0">All</option>
                            @foreach ($statuses as $status)
                                <option {{Request::get('status') == $status->id ? 'selected' : '' }} value="{{$status->id}}">{{$status->name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="grid grid-cols-2 grid-rows-2 justify-items-center items-center">
                        <div class="col-span-1">
                            <label for="isAdmin" class="hover:cursor-pointer mb-3 block text-sm font-medium text-black dark:text-white">
                                Admin
                            </label>
                        </div>
                        <div class="col-span-1 row-span-2 mt-3 md:mt-0">
                            <input type="submit" value="Submit" class="hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-green-500 dark:hover:bg-green-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">
                            <a href="/admin/menu/users" class="hover:cursor-pointer flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:bg-red-500 dark:hover:bg-red-500 hover:dark:text-black border dark:text-white dark:bg-gray-900">Reset</a>
                        </div>
                        <div class="col-span-1">
                            <input {{Request::get('isAdmin') == 'on' ? 'checked' : '' }} class="hover:cursor-pointer" type="checkbox" name="isAdmin" id="isAdmin">
                        </div>
                    </div>
            </div>
        </form>
        @if (count($users) > 0)
            <div class="col-span-4">
                <div class="grid grid-cols-1 gap-3 h-fit py-3 rounded-sm border border-stroke bg-white pb-2.5 pt-6 shadow-default dark:bg-gray-800 dark:border-gray-800 dark:text-white sm:px-7.5 xl:pb-1">
                    @foreach ($users as $user)
                    <a href="/admin/user/{{$user->id}}" class="px-7.5 py-3 border-b hover:bg-gray-300 dark:hover:bg-gray-900">
                        <div class="grid grid-cols-4 justify-items-center items-center border-stroke hover:bg-gray-300 dark:hover:bg-gray-900 dark:border-strokedark">
                            <div class="col-span-1">
                                <span>{{$user->id}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$user->name}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$user->email}}</span>
                            </div>
                            <div class="col-span-1">
                                <span>{{$user->userStatus->name}}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div> 
                <div class="p-2">
                    {{$users->links()}}
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