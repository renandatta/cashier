@extends('layouts.main')

@section('title')
{{ empty($rawMaterial) ? 'Tambah' : 'Ubah' }} {{ $title }} -
@endsection

@section('content')
    <div class="container pt-4">
        <h3>
            <img src="{{ asset('img/category.png') }}" alt="" class="img-fluid" style="height: 28px">
            {{ empty($rawMaterial) ? 'Tambah' : 'Ubah' }} {{ $title }}
        </h3>
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('raw_material.save') }}" method="post">
                    @csrf
                    @if(!empty($rawMaterial))
                        <input type="hidden" name="id" value="{{ $rawMaterial->id }}">
                    @endif
                    <div class="form-group">
                        <label for="code">Kode Bahan Baku</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ !empty($rawMaterial) ? $rawMaterial->code : old('code') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ !empty($rawMaterial) ? $rawMaterial->name : old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="raw_material_category_id">Kategori</label>
                        <select name="raw_material_category_id" id="raw_material_category_id" class="form-control select2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ !empty($rawMaterial) && $rawMaterial->raw_material_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tag">Label</label>
                        <input type="text" class="form-control" id="tag" name="tag" value="{{ !empty($rawMaterial) ? $rawMaterial->tag : old('tag') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <input type="text" class="form-control" id="unit" name="unit" value="{{ !empty($rawMaterial) ? $rawMaterial->unit : old('unit') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{ !empty($rawMaterial) ? $rawMaterial->price : old('price') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Keterangan</label>
                        <textarea name="description" id="description" rows="4" class="form-control" required>{{ !empty($rawMaterial) ? $rawMaterial->description : old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('raw_material') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
            <div class="card-footer text-right p-2">
                @if(!empty($rawMaterial))
                    <form action="{{ route('raw_material.delete') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $rawMaterial->id }}">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
