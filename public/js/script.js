
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

let timerInterval;
let treasureCount = 0;
let missCount = 0;
let gridCound = 0;

$('#game-form').on('submit', function (e) {
    e.preventDefault(); 

    treasureCount = 0;
    missCount = 0;
    $('.error-message').remove();

    let isValid = true;

    const userName = $('#user_name').val().trim();
    const gridSize = $('#grid_size').val();

    if (userName === '') {
        showError('#user_name', 'User Name is required.');
        isValid = false;
    } else if (userName.length > 255) {
        showError('#user_name', 'User Name cannot exceed 255 characters.');
        isValid = false;
    }

    if (gridSize === '') {
        showError('#grid_size', 'Grid Size is required.');
        isValid = false;
    } else if (isNaN(gridSize) || gridSize < 3 || gridSize > 10) {
        showError('#grid_size', 'Grid Size must be a number between 3 and 10.');
        isValid = false;
    }

    if (isValid) {
        $.post('/start', $(this).serialize(), function (response) {
            const grid = response.grid;
            gridCound = response.grid.length;
            const container = $('#grid-container');
            container.empty();

            const gridSize = grid.length;
            container.css('grid-template-columns', `repeat(${gridSize}, 1fr)`);

            for (let i = 0; i < grid.length; i++) {
                for (let j = 0; j < grid[i].length; j++) {
                    container.append(`<div class="cell" data-x="${i}" data-y="${j}"></div>`);
                }
            }

            $('#game-section').removeClass('d-none');
            startTimer(60);
        });
    }
});

$(document).on('click', '.cell', function () {
    const x = $(this).data('x');
    const y = $(this).data('y');

    $.post('/cell-click', {
        x,
        y
    }, function (response) {
        const cell = $(`.cell[data-x="${x}"][data-y="${y}"]`);

        if (response.status === 'treasure') {
            cell.addClass('success').text('💎').attr('data-found', 'true');
            treasureCount++;
        } else {
            cell.addClass('fail').text('👎').attr('data-found', 'true');
            missCount++;
        }
        updateCounters();
    });
});

function startTimer(duration) {
    let timer = duration;
    const timerDisplay = $('#timer');
    timerDisplay.text(`Time Left: ${timer}s`);

    timerInterval = setInterval(function () {
        timer--;
        timerDisplay.text(`Time Left: ${timer}s`);

        if (timer <= 0) {
            saveGameState(treasureCount, missCount);
        }
    }, 1000);
}

function updateCounters() {
    $('#treasure-count').text(`💎: ${treasureCount}`);
    $('#miss-count').text(`👎: ${missCount}`);
    if (gridCound == treasureCount) {
        saveGameState(treasureCount, missCount);
    }
}

function showError(selector, message) {
    const inputElement = $(selector);
    inputElement.addClass('is-invalid');
    inputElement.after(`<div class="text-danger error-message">${message}</div>`);
}

function saveGameState(treasuresFound, misses) {
    $.ajax({
        url: '/save-game',
        method: 'POST',
        data: {
            treasures_found: treasuresFound,
            misses: misses,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            if (response && response.status === 200 && response.random_number) {
                window.location = '/treasure-hunt/' + response.random_number;
            } else {
                console.error('Unexpected response format:', response);
            }
        },
        error: function(xhr) {
            console.error('Error saving game:', xhr.responseText);
        },
    });
}

$('input').on('focus', function () {
    $(this).removeClass('is-invalid');
    $(this).siblings('.error-message').remove(); 
});

$('.restartButton').on('click', function () {
    location.reload();
});