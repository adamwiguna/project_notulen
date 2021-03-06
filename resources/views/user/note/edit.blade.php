@extends('user.layouts.app')

@section('content')


<form action="{{ route('user.note.update', ['note' => $note]) }}" method="POST" class="container">
    @method('PUT')
    <h4 class=" text-center mt-3 mb-3 text-decoration-underline"> Form Notulen</h4>
    @csrf
    <input name="id" type="hidden" value="{{ $note->id }}">
    <input name="slug" type="hidden" value="{{ $note->slug }}">
    <div class="form-floating mb-3">
        <input name="title" value="{{ old('title', $note->title) }}" type="text" class="form-control  @error('title') is-invalid @enderror" id="floatingtitle" placeholder="title">
        <label for="floatingtitle" class=" text-small small">Nama Kegiatan</label>
        @error('title')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="organizer" value="{{ old('organizer', $note->organizer) }}" type="text" class="form-control @error('organizer') is-invalid @enderror" id="floatingAlias" placeholder="Alias">
        <label for="floatingAlias" class=" text-small small">Penyelenggara</label>
        @error('organizer')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3">
        <input name="location" value="{{ old('location', $note->location) }}" type="text" class="form-control @error('location') is-invalid @enderror" id="floatinglocation" placeholder="location">
        <label for="floatinglocation" class=" text-small small">Lokasi</label>
        @error('location')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-floating mb-3 col-lg-3 col-6 col-md-3">
        <input size="5" name="date" value="{{ old('date', $note->date) }}" type="date" class="form-control @error('date') is-invalid @enderror" id="floatinglocation" >
        <label for="floatinglocation" class=" text-small small">Tanggal</label>
        @error('date')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="floatinglocation" class=" text-small small">Ringkasan / Caption (Bisa Kosong) </label>
        <textarea style="height: 80px" name="description" value="{{ old('description', $note->description) }}" type="text" class="form-control @error('description') is-invalid @enderror" id="floatinglocation" placeholder="description">{{ old('description', $note->description) }}</textarea>
        @error('description')
        <span class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label for="isi" class="mb-2 text-center text-decoration-underline text-bold">Materi yang dibahas</label>
        <input id="body" class="bg-white @error('body') is-invalid @enderror" type="hidden" name="body" value="{{ old('body', $note->content) }}"  placeholder="Materi yang dibahas">
        <trix-editor input="body" class=" bg-white @error('body') is-invalid @enderror" placeholder="Materi yang dibahas" value="{{ old('body', $note->body) }}"></trix-editor>  
        @error('body')
        <div class="invalid-feedback">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
      </div>
    <div class="form-floating">
        <button type="submit" class="btn mt-3 btn-primary"><i class="bi bi-box-arrow-down"></i> Simpan Data</button>
    </div>
</form>

@endsection