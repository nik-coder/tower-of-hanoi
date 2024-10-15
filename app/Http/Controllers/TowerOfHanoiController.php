<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TowerOfHanoiController extends Controller
{
    // Game state
    private static array $gameState = [
        'pegs' => [
            [7, 6, 5, 4, 3, 2, 1], // First peg with all disks
            [], // Second peg (empty)
            []  // Third peg (empty)
        ],
        'finished' => false
    ];

    /**
     * Get the current state of the game
     *
     * @return JsonResponse
     */
    public function getState(): JsonResponse
    {
        return response()->json(self::$gameState);
    }

    /**
     * Move a disk from one peg to another
     *
     * @param Request $request
     * @param int $from
     * @param int $to
     * @return JsonResponse
     */
    public function move(Request $request, int $from, int $to): JsonResponse
    {
        $from--;
        $to--;

        // Check if the game is already finished
        if (self::$gameState['finished']) {
            return response()->json(['error' => 'Game is already finished'], 400);
        }

        // Check if the move is valid
        if (!$this->isValidMove($from, $to)) {
            return response()->json(['error' => 'Invalid move'], 400);
        }

        // Perform the move
        $disk = array_pop(self::$gameState['pegs'][$from]);
        array_push(self::$gameState['pegs'][$to], $disk);

        // Check if the game is finished
        if (count(self::$gameState['pegs'][2]) == 7) {
            self::$gameState['finished'] = true;
        }

        return response()->json(['message' => 'Move successful', 'state' => self::$gameState]);
    }

    /**
     * Check if a move is valid
     *
     * @param int $from
     * @param int $to
     * @return bool
     */
    private function isValidMove(int $from, int $to): bool
    {
        if ($from < 0 || $from > 2 || $to < 0 || $to > 2) {
            return false;
        }

        if (empty(self::$gameState['pegs'][$from])) {
            return false;
        }

        if (!empty(self::$gameState['pegs'][$to]) && end(self::$gameState['pegs'][$from]) > end(self::$gameState['pegs'][$to])) {
            return false;
        }

        return true;
    }
}
