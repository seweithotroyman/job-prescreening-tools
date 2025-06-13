<div class="max-w-2xl mx-auto p-4 bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Upload Resume / CV</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4" enctype="multipart/form-data">
        <div>
            <label class="block font-semibold">Unggah File (.pdf / .docx)</label>
            <input type="file" wire:model="resumeFile" class="w-full border rounded px-3 py-2" />
            @error('resumeFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="text-center text-gray-500 font-semibold">ATAU</div>

        <div>
            <label class="block font-semibold">Tempel Isi Resume</label>
            <textarea wire:model.defer="resumeText"
                rows="10" class="w-full border rounded px-3 py-2"
                placeholder="Paste isi CV kamu di sini..."></textarea>
            @error('resumeText') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Simpan Resume
        </button>
    </form>
</div>
