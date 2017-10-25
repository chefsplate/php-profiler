<?php namespace ChefsPlate\Profiler;

use Ramsey\Uuid;

/**
 * Class Profiler
 * @package ChefsPlate\Profiler
 */
final class Profiler
{
    /** @var array */
    private static $stack = [];

    /** @var int */
    private static $precision = 3;

    /** @var bool */
    private static $cumulative = true;

    /** @var bool */
    private static $log = true;

    /**
     * @param int $precision
     */
    public static function setPrecision(int $precision)
    {
        if ($precision > 0) {
            static::$precision = $precision;
        } else {
            static::$precision = 0;
        }
    }

    /**
     * Enable profiler logging
     */
    public static function enableLogging()
    {
        static::$log = true;
    }

    /**
     * Disable profiler logging
     */
    public static function disableLogging()
    {
        static::$log = false;
    }

    /**
     * @param bool $cumulative
     */
    public static function setCumulative(bool $cumulative)
    {
        static::$cumulative = $cumulative;
    }

    /**
     * Marks the start time of the frame
     * @return Uuid\UuidInterface
     */
    public static function mark(): Uuid\UuidInterface
    {
        $start_time = microtime(true);
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $frame_id = Uuid\Uuid::uuid4();
        static::$stack[$frame_id->toString()] = [
            'class' => $trace[1]['class'],
            'file' => $trace[0]['file'],
            'function' => $trace[1]['function'],
            'line' => $trace[0]['line'],
            'time' => $start_time,
            'offset' => 0.0,
            'steps' => [],
        ];
        static::$stack[$frame_id->toString()]['offset'] += round(microtime(true) - $start_time, static::$precision);
        return $frame_id;
    }

    /**
     * Calculates a diff between the start time and the end time
     * @param Uuid\UuidInterface $id
     * @param string $label
     * @param bool $cumulative Calculate delta from last profile point or from initial mark, default static::$cumulative
     * @return float
     */
    public static function profile(Uuid\UuidInterface $id, string $label = '', bool $cumulative = null): float
    {
        $cumulative = $cumulative ?? static::$cumulative;
        $end_time = microtime(true);
        if (array_key_exists($id->toString(), static::$stack)) {
            $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
            $frame = static::$stack[$id->toString()];
            $diff = round(
                $end_time - $frame['offset'] - (
                    $cumulative ? $frame['time'] : count($frame['steps']) ? end($frame['steps']) : $frame['time']
                ), static::$precision
            );

            if (static::$log) {
                error_log(sprintf(
                    "Profiler: From %s line %d to %s took %fs%s",
                    implode('::', [
                        $frame['class'] ?? $frame['file'],
                        $frame['function'] ?? 'main',
                    ]),
                    $frame['line'],
                    $frame['file'] == $trace[0]['file'] && $frame['function'] == $trace[1]['function'] ?
                        "line {$trace[0]['line']}" : implode('::', [
                            $trace[1]['class'] ?? $trace[0]['file'],
                            $trace[1]['function'] ?? 'main',
                        ])." line {$trace[0]['line']}",
                    $diff,
                    strlen($label) ? " to $label" : ""
                ));
            }

            static::$stack[$id->toString()]['steps'][] = microtime(true);
            static::$stack[$id->toString()]['offset'] += round(microtime(true) - $end_time, static::$precision);
            return $diff;
        }

        error_log("Profiler: Could not find frame with matching id: ".$id->toString());
        return 0.0;
    }

    /**
     * Unset the Stack
     */
    public function __destruct()
    {
        foreach (static::$stack as $key => $value) {
            unset(static::$stack[$key]);
        }
    }
}

