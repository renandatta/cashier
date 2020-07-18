@extends('layouts.main')

@section('title')
{{ empty($productCategory) ? 'Tambah' : 'Ubah' }} {{ $title }} -
@endsection

@section('content')
    <div class="container pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ empty($productCategory) ? 'Tambah' : 'Ubah' }} {{ $title }}
        </h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('product_category.save') }}" method="post">
                    @csrf
                    @if(!empty($productCategory))
                        <input type="hidden" name="id" value="{{ $productCategory->id }}">
                    @endif
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ !empty($productCategory) ? $productCategory->name : old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan</label>
                        <textarea name="description" id="description" rows="4" class="form-control" required>{{ !empty($productCategory) ? $productCategory->description : old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('product_category') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
            <div class="card-footer text-right p-2">
                @if(!empty($productCategory))
                    <form action="{{ route('product_category.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $productCategory->id }}">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
