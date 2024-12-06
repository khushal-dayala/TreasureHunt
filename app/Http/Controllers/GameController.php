<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameCellCheckRequest;
use App\Http\Requests\GameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Game;

class GameController extends Controller
{
    public function index()
    {
        return view('games.index');
    }

    public function startGame(GameRequest $request)
    {
        $gridSize = $request->grid_size;
        $grid = array_fill(0, $gridSize, array_fill(0, $gridSize, null));
        $treasures = $this->placeTreasures($gridSize);

        Session::put('game', [
            'user_name' => $request->user_name,
            'grid_size' => $gridSize,
            'grid' => $grid,
            'treasures' => $treasures,
            'treasures_found' => 0,
            'misses' => 0,
        ]);

        return response()->json([
            'grid' => $grid,
            'treasures' => $treasures,
        ]);
    }

    private function placeTreasures($gridSize)
    {
        $positions = [];
        while (count($positions) < $gridSize) {
            $position = [rand(0, $gridSize - 1), rand(0, $gridSize - 1)];
            if (!in_array($position, $positions)) {
                $positions[] = $position;
            }
        }
        return $positions;
    }

    public function processClick(GameCellCheckRequest $request)
    {
        $game = Session::get('game');
        
        $x = $request->x;
        $y = $request->y;

        if (in_array([$x, $y], $game['treasures'])) {
            $game['grid'][$x][$y] = 'treasure';
            $game['treasures_found']++;
        } else {
            $game['grid'][$x][$y] = 'miss';
            $game['misses']++;
        }

        Session::put('game', $game);

        return response()->json([
            'status' => $game['grid'][$x][$y],
            'treasures_found' => $game['treasures_found'],
            'misses' => $game['misses'],
        ]);
    }

    public function showResult($randomNumber)
    {
        $game = Game::where('random_number', $randomNumber)->firstOrFail();
        return view('games.result', ['game' => $game]);
    }

    public function saveGame(Request $request)
    {
        $gameData = Session::get('game');

        if (!$gameData) {
            return response()->json(['error' => 'No game data found in session.'], 400);
        }

        $randomNumber = uniqid();

        Game::create([
            'user_name' => $gameData['user_name'],
            'grid_size' => $gameData['grid_size'],
            'grid_state' => json_encode($gameData['grid']),
            'treasures' => json_encode($gameData['treasures']),
            'treasures_found' => $request->treasures_found,
            'misses' => $request->misses,
            'random_number' => $randomNumber,
        ]);

        Session::forget('game');

        return response()->json(['status' => 200, 'random_number' => $randomNumber]);
    }
}
