<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GptJobFitService
{
    public static function analyze($jd, $cv): array
    {
        $prompt = view('prompts.jobfit', compact('jd', 'cv'))->render();

        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt]
                ],
                'temperature' => 0.3,
            ]);

        $text = $response['choices'][0]['message']['content'] ?? null;

        // Coba parse JSON dari teks
        try {
            return json_decode($text, true);
        } catch (\Throwable $e) {
            return ['error' => 'Gagal membaca hasil GPT', 'raw' => $text];
        }
    }

    public function analyzeFit(string $jobDescription, string $resumeText): array
    {
        $prompt = <<<PROMPT
        Saya akan memberikan dua teks:
        1. Job Description (JD)
        2. Resume (CV)

        Tugas Anda:
        1. Ambil 10–15 kata kunci penting dari JD
        2. Bandingkan dengan isi CV
        3. Buat:
        - Skor kecocokan antara 1 sampai 10
        - Daftar keyword yang cocok (match)
        - Daftar keyword yang hilang (gap)
        - Ringkasan evaluasi singkat
        - Saran peningkatan jika ada

        ⚠️ Penting: Berikan hasil dalam format **JSON MURNI** tanpa penjelasan tambahan di luar JSON.

        Contoh format yang **WAJIB** diikuti:
        {
        "fit_score": 8,
        "matched_keywords": ["Python", "Teamwork", "REST API"],
        "missing_keywords": ["Leadership", "Docker"],
        "ai_summary": "CV cukup sesuai, tapi kurang pengalaman manajerial dan DevOps.",
        "suggestion": "Tingkatkan pengalaman dengan tools seperti Docker atau CI/CD."
        }

        === JOB DESCRIPTION ===
        $jobDescription

        === RESUME ===
        $resumeText
        PROMPT;

                $response = Http::withToken(config('services.openai.key'))
                    ->post('https://api.openai.com/v1/chat/completions', [
                        'model' => 'gpt-4',
                        'messages' => [
                            ['role' => 'user', 'content' => $prompt],
                        ],
                        'temperature' => 0.3,
                    ]);

                $result = $response['choices'][0]['message']['content'] ?? null;

                $data = json_decode($result, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error("Invalid JSON from GPT", ['response' => $result]);
                    throw new \Exception("Hasil dari GPT bukan JSON valid: " . json_last_error_msg());
                }

                return $data;
    }
}
