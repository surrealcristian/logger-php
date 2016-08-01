<?php

namespace SurrealCristian;

class Bench
{
    protected $defaultMemoryBench = null;
    protected $defaultTimeBench = null;
    protected $memoryBenchs = [];
    protected $timeBenchs = [];

    /**
     * @param string $name Name
     */
    public function startMemory($name = null)
    {
        if ($name === null) {
            $this->defaultMemoryBench = memory_get_usage();
            return;
        }

        $this->memoryBenchs[$name] = null;
        $this->memoryBenchs[$name] = memory_get_usage();
    }

    /**
     * @param string $name Name
     *
     * @return integer The memory amount in bytes.
     */
    public function stopMemory($name = null)
    {
        if ($name === null) {
            $memory = memory_get_usage() - $this->defaultMemoryBench;
            $this->defaultMemoryBench = null;

            return $memory;
        }

        $memory = memory_get_usage() - $this->memoryBenchs[$name];
        unset($this->memoryBenchs[$name]);

        return $memory;
    }

    /**
     * @param string $name Name
     */
    public function startTime($name = null)
    {
        if ($name === null) {
            $this->defaultTimeBench = microtime(true);
            return;
        }

        $this->timeBenchs[$name] = null;
        $this->timeBenchs[$name] = microtime(true);
    }

    /**
     * @param string $name Name
     *
     * @return float Seconds
     */
    public function stopTime($name = null)
    {
        if ($name === null) {
            $time = microtime(true) - $this->defaultTimeBench;
            $this->defaultTimeBench = null;

            return $time;
        }

        $time = microtime(true) - $this->timeBenchs[$name];
        unset($this->timeBenchs[$name]);

        return $time;
    }
}
