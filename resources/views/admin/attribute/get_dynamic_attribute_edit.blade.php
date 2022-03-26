@php
    $attrbuteno = 1;
@endphp
@foreach ($ProductAttribute_data as $key => $ProductAtt)
    @php
        $ProductAttribute = json_decode($ProductAtt['attributes']);
        $ProductAttribute = (array) $ProductAttribute;
    @endphp

        <h2>Attribute {{ $attrbuteno }}</h2>
        @foreach ($Attribute as $item)
            <div class="col-sm-6 mb-3">
                <label class="col-form-label">{{ $item['name'] }} <span class="text-danger">*</span></label>
                <select name="{{ str_replace(' ', '', $item['name']) }}[]" class="form-control select2_dynamic attribute_select">
                    @php
                        $SubAttribute = App\Models\SubAttribute::where('attribute_id', $item['id'])->get();
                    @endphp
                    @foreach ($SubAttribute as $sub_item)
                        @php
                            $selected = array_key_exists($item['name'], $ProductAttribute) &&  $ProductAttribute[$item['name']] == $sub_item['id'] ? 'selected' : '';
                        @endphp
                        <option value="{{ $sub_item['id'] }}" {{ $selected }}>{{ $sub_item['name'] }}</option>
                    @endforeach
                </select>
            </div>
        @endforeach

        <div class="col-sm-6 mb-3">
            <label class="col-form-label">Supplier Price <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="supplier_price[]" placeholder="Supplier Price"
                value="{{ $ProductAttribute['supplier_price'] }}" required />
        </div>

        @if (auth()->user()->type != '2')
            <div class="col-sm-6 mb-3">
                <label class="col-form-label">Admin Price <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="admin_price[]" placeholder="Admin Price"
                    value="{{ $ProductAttribute['admin_price'] }}" required />
            </div>
        @endif

        <div class="col-sm-6 mb-3">
            <label class="col-form-label">SKU <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="sku[]" placeholder="SKU"
                value="{{ $ProductAttribute['sku'] }}" required />
        </div>

        <div class="col-sm-6 mb-3">
            <label class="col-form-label">Supplier Quantity <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="supplier_quantity[]" placeholder="Supplier Quantity"
                value="{{ $ProductAttribute['supplier_quantity'] }}" required />
        </div>

        @if (auth()->user()->type != '2')
            <div class="col-sm-6 mb-3">
                <label class="col-form-label">Admin Quantity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="admin_quantity[]" placeholder="Admin Quantity"
                    value="{{ $ProductAttribute['admin_quantity'] }}" required />
            </div>
        @endif

        @php
            $attrbuteno++;
        @endphp
@endforeach

<div class="col-sm-12 mb-3">
    <button type="button" class="btn btn-primary float_right add_more">+ Add More</button>
</div>
