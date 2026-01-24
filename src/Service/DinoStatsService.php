<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

class DinoStatsService
{
    /**
     * @var array<string, mixed>|null
     */
    private ?array $rawData = null;

    private const ALL_DINOS = 'all';

    private const COLORS = [
        'de3232',
        'de6732',
        'dede32',
        '67de32',
        '32de32',
        '32de67',
        '32dede',
        '3267de',
        '3232de',
        '6732de',
        'de32de',
        'de3267',
    ];

    /**
     * @return list<string>
     */
    public static function getAllTypes(): array
    {
        return [
            self::ALL_DINOS,
            'sauropod',
            'large theropod',
            'small theropod',
            'ceratopsian',
            'euornithopod',
            'armoured dinosaur',
        ];
    }

    /**
     * @param list<string> $types
     *
     * @return array{labels: list<string>, datasets: list<array<string, mixed>>}
     */
    public function fetchData(int $start, int $end, array $types): array
    {
        $start = abs($start);
        $end = abs($end);

        $steps = 10;
        $step = (int) round(($start - $end) / $steps);

        $labels = [];
        for ($i = 0; $i < $steps; ++$i) {
            $current = $start - ($i * $step);
            // generate a random rgb color

            $labels[] = $current.' mya';
        }

        $datasets = [];

        $colors = self::COLORS;
        shuffle($colors);

        foreach ($types as $type) {
            $color = '#'.(next($colors) ?: reset($colors));

            $datasets[] = [
                'label' => ucwords($type),
                'data' => $this->getSpeciesCounts($start, $steps, $step, $type),
                'borderColor' => $color,
                'backgroundColor' => $color,
            ];
        }

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function getRawData(): array
    {
        if (null === $this->rawData) {
            $this->rawData = json_decode(file_get_contents(__DIR__.'/data/dino-stats.json'), true);
        }

        return $this->rawData;
    }

    /**
     * @return list<int>
     */
    private function getSpeciesCounts(int $start, int $steps, int $step, string $type): array
    {
        $counts = [];
        for ($i = 0; $i < $steps; ++$i) {
            $current = (int) round($start - ($i * $step));
            $counts[] = $this->countSpeciesAt($current, $type);
        }

        return $counts;
    }

    private function countSpeciesAt(int $currentYear, string $type): int
    {
        $count = 0;
        foreach ($this->getRawData() as $dino) {
            if ((self::ALL_DINOS !== $type) && $dino['type'] !== $type) {
                continue;
            }

            if ($dino['from'] >= $currentYear && $dino['to'] <= $currentYear) {
                ++$count;
            }
        }

        return $count;
    }
}
