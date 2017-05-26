<?php

namespace Elegon\Foundation\Console;

use ReflectionClass;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

trait ManipulatesApplication
{
    protected $console;

    public function __construct($console)
    {
        $this->console = $console;
    }

    protected function title($text)
    {
        $this->line($text, null, OutputInterface::VERBOSITY_VERBOSE);
    }

    protected function detail($text)
    {
        $this->line($text, null, OutputInterface::VERBOSITY_VERY_VERBOSE);
    }

    protected function replace($path, $silent = false)
    {
        if (! $silent) $this->detail("replace: $path");

        $this->delete($path, true);
        $this->add($path, true);
    }

    protected function add($path, $silent = false)
    {
        if (! $silent) $this->detail("add: $path");

        copy_folder($this->getDir("/../Stubs/$path"), base_path($path));
    }

    protected function delete($path, $silent = false)
    {
        if (! $silent) $this->detail("delete: $path");

        if (is_file(base_path($path))) {
            unlink(base_path($path));
        } else {
            delete_folder(base_path($path));
        }
    }

    protected function edit($path, $changes, $silent = false)
    {
        if (! $silent) $this->detail("edit: $path");

        $file = file_get_contents(base_path($path));

        foreach ($changes as $pattern => $replacement) {
            $file = preg_replace($pattern, $replacement, $file);
        }

        file_put_contents(base_path($path), $file);
    }

    protected function append($path, $silent = false)
    {
        if (! $silent) $this->detail("append: $path");

        file_put_contents(
            base_path($path),
            file_get_contents($this->getDir("/../Stubs/$path")),
            FILE_APPEND
        );
    }

    protected function exec($script, $silent = false)
    {
        if (! $silent) $this->detail("call: $script");

        $process = new Process($script);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if (! $silent) $this->detail($process->getOutput());
    }

    protected function publish($packageName, $tag, $silent = false)
    {
        if (! $silent) $this->detail("publish: $tag ($packageName)");

        $this->callSilent('elegon:publish', [
            '--package' => $packageName,
            '--tag' => $tag
        ]);
    }

    /**
     * Helper: Get the root directory of the package.
     */
    protected function getDir($path = '')
    {
        $classInstanciated = new ReflectionClass(static::class);
        $path = $path === '' ? '' : "/$path"; 

        return dirname($classInstanciated->getFileName()) . $path;
    }

    /**
     * Proxy the other methods to the console.
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->console, $name], $arguments);
    }
}