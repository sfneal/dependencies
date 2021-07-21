# Changelog

All notable changes to `dependencies` will be documented in this file


## 0.1.0 - 2021-07-08
- initial pre-release
- make config file, service provider, service & repository
- add dependencies (laravel & sfneal/string-helpers)


## 0.1.1 - 2021-07-08
- add url & response contains assertions
- add packages to the dataProvider


## 0.2.0 - 2021-07-09
- refactor test suite to use `Http` facade instead of `GuzzleHttp\Client`
- refactor `DependencyService` methods to return an instance of `DependencyUrl` for retrieving urls & svgs


## 0.2.1 - 2021-07-12
- make `DependencyUrlTest` to test url generators in isolation
- make `DependencySvgTest` to test svg generators in isolation
- make `ConfigTest`


## 0.2.2 - 2021-07-13
- add use of `SvgAssertions` & `UrlAssertions` traits in `TestCase`
- start making `DependenciesRepository` unit tests


## 0.3.0 - 2021-07-13
- make `ComposerDependencies` utility for retrieving package dependencies from composer.json files
- add 'composer_json_path' key to config for specifying the composer.json path


## 0.4.0 - 2021-07-21
- refactor retrieving dependencies syntax from `(new DependenciesRepository())->get()` to `Dependencies::fromConfig()->get()`
- make `Dependencies` with static methods for constructing dependency collections 
- refactor use of `DependenciesRepository` to allow for passing arrays of dependencies
