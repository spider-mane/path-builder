<?php

namespace WebTheory\PathBuilder;

class PathBuilder
{
    public function buildPaths(string $root, array $paths): void
    {
        if (!file_exists($root)) {
            $this->makeDirectory($root);
        }

        foreach ($paths as $path => $nested) {
            $this->buildPaths($root . '/' . $path, $nested);
        }
    }

    protected function makeDirectory(string $dirname): void
    {
        mkdir($dirname, 0777, true);
    }
}
