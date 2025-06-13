<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\JobPost;
use Illuminate\Support\Facades\Auth;

class UploadJobPost extends Component
{
    public string $title = '';
    public string $description = '';

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:30',
        ]);

        JobPost::create([
            'user_id'    => Auth::id(),
            'title'      => $this->title,
            'description'=> $this->description,
        ]);

        session()->flash('message', 'Job Description berhasil disimpan!');
        $this->reset(['title', 'description']);
    }
    
    public function render()
    {
        return view('livewire.upload-job-post')->layout('layouts.app');
    }
}
