<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">📊 Evaluasi Kecocokan JD vs Resume</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Job Post Detail --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">📝 Job Description</h2>
            <p class="text-gray-800 whitespace-pre-line">{{ $jobPost->description }}</p>
        </div>

        {{-- Resume Detail --}}
        <div class="bg-white shadow rounded p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">📎 Resume</h2>
            <p class="text-gray-800 whitespace-pre-line">{{ $resume->text_content }}</p>
        </div>

        {{-- Tombol Analisa --}}
        <form method="POST" action="{{ route('jobfit.analyze', ['jobPost' => $jobPost->id, 'resume' => $resume->id]) }}">
            @csrf
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
                🔍 Analisa Sekarang
            </button>
        </form>

        {{-- Hasil GPT --}}
        @if ($analysis)
            <div class="mt-8 bg-white border shadow rounded-lg p-6">
                <h3 class="text-xl font-bold text-blue-700 flex items-center gap-2 mb-4">
                    🎯 Hasil Analisis AI
                </h3>

                {{-- Fit Score --}}
                @php
                    $score = $analysis['fit_score'];
                    $barColor = match (true) {
                        $score <= 3 => 'bg-red-600',
                        $score <= 6 => 'bg-yellow-600',
                        default     => 'bg-green-600',
                    };
                @endphp
                <div class="mb-4">
                    <p class="font-semibold text-gray-700 mb-1">Fit Score: {{ $analysis['fit_score'] }}/10</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                        <div class="{{ $barColor }} h-2.5 rounded-full" style="width: {{ $analysis['fit_score'] * 10 }}%"></div>
                    </div>
                </div>

                {{-- Matched Keywords --}}
                <div class="mb-4">
                    <p class="font-semibold text-green-600 mb-2">✅ Matched Keywords</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($analysis['matched_keywords'] as $keyword)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                {{ $keyword }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Missing Keywords --}}
                <div class="mb-4">
                    <p class="font-semibold text-red-600 mb-2">⚠️ Missing Keywords</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($analysis['missing_keywords'] as $keyword)
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium shadow-sm">
                                {{ $keyword }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- AI Summary --}}
                <div class="mb-2">
                    <p class="font-semibold text-blue-600 mb-1">🧠 AI Summary</p>
                    <p class="text-gray-800 whitespace-pre-line">
                        {{ $analysis['ai_summary'] }}
                    </p>
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
