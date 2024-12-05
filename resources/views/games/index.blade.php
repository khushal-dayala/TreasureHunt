<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Treasure Hunt</title>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-card p-4">
                    <h1 class="text-center mb-4">🎯 Treasure Hunt Game</h1>
                    <form id="game-form">
                        @csrf
                        <div class="mb-3">
                            <label for="user_name" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter your name">
                        </div>
                        <div class="mb-3">
                            <label for="grid_size" class="form-label">Grid Size (3-10)</label>
                            <input type="number" class="form-control" id="grid_size" name="grid_size" placeholder="Choose a grid size">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold">🚀 Start Game</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="game-section" class="mt-5 d-none">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>🏆 Find the Treasure!</h2>
                <div class="d-flex align-items-center">
                    <div class="badge bg-success me-3 count" id="treasure-count">💎: 0</div>
                    <div class="badge bg-warning me-3 count" id="miss-count">👎: 0</div>
                    <div class="timer badge bg-danger" id="timer">Time Left: 60s</div>
                </div>
            </div>

            <div id="grid-container"></div>
        </div>
    </div>

    <!-- time over model  -->
    <div class="modal fade" id="timeOverModal" tabindex="-1" aria-labelledby="timeOverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="timeOverModalLabel">⏰ Time's Up!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sorry, your time is up! Better luck next time.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary restartButton" id="restartButton">Restart</button>
                </div>
            </div>
        </div>
    </div>

    <!-- win the game model -->
    <div class="modal fade" id="winGameModal" tabindex="-1" aria-labelledby="winGameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="winGameModalLabel">🎉 Congratulations!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You found all the treasures! You won the game!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary restartButton" id="restartButton">Restart</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
