# Changelog

## [v1.1.0] - 2026-10-31
### Fixed
- `ProgressBarHelper::render()` threw `ValueError` (`str_repeat()` with a negative count) once the bar passed about a third: the empty part was measured with `strlen()` and `█` is 3 bytes. It now counts blocks, and clamps `processed > total` to a full bar.
### Added
- `ProgressBarHelper` takes an optional `OutputInterface` (`new ProgressBarHelper(30, $this->output)`) so the bar goes to the command's output instead of a separate `ConsoleOutput`.
- PHPUnit setup (`composer test`) with tests for `ProgressBarHelper`.

## [v1.0.6] - 2026-06-11
### Fixed
- Removed hardcoded `"version"` field from `composer.json` on all old tags (caused Packagist to skip v1.0.1–v1.0.5)
- Recreated tag `v1.0.6` pointing to clean commit
- Published to Packagist — `repositories` block no longer needed in consumer projects

## [v1.0.5] - 2025-xx-xx
### Changed
- Internal improvements

## [v1.0.4] - 2025-xx-xx
### Added
- `ProgressBarHelper` for Artisan command progress display

## [v1.0.3] - 2025-xx-xx
### Added
- `CacheRegistry` — auto-scans `app/Cache/` and aggregates cache data
- `CacheTableCleared` event dispatched on `TraitCache::clearCache()`

## [v1.0.2] - 2025-xx-xx
### Added
- `TraitCache` — base trait for project cache classes
- `HelperCache::nameCache()` — consistent cache key generation

## [v1.0.1] - 2025-xx-xx
### Added
- `StringHelper`, `NumberHelper`, `SystemHelper`
- `LogHelper::logUserException()` — full-context exception logging

## [v1.0.0] - 2025-xx-xx
### Added
- Initial release
- `ApiResponse::success()` / `error()` / `response()` — standardized JSON responses
- Global helpers `apiSuccess()` / `apiError()`
- `AuthHelper::checkPassword()` — verify authenticated user password
