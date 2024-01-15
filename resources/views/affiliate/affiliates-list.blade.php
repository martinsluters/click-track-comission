<x-welcome-layout>
<div class="">

    @foreach($users as $user)
    <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
        <div>
            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h2>

             <ul class="list-none p-7">
                 <li class="mb-2">
                     <a href="{{ route('statistics.tabular', ['user' => $user->id]) }}" class="mt-4 underline text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        Tabular Data Representation
                     </a>
                 </li>
                 <li class="mb-2">
                     <a href="{{ route('statistics.graphical', ['user' => $user->id]) }}" class="mt-4 underline text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                        Graphical Data Representation
                    </a>
                 </li>
             </ul>
        </div>
    </div>
    @endforeach
    {{ $users->links() }}
</div>
</x-welcome-layout>
