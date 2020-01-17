![Sumday Console](SumdayConsole-banner.png)

**Sumday Console** - A developer's best friend for tracking their working hours.

[![Build Status](https://travis-ci.org/grafiteinc/sumday-console.svg?branch=master)](https://travis-ci.org/grafiteinc/sumday-console)
[![Packagist](https://img.shields.io/packagist/dt/sumday/console.svg)](https://packagist.org/packages/sumday/console)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/sumday/console)

The Sumday Console is the best way to connect with and log hours with Sumday.io.

##### Author(s):
* [Matt Lantz](https://github.com/mlantz) ([@mattylantz](http://twitter.com/mattylantz), mattlantz at gmail dot com)

## Requirements

1. PHP 7.2+

### Installation

Run the following command:
```php
composer global require "sumday/console"
```

## Documentation

#### Auth

The auth command lets you connect to your account on Sumday.io.

```bash
$ sumday auth {email}
```

#### Config

The config command lets you connect a directory to a client or project UUID.

```bash
$ sumday config {uuid}
```

#### Clients/Projects

These commands provide a simple list of the clients or projects you have access to on Sumday.io

```bash
$ sumday clients|projects
```

#### Log

The log command is the most important. It lets you log hours as if you were just writing a `git commit`.

```bash
$ sumday log {hours} {message} {--date}
```

## License
FormMaker is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

### Bug Reporting and Feature Requests
Please add as many details as possible regarding submission of issues and feature requests

### Disclaimer
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
