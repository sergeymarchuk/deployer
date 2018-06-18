<?php namespace App\Service;

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
     * @var $path
     */
    protected $path;

    /**
     * @var $command
     */
    protected $command;

    /**
     * @var array $parameters
     */
    protected $parameters = [];

    /**
     * @var null $php
     */
    protected $php = null;

    /**
     * RemoteArtisan constructor.
     *
     * @param string $path The full path to the remote application's root
     * @param string $command The Artisan command to run, e.g. 'vendor:publish'
     * @param array $parameters The parameters to pass to the artisan command
     * @param string $php The path to the PHP executable
     */
    public function __construct(string $path, string $command, $parameters = [], $php = null)
    {
        $this->path = $path;
        $this->command = $command;
        $this->parameters = $parameters;
        $this->php = $php;
    }

    /**
     * Implements an interface similar to Artisan::call.
     *
     * @return mixed
     * @throws ProcessFailedException
     */
    public function run()
    {
        // Prepare parameters for appending
        $options = '';
        foreach ($this->parameters as $name => $value) {

            if (is_int($name)) {
                $options .= " $value";
            } else {
                $value = $value === true ? '' : '="'.$value.'"';
                $options .= " {$name}{$value}";
            }
        }

        // Swap out the full path to the current PHP executable binary
        if (! $this->php) {
            $this->php = PHP_BINDIR . '/php';
        }

        // Load .env for the target app
        $env = new Dotenv($this->path);
        $env->overload();

        // Append the artisan command to the path
        $artisan = Str::finish($this->path, '/').'artisan';

        // Build up the final command
        $command = "{$this->php} {$artisan} {$this->command}{$options}";

        // Run the command in its environment
        $process = new Process($command, $this->path);
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
