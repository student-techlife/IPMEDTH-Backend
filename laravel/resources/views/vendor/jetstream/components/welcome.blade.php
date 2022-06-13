<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <x-jet-application-logo class="block h-12 w-auto" />
    </div>

    <div class="mt-8 text-2xl">
        {{ __('Welcome to the archery project management panel!') }}
    </div>

    <div class="mt-6 text-gray-500">
        {{ __('From this management environment it is possible to create new users, to log in to the front-end application from which measurements can be performed manually.') }}
    </div>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
    <div class="p-6">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laravel.com/docs">{{ __('patients') }}</a></div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://laracasts.com">{{ __('Results') }}</a></div>
        </div>
    </div>

    <div class="p-6 border-t border-gray-200">
        <div class="flex items-center">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://tailwindcss.com/">{{ __('Sessions') }}</a></div>
        </div>
    </div>

    <a href="/api/docs" class="group" target="_blank">
        <div class="p-6 border-t border-gray-200 hover:bg-rf-orange md:border-l">
            <div class="flex items-center">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 group-hover:text-white"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <div class="ml-4 text-lg text-gray-600 group-hover:text-white leading-7 font-semibold">{{ __('API Documentation') }}</div>
            </div>
        </div>
    </a>
</div>
