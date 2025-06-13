<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use App\Models\Resume;
use App\Models\ScreeningResult;
use App\Services\GptJobFitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobFitController extends Controller
{
    public function analyze(Request $request, JobPost $jobPost, Resume $resume, GptJobFitService $gpt)
    {
        abort_if($jobPost->user_id !== Auth::id() || $resume->user_id !== Auth::id(), 403);

        $response = $gpt->analyzeFit($jobPost->description, $resume->text_content);

        $fit_score = $response['fit_score'] ?? null;
        $matched = $response['matched_keywords'] ?? [];
        $missing = $response['missing_keywords'] ?? [];
        $summary = $response['ai_summary'] ?? null;

        // Validasi isian WAJIB: fit_score dan matched_keywords
        if ($fit_score === null) {
            throw new \Exception("GPT tidak mengembalikan skor kecocokan (fit_score)");
        }

        // dd($aiResult['fit_score']);

        // Simpan ke database
        $result = ScreeningResult::create([
            'user_id'          => Auth::id(),
            'job_post_id'      => $jobPost->id,
            'resume_id'        => $resume->id,
            'fit_score'        => $fit_score,
            'matched_keywords' => $matched,
            'missing_keywords' => $missing,
            'ai_summary'       => $summary,
        ]);

        return redirect()->route('jobfit.show', [$jobPost, $resume])
            ->with('success', 'Analisa selesai!');
    }

    public function show(JobPost $jobPost, Resume $resume)
    {
        abort_if($jobPost->user_id !== Auth::id() || $resume->user_id !== Auth::id(), 403);

        $result = ScreeningResult::where('job_post_id', $jobPost->id)
            ->where('resume_id', $resume->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('prompts.jobfit', [
            'jobPost'  => $jobPost,
            'resume'   => $resume,
            'analysis' => $result, // kirim seluruh objek biar fleksibel di blade
        ]);
    }

    public function chatGpt(){
        dd(config('services.openai.key'));
        $openai_api_key = config('services.openai.key');  // Ganti dengan API key Anda
        $url = 'https://api.openai.com/v1/chat/completions';

        $data = [
            "model" => "gpt-4.1",
            "messages" => [
                [
                    "role" => "developer",
                    "content" => "You are a helpful assistant."
                ],
                [
                    "role" => "user",
                    "content" => "Hello!"
                ]
            ]
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);

        // Set opsi cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $openai_api_key
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Eksekusi permintaan dan simpan respon
        $response = curl_exec($ch);

        // Cek apakah ada error
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            // Menampilkan hasil respons dari API
            echo $response;
        }

        // Tutup cURL
        curl_close($ch);
    }
}
