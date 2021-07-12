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
