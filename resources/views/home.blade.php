@include('components.header')

<div class="center-container container">
    <h1>Busque o clima na sua região</h1>
    <div class="outside-form content-block">
        <div class="form-group">
            <label for="zip-code">Digite seu CEP:</label>
            <input type="text" id="zip-code" name="zip-code" class="form-control input-zip-code weather-zip-code" placeholder="CEP" required>
        </div>
        <form action="/weather" id="weather-search" method="POST">
            @csrf
            <div class="form-group">
                <label for="city">Cidade:</label>
                <input type="text" id="city" name="city" class="form-control" placeholder="Cidade" required>
            </div>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('js/home.js') }}"></script>
@include('components.footer')

