<?php

namespace IlBronza\TranslationsManager\Console\Commands;

use IlBronza\UikitTemplate\Helpers\RouteTitleTranslator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Route as IlluminateRoute;

class AuditRouteTitlesCommand extends Command
{
	protected $signature = 'translations:audit-route-titles
		{--package= : Filter by translation namespace (e.g. products)}
		{--host : Also report missing host-app routes.* titles}
		{--missing-prefix : List named routes without package routeTranslationPrefix}';

	protected $description = 'Audit missing page-title translations for named routes (design-time)';

	public function handle() : int
	{
		$packageFilter = $this->option('package');
		$includeHost = (bool) $this->option('host');
		$reportMissingPrefix = (bool) $this->option('missing-prefix');

		$missingPackage = [];
		$missingHost = [];
		$withoutPrefix = [];
		$okPackage = 0;
		$okHost = 0;
		$skippedUnnamed = 0;

		foreach (Route::getRoutes() as $route)
		{
			/** @var IlluminateRoute $route */
			$name = $route->getName();

			if (! $name)
			{
				$skippedUnnamed++;
				continue;
			}

			$isPackage = RouteTitleTranslator::isPackageRoute($route);
			$prefix = RouteTitleTranslator::getTranslationPrefix($route);

			if ($packageFilter)
			{
				$expected = $packageFilter . '::routes.';

				if ($prefix !== $expected)
					continue;
			}

			if ($reportMissingPrefix && ! $isPackage && $this->looksLikePackageRoute($name))
			{
				$withoutPrefix[] = [
					$name,
					implode('|', $route->methods()),
					$route->uri(),
				];
			}

			$candidates = [];

			foreach (RouteTitleTranslator::candidateItems($name) as $item)
				$candidates[] = $prefix . $item;

			$found = false;

			foreach ($candidates as $key)
			{
				if (trans()->has($key))
				{
					$found = true;
					break;
				}
			}

			if ($found)
			{
				if ($isPackage)
					$okPackage++;
				else
					$okHost++;

				continue;
			}

			$row = [
				$name,
				$prefix,
				implode(' | ', $candidates),
			];

			if ($isPackage)
				$missingPackage[] = $row;
			else
				$missingHost[] = $row;
		}

		$this->info(sprintf(
			'Named routes OK — package: %d, host: %d (unnamed skipped: %d)',
			$okPackage,
			$okHost,
			$skippedUnnamed
		));

		if ($missingPackage !== [])
		{
			$this->newLine();
			$this->error(count($missingPackage) . ' missing PACKAGE route titles:');
			$this->table(['route', 'prefix', 'tried'], $missingPackage);
		}

		if ($includeHost && $missingHost !== [])
		{
			$this->newLine();
			$this->warn(count($missingHost) . ' missing HOST route titles (optional):');
			$this->table(['route', 'prefix', 'tried'], $missingHost);
		}

		if ($reportMissingPrefix && $withoutPrefix !== [])
		{
			$this->newLine();
			$this->warn(count($withoutPrefix) . ' named routes that look packaged but have no routeTranslationPrefix:');
			$this->table(['route', 'methods', 'uri'], $withoutPrefix);
		}

		if ($missingPackage !== [])
			return self::FAILURE;

		$this->info('All package route titles are present.');

		return self::SUCCESS;
	}

	/**
	 * Heuristic for --missing-prefix: common IlBronza route name prefixes.
	 */
	protected function looksLikePackageRoute(string $name) : bool
	{
		return (bool) preg_match(
			'/^(ib[A-Z]|operators|clientsmanager|notesmanager|accountmanager|measurementUnits|temporarylinks)/',
			$name
		);
	}
}
