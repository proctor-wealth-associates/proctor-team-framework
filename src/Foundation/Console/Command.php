<?php

namespace Elegon\Foundation\Console;

use Illuminate\Console\Command as IlluminateCommand;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

abstract class Command extends IlluminateCommand
{
    protected function detail($text)
    {
        parent::line($text, null, OutputInterface::VERBOSITY_VERBOSE);
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

        copy_folder(__DIR__ . '/../Stubs/' . $path, base_path($path));
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
}