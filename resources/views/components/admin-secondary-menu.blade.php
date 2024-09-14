<div class="flex flex-col w-56">
    <div class="flex-1 flex-col flex-grow p-4 overflow-auto">
        <a class="flex items-center flex-shrink-0 h-10 px-2 text-sm font-medium rounded hover:bg-gray-300 dark:hover:bg-gray-800 {{request()->routeIs('admin.menu.users') ? 'bg-gray-300 dark:bg-gray-800' : ''}}" href="/admin/menu/users">
            <span class="leading-none">Users</span>
        </a>
        <a class="flex items-center flex-shrink-0 h-10 px-2 text-sm font-medium rounded hover:bg-gray-300 dark:hover:bg-gray-800 {{request()->routeIs('admin.menu.events') ? 'bg-gray-300 dark:bg-gray-800' : ''}}" href="/admin/menu/events">
            <span class="leading-none">Appointments</span>
        </a>
        <a class="flex items-center flex-shrink-0 h-10 px-2 text-sm font-medium rounded hover:bg-gray-300 dark:hover:bg-gray-800 {{request()->routeIs('admin.menu.worktypes') ? 'bg-gray-300 dark:bg-gray-800' : ''}}" href="/admin/menu/worktypes">
            <span class="leading-none">Worktypes</span>
        </a>
        <a class="flex items-center flex-shrink-0 h-10 px-2 text-sm font-medium rounded hover:bg-gray-300 dark:hover:bg-gray-800 {{request()->routeIs('admin.menu.closedDays') ? 'bg-gray-300 dark:bg-gray-800' : ''}}" href="/admin/menu/closed-days">
            <span class="leading-none">Closed days</span>
        </a>
    </div>
</div>