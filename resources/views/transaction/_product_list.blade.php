<div class="row">
    @php($category_id = '')
    @foreach($products as $product)
        <input type="hidden" class="product_id" value="{{ $product->id }}" data-price="{{ $product->price }}">
        @if($category_id != $product->product_category_id)
            <div class="col-12">
                <h3>{{ $product->product_category->name }}</h3>
            </div>
        @endif
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body p-1">
                    <h5>{{ $product->name }}<br>Rp.{{ format_number($product->price) }}</h5>
                    <hr class="mt-1 mb-2">
                    <div class="row">
                        <div class="col-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button class="btn btn-secondary btn-sm" onclick="decreaseQty('{{ $product->id }}')">-</button>
                                </div>
                                <input type="text" class="form-control form-control-sm text-center" id="qty_product_{{ $product->id }}" value="1" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary btn-sm" onclick="increaseQty('{{ $product->id }}')">+</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 text-right">
                            <button type="button" class="btn btn-sm btn-primary" onclick="addProduct('{{ $product->id }}', '{{ $product->price }}')">Tambahkan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php($category_id = $product->product_category_id)
    @endforeach
</div>
