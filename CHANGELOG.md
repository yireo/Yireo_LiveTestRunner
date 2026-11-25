# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.0.4] - 25 November 2026
### Added
- Option `--force` to explicitly allow running live tests in production mode
- README with installation, usage and production-mode notes

### Changed
- Requires PHP 8.2 to 8.5 (PHP 8.1 support dropped, PHP 8.5 support added)
- Replace wildcard dependency on `magento/framework` with `^103.0`

### Fixed
- Live tests could be run accidentally in production mode; the command now refuses unless `--force` is given
- Test folder is now restricted to the Magento root, resolved to an absolute path and escaped in console output
- Require PHPUnit versions patched for CVE-2026-24765 (`^9.6.34 || ^10.5.63`)
- Command did not work with PHPUnit 10 and did not return an exit code
- Deprecation of implicit trim characters under PHP 8.6
- Missing dependencies on `Magento_Catalog` and `symfony/console`
