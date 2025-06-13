<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Resume;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadResume extends Component
{

    use WithFileUploads;

    public $resumeFile;
    public $resumeText;

    public function save()
    {
        $this->validate([
            'resumeFile' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'resumeText' => 'nullable|string|min:30',
        ]);

        $textContent = $this->resumeText;

        if ($this->resumeFile) {
            $path = $this->resumeFile->store('resumes', 'public');

            // Simulasi ekstraksi file (nanti kita ganti pakai text extractor)
            $textContent = 'Isi CV dari file ' . $this->resumeFile->getClientOriginalName();
        } else {
            $path = null;
        }

        Resume::create([
            'user_id'     => Auth::id(),
            'file_path'   => $path,
            'text_content'=> $textContent,
        ]);

        session()->flash('message', 'Resume berhasil diunggah!');
        $this->reset(['resumeFile', 'resumeText']);
    }
    
    public function render()
    {
        return view('livewire.upload-resume')->layout('layouts.app');
    }
}
