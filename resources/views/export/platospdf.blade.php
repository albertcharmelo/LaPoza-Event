<style>
    @import url("https://fonts.googleapis.com/css?family=Nunito:400,600,700");

    .titulo {
        font-family: 'Nunito', sans-serif;
        font-size: 30px;
        text-align: center;
        color: #000000;
        margin-top: 20px;

    }

    .titulo:first-letter {
        text-transform: capitalize;
    }

    .stack-plato {
        padding: 10px;
        margin: 10px;
        border: 1px solid #fd683e;
        border-radius: 5px;
    }

    .plato {
        list-style: none;
        font-family: 'Nunito', sans-serif;
        font-size: 20px;
        color: #000000;
        margin-top: 20px;
        border: 1px solid #f2f2f2;
        padding: 10px;
        border-radius: 5px;

    }

    .plato p {
        margin: 0;
        padding: 0;
    }

    .plato span {
        font-weight: bold;
    }
</style>

<body>

    @foreach ($platos as $menu)
    <div class="stack-plato">

        <h1 class="titulo">{{ $menu['titulo'] }}</h1>
        <ul>
            @foreach ($menu['platos'] as $plato)
            <li class="plato">
                <p><span class="">Nombre</span>: {{ $plato['plato'] }}</p>
                <p><span class="">Cantidad</span>: {{ $plato['cantidad'] }}</p>
            </li>
            @endforeach
        </ul>

    </div>
    @endforeach




</body>