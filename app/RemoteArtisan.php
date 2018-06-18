<?php namespace App;

use Dotenv\Dotenv;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * Class RemoteArtisan
 * @package App
 */
class RemoteArtisan
{
    /**
     * Implements an interface similar to Artisan::call.
     *
     * @param string $path The full path to the remote application's root
     * @param string $command The Artisan command to run, e.g. 'vendor:publish'
     * @param array $parameters The parameters to pass to the artisan command
     * @param string $php The path to the PHP executable
     * @return mixed
     * @throws ProcessFailedException
     */
    public static function call($path, $command, $parameters = [], $php = null)
    {
        // Prepare parameters for appending
        $options = '';
        foreach ($parameters as $name => $value) {
            $value = '"'.$value.'"';

            if (is_int($name)) {
                $options .= " $value";
            } else {
                $value = ($value !== true ? "=$value" : '');
                $options .= " {$name}{$value}";
            }
        }

        // Swap out the full path to the current PHP executable binary
        if (! $php) {
            $php = PHP_BINDIR . '/php';
        }

        // Load .env for the target app
        $env = new Dotenv($path);
        $env->overload();

        // Append the artisan command to the path
        $artisan = Str::finish($path, '/').'artisan';

        // Build up the final command
        $command = "{$php} {$artisan} {$command}{$options}";

        // Run the command in its environment
        $process = new Process($command, $path);
        $process->run();

        // Restore original environment
        $env = new Dotenv(base_path());
        $env->overload();

        // If there was no response
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
