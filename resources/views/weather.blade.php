@include('components.header')

<div class="weather-container container">
    <h1>Clima em {{ $location['name'] }}, {{ $location['country'] }}</h1>
    
    <div class="weather-details content-block">
        <p><i class="fas fa-calendar-day"></i> <strong>Data e Hora Local:</strong> {{ $weather['observation_time'] }}</p>
        <p><i class="fas fa-temperature-high"></i> <strong>Temperatura:</strong> {{ $weather['temperature'] }}°C</p>
        <p><i class="fas fa-cloud-sun"></i> <strong>Descrição:</strong> {{ $weather['weather_descriptions'][0] }}</p>
        <p><i class="fas fa-wind"></i> <strong>Vento:</strong> {{ $weather['wind_speed'] }} km/h ({{ $weather['wind_dir'] }})</p>
        <p><i class="fas fa-tint"></i> <strong>Umidade:</strong> {{ $weather['humidity'] }}%</p>
        <p><i class="fas fa-tachometer-alt"></i> <strong>Pressão:</strong> {{ $weather['pressure'] }} hPa</p>
        <p><i class="fas fa-eye"></i> <strong>Visibilidade:</strong> {{ $weather['visibility'] }} km</p>
        <p><i class="fas fa-cloud"></i> <strong>Nuvens:</strong> {{ $weather['cloudcover'] }}%</p>
        <p><i class="fas fa-thermometer-half"></i> <strong>Sentimento Térmico:</strong> {{ $weather['feelslike'] }}°C</p>
        <p><i class="fas fa-sun"></i> <strong>Índice UV:</strong> {{ $weather['uv_index'] }}</p>
        @foreach ($weather['weather_icons'] as $icon)
            <img src="{{ $icon }}" alt="Ícone do Clima" class="weather-icon">
        @endforeach
        <div id="message"></div>
        <div class="buttons">
            <button id="save-weather" class="btn btn-primary"><i class="fas fa-save"></i> Salvar Clima</button>
            <a href="{{ url('/') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar</a>
        </div>
    </div>
</div>


@include('components.footer')
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/weather.js') }}"></script>
