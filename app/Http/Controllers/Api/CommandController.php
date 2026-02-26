<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * SECURITY WARNING: Command execution capabilities have been restricted.
 * Only specific whitelisted commands are allowed for security purposes.
 */
class CommandController extends Controller
{
    // Whitelist of allowed commands - add only safe commands here
    private const ALLOWED_COMMANDS = [
        // 'migrate',
        // 'cache:clear',
        // Empty by default - use with extreme caution
    ];

    public function runCommand(Request $request)
    {
        // This endpoint should only be used in development and must be disabled in production
        if (!config('app.debug')) {
            return response()->json([
                'message' => 'Command execution is disabled in production mode.',
                'status' => 'error'
            ], 403);
        }

        $validated = $request->validate([
            'command' => ['required', 'string']
        ]);

        $command = $validated['command'];

        // Check if command is in whitelist
        if (!in_array($command, self::ALLOWED_COMMANDS)) {
            return response()->json([
                'message' => 'This command is not allowed. Only whitelisted commands can be executed.',
                'status' => 'error',
                'allowed_commands' => self::ALLOWED_COMMANDS
            ], 403);
        }

        try {
            // Run the Artisan command
            \Illuminate\Support\Facades\Artisan::call($command);
            $output = \Illuminate\Support\Facades\Artisan::output();

            return response()->json([
                'message' => 'Command executed successfully',
                'output' => $output,
                'status' => 'success'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Command execution failed',
                'error' => $e->getMessage(),
                'status' => 'error'
            ], 500);
        }
    }
}
