<div class="max-w-2xl mx-auto p-4 bg-white rounded-xl shadow-md">
    <h2 class="text-xl font-bold mb-4">Upload Job Description</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save" class="space-y-4">
        <div>
            <label class="block font-semibold">Judul Pekerjaan</label>
            <input type="text" wire:model.defer="title"
                class="w-full border rounded px-3 py-2" placeholder="Contoh: Software Engineer" />
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-semibold">Deskripsi Pekerjaan (JD)</label>
            <textarea wire:model.defer="description"
                rows="10" class="w-full border rounded px-3 py-2"
                placeholder="Tempel isi job description di sini..."></textarea>
            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan JD
        </button>
    </form>
</div>
