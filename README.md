# Logger

Simple and fast file logger.


## API

```php
public Logger::__construct ( string $name, string $file, string $level )

public void Logger::debug ( string $message [, array $context ] )

public void Logger::info ( string $message [, array $context ] )

public void Logger::notice ( string $message [, array $context ] )

public void Logger::warning ( string $message [, array $context ] )

public void Logger::error ( string $message [, array $context ] )

public void Logger::critical ( string $message [, array $context ] )

public void Logger::alert ( string $message [, array $context ] )

public void Logger::emergency ( string $message [, array $context ] )
```


## Usage

```php
<?php

use SurrealCristian\Logger;

$logger = new Logger('NAME', "/tmp/out.log", 'debug');
$logger->debug('A log message', ['key1' => 'value1', 'key2' => 'value2']);
```

```
$ cat /tmp/out.log
DEBUG 2016-01-15 00:01:30 BENCH: A log message {"key1":"value1","key2":"value2"}
```


## License

MIT
