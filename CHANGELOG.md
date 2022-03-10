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


## 0.5.0 - 2021-07-21
- add 'github_alias' config array for setting alias github account names
- make `DependenciesRepositoryArrayTest` for testing setting dependencies from an array


## 0.6.0 - 2021-07-29
- add support for caching `DependencyRepository` collections
- add 'cache.ttl' & 'cache.prefix' config keys
- add composer requiring of sfneal/laravel-helpers for concatenating cache keys & sfneal/caching for setting/retrieving
- add use of sfneal/caching `IsCacheable` trait to `DependencyRepository` for setting the cache key
- optimize `ComposerDependencies` utilities functionality


## 0.6.1 - 2021-07-29
- optimize repo & service tests by removing redundant http requests & assertions
- cut packages with mismatching GitHub urls from `TestCase::packageProvider()`
 
 
## 0.7.0 - 2021-08-17
- add $type property setter to `DependenciesService` that asserts the dependency type is supported
- refactor `DependenciesService::getGitHubPackageName()` method to `DependenciesService::setGitHubRepo()` & return void
- fix issue with `DependenciesService::setGitHubRepo()` not using else statement for setting default value
- add Docker repos to test dependencies

 
## 0.7.1 - 2021-08-17
- add support for 'python' dependency types that use `PyPi` distribution
 

## 1.0.0 - 2021-08-17
- initial production release
- fix laravel/framework composer requirement by replacing with illuminate/support


# 1.0.1 - 2021-08-18
- make `ComposerDependencyTest` for testing `ComposerDependencies` utility class


# 1.1.0 - 2021-08-18
- optimize `DependencyRepository::get()` method and related calls by reducing collection mapping
- refactor ComposerDependencies return a flat collection composer packages (removed 'composer' value)


# 1.1.1 - 2021-09-01
- fix 'travis-ci.com' url to 'app.travis-ci.com' subdomain (was causing `DependenciesServiceTest::travis_url()` to fail)
- add support for sfneal/caching v2.0


# 1.2.0 - 2021-09-08
- add ability to display 'open issues' & 'closed issues' badges for dependencies #43


# 1.2.1 - 2021-09-08
- add color override to 'closed issues' svg badge to force color to be red (makes it easier to read open vs. closed issues)


# 1.3.0 - 2021-09-08
- optimize test suite so that SVG & URL assertions are in a single test method #52
- add 'pull requests' methods to `DependenciesService` that allow access to 'open' & 'closed' pull request counts
- add custom assertion methods for testing open & closed pull requests urls & svg badges
- add 'composer test-feature' & 'composer test-unit' scripts for running 'Feature' & 'Unit' tests separately


# 1.4.0 - 2021-09-09
- make `Url` & `ImgShieldsUrl` utility classes for generating URLs & SVGs
- add ability to pass global img shields params to `Dependency`, `DependencyRepository` & `DependencyService`
- add testing of adding global params to img shield URLs


# 1.4.1 - 2021-09-29
- add static `from()` methods to `Url` & `ImgShieldsUrl` classes to allow for cleaner static construction of objects
- refactor `ComposerDependencies` utility to `ComposerRequirements` to better reflect use


# 1.4.2 - 2021-09-29
- add persistent 'http' cache store for storing HTTP responses (reduces runtime of test suite, once response is received it shouldn't be expected to change)


# 1.4.3 - 2022-03-01
- bump composer dependency constraints to allow package upgrades
- add use of GitHub actions


# 1.5.0 - 2022-03-09
- add `description()` method to `DependencyService` for accessing a repo's description
- add `defaultBranch()` method to `DependencyService` for accessing a repo's default branch
- add `download()` method to `DependencyService` for downloading a zip of the repo's default branch


# 1.5.1 - 2022-03-09
- fix issues with `GithubUrl` API response caching


# 1.6.0 - 2022-03-10
- add ability to retrieve image shields badges for GitHub repo workflows (`DependencyService->github()->workflow()`)


# 1.7.0 - 2022-03-10
- add support for 'node' package dependencies
