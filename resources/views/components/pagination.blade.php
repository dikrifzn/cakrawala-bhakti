@if ($paginator->hasPages())
    <nav role="navigation" class="flex justify-center mt-14">
        <ul class="inline-flex items-center space-x-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
                        ‹
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}"
                       class="px-3 py-2 rounded-lg bg-white border border-gray-300 hover:border-yellow-500 hover:text-yellow-500 transition">
                       ‹
                    </a>
                </li>
            @endif

            {{-- Numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-gray-500">...</span>
                    </li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-4 py-2 rounded-lg bg-yellow-500 text-white font-medium shadow-sm">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="px-4 py-2 rounded-lg bg-white border border-gray-300 hover:border-yellow-500 hover:text-yellow-500 transition">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}"
                       class="px-3 py-2 rounded-lg bg-white border border-gray-300 hover:border-yellow-500 hover:text-yellow-500 transition">
                       ›
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 cursor-not-allowed">
                        ›
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif
