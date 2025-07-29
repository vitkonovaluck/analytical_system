@php
    app()->setLocale('uk');
@endphp

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Аналітика товарів</h1>

        <form method="GET" class="mb-3">
            <label for="catalog_id">Фільтр по каталогу:</label>
            <select name="catalog_id" id="catalog_id" class="form-select" onchange="this.form.submit()">
                <option value="">— Усі каталоги —</option>
                @foreach ($catalogs as $catalog)
                    <option value="{{ $catalog->id }}" {{ $catalogId == $catalog->id ? 'selected' : '' }}>
                        {{ $catalog->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-sm align-middle">
                <thead class="table-dark">
                <tr>
                    <th>Firma ID<br>Linker ID</th>
                    <th>Назва<br> SKU / EAN</th>
                    <th>К-сть (Firma)<br>К-сть (Linker)</th>
                    <th>Ціна (Firma)<br>Ціна (Linker)</th>
                    <th>Продажів всього</th>
                    <th>Сер. за 7 днів</th>
                    <th>Продажі по джерелах</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($products as $p)
                    <tr>
                        <td>{{ $p['firma_id'] }}<br>{{ $p['linker_id'] ?? '—' }}</td>
                        <td>{{ $p['name'] }}<br>{{ $p['sku'] }} / {{ $p['ean'] }}</td>
                        <td>
                            {{ $p['firma_quantity'] }}<br>
                            <span class="{{ $p['firma_quantity'] !== $p['linker_quantity'] ? 'text-danger fw-bold' : '' }}">
                                {{ $p['linker_quantity'] ?? '—' }}
                            </span>
                        </td>
                        <td>
                            {{ $p['firma_price'] }}<br>
                            <span class="{{ $p['firma_price'] != $p['linker_price'] ? 'text-danger fw-bold' : '' }}">
                                {{ $p['linker_price'] ?? '—' }}
                            </span>
                        </td>
                        <td>{{ $p['total_sales'] }}</td>
                        <td>{{ $p['avg_sales_7d'] }}</td>
                        <td>
                            @foreach ($p['sales_by_source'] as $source => $count)
                                <div>{{ $source }}: {{ $count }}</div>
                            @endforeach
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="11" class="text-center">Немає даних</td></tr>
                @endforelse
                </tbody>
            </table>
            {{ $products->links() }}
        </div>
    </div>
@endsection
