@include('components.header')

<div class="weather-records-container container">
    <h1>Climas Salvos</h1>

    @if ($latestRecords->isEmpty())
        <h1>Nenhum clima salvo encontrado.</h1>
    @else
        <div class="content-block">
            <div class="form-group filter-group">
                <label for="filter-text" class="filter-label">Filtrar:</label>
                <input type="text" id="filter-text" class="form-control filter-input" placeholder="Digite para filtrar registros...">
            </div>
            <table class="table records-table">
                <thead>
                    <tr>
                        <th>Selecionar</th>
                        <th>Cidade</th>
                        <th>Temperatura</th>
                        <th>Descrição</th>
                        <th>Data e Hora</th>
                    </tr>
                </thead>
                <tbody id="records-table">
                    @foreach ($latestRecords as $record)
                        <tr data-id="{{ $record->encoded_id }}" data-country="{{ $record->country }}" data-city="{{ $record->city }}">
                            <td><input type="checkbox" class="record-checkbox" data-id="{{ $record->encoded_id }}"></td>
                            <td>{{ $record->city }}</td>
                            <td>{{ $record->temperature }}°C</td>
                            <td>{{ json_decode($record->weather_descriptions)[0] }}</td>
                            <td>{{ $record->saved_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="charts-container" style="display: none;">
            <h1>Comparação de Dados</h1>
            <canvas id="temperature-chart"></canvas>
        </div>
    @endif
</div>

@include('components.footer')
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/weather-records.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
