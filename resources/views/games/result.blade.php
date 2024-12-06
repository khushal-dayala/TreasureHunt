<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>Treasure Hunt</title>
</head>

<body>
    <div id="result-section" class="mt-5">
        <div class="result-card p-4 text-center">
            <h1 class="mb-4">🎮 Game Over!</h1>
            <h2 class="user-name mb-4">Player: <span>{{$game->user_name}}</span></h2>
            <div class="result-status mb-4">

            </div>
            <div class="result-details d-flex justify-content-center mb-4">
                <div class="badge bg-success mx-2 p-3">
                    💎 Treasures Found: <span>{{$game->treasures_found}}</span>
                </div>
                <div class="badge bg-danger mx-2 p-3">
                    👎 Misses: <span>{{$game->misses}}</span>
                </div>
                <div class="badge bg-warning mx-2 p-3">
                    @if($game->treasures_found == $game->grid_size)
                    Winner
                    @else
                    Lost
                    @endif
                </div>
            </div>
            <a href="{{ route('home') }}" class="btn btn-primary restartButton">Restart Game</a>
        </div>
    </div>

</body>

</html>