<?php

declare(strict_types=1);

namespace IlBronza\TranslationsManager\Services;

use IlBronza\TranslationsManager\Models\Missingtranslation;
use IlBronza\Ukn\Ukn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Throwable;

use function json_encode;

class MissingTranslationBuffer
{
    protected array $items = [];

    public function push(array $parameters): void
    {
        $this->items[$this->key($parameters)] = $parameters;
    }

    public function has(array $parameters): bool
    {
        return isset($this->items[$this->key($parameters)]);
    }

    public function flush(): void
    {
        if ($this->items === []) {
            return;
        }

        $items = $this->items;
        $this->items = [];

        $now = Carbon::now()->toDateTimeString();
        $records = [];

        foreach ($items as $parameters) {
            $parameters['created_at'] = $parameters['created_at'] ?? $now;
            $parameters['updated_at'] = $parameters['updated_at'] ?? $now;

            if (isset($parameters['data']) && is_array($parameters['data'])) {
                $parameters['data'] = json_encode($parameters['data']);
            }

            $records[] = $parameters;
        }

        try {
            $records = $this->rejectExistingRecords($records);

            if ($records === []) {
                return;
            }

            $query = Missingtranslation::query();

            if (method_exists($query, 'insertOrIgnore')) {
                $query->insertOrIgnore($records);

                return;
            }

            $query->insert($records);
        } catch (Throwable $e) {
            Ukn::e('Error on batch insert for missing translations: ' . $e->getMessage());
        }
    }

    private function rejectExistingRecords(array $records): array
    {
        $existingKeys = [];

        Missingtranslation::query()
            ->select(['language', 'scope', 'filename', 'string'])
            ->where(function (Builder $query) use ($records): void {
                foreach ($records as $record) {
                    $query->orWhere(function (Builder $query) use ($record): void {
                        $query
                            ->where('language', $record['language'] ?? null)
                            ->where('scope', $record['scope'] ?? null)
                            ->where('filename', $record['filename'] ?? null)
                            ->where('string', $record['string'] ?? null);
                    });
                }
            })
            ->get()
            ->each(function (Missingtranslation $missingtranslation) use (&$existingKeys): void {
                $existingKeys[$this->key($missingtranslation->toArray())] = true;
            });

        return array_values(array_filter(
            $records,
            fn (array $record): bool => ! isset($existingKeys[$this->key($record)])
        ));
    }

    private function key(array $parameters): string
    {
        return json_encode([
            $parameters['language'] ?? '',
            $parameters['scope'] ?? '',
            $parameters['filename'] ?? '',
            $parameters['string'] ?? '',
        ]) ?: '';
    }
}
