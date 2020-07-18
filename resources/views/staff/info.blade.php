@extends('layouts.main')

@section('title')
{{ empty($staff) ? 'Tambah' : 'Ubah' }} {{ $title }} -
@endsection

@section('content')
    <div class="container pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ empty($staff) ? 'Tambah' : 'Ubah' }} {{ $title }}
        </h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('staff.save') }}" method="post">
                    @csrf
                    @if(!empty($staff))
                        <input type="hidden" name="id" value="{{ $staff->id }}">
                    @endif
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ !empty($staff) ? $staff->name : old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="no_id">NIK</label>
                        <input type="text" class="form-control" id="no_id" name="no_id" value="{{ !empty($staff) ? $staff->no_id : old('no_id') }}" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('staff') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
            <div class="card-footer text-right p-2">
                @if(!empty($staff))
                    <form action="{{ route('staff.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $staff->id }}">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
