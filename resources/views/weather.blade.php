@include('components.header')

<div class="weather-container container">
    @if(isset($error) && $error)
        <div class="alert alert-danger">
            <strong>Erro:</strong> {{ $error }}
        </div>
    @else
        <h1>Clima em {{ $location['name'] ?? 'Localização desconhecida' }}, {{ $location['country'] ?? 'País desconhecido' }}</h1>

        <div class="weather-details content-block">
            <p class="consult-date">{{ $weather['observation_time'] ?? '' }}</p>

            <div class="temperature {{ $weather['status'] ?? 'good' }}">
                {{ $weather['temperature'] ?? 'Temperatura indisponível' }}°C
            </div>
            <div class="description">
                <i class="fas fa-cloud-sun"></i> 
                {{ $weather['weather_descriptions'][0] ?? 'Descrição indisponível' }}
            </div>
            @if(isset($weather['weather_icons']) && is_array($weather['weather_icons']))
                <img src="{{ $weather['weather_icons'][0] }}" alt="Ícone do Clima" class="weather-icon">
            @endif
            
            <div class="additional-info">
                <p><i class="fas fa-wind"></i> <strong>Vento:</strong> {{ $weather['wind_speed'] ?? 'Vento indisponível' }} km/h ({{ $weather['wind_dir'] ?? 'Não indisponível' }})</p>
                <p><i class="fas fa-tint"></i> <strong>Umidade:</strong> {{ $weather['humidity'] ?? 'Umidade indisponível' }}%</p>
                <p><i class="fas fa-tachometer-alt"></i> <strong>Pressão:</strong> {{ $weather['pressure'] ?? 'Pressão indisponível' }} hPa</p>
                <p><i class="fas fa-eye"></i> <strong>Visibilidade:</strong> {{ $weather['visibility'] ?? 'Visibilidade indisponível' }} km</p>
                <p><i class="fas fa-cloud"></i> <strong>Nuvens:</strong> {{ $weather['cloudcover'] ?? 'Disposição das nuvens indisponível' }}%</p>
                <p><i class="fas fa-thermometer-half"></i> <strong>Sensação Térmica:</strong> {{ $weather['feelslike'] ?? 'Sensação Térmica indisponível' }}°C</p>
                <p><i class="fas fa-sun"></i> <strong>Índice UV:</strong> {{ $weather['uv_index'] ?? 'Índice UV indisponível' }}</p>
            </div>
            <div id="message"></div>
            <div class="buttons">
                <button id="save-weather" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Clima</button>
                <a href="{{ url('/') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
            </div>
        </div>


    @endif
</div>

@include('components.footer')
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/weather.js') }}"></script>
