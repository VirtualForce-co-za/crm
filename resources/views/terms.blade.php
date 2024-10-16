<x-guest-layout>
    <div class="pt-4 bg-gray-100 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
            @if(request()->getHttpHost() == "virtualagents.onemobile.cloud")
                            <img class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" src="virtualagents.onemobile.cloud.png"/>
                        @elseif(request()->getHttpHost() == "127.0.0.1:8000" || request()->getHttpHost() == "crm.virtualforce.co.za")
                            <img class="h-12 w-auto text-white lg:h-16 lg:text-[#FF2D20]" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg" src="crm.virtualforce.co.za.png"/>
                        @endif
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg prose dark:prose-invert">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
