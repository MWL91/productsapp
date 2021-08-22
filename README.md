# Products app

This app allows user to export xml files from local or remote source.

## Installation

```bash
make build
```

## Run program

To run program with your local files, you need to copy it to current directory and execute. Use command below:

```bash
make import INPUT=./tests/resources/coffee_feed.xml OUTPUT=test.csv
```

Alternatively if you run docker, you can execute task:

```bash
docker exec productsapp php bin/console import tests/resources/coffee_feed.xml output.csv
```

Or do it using php installed on your machine (v8.0).

```bash
 php bin/console import INPUT_FILE OUTPUT_FILE --inputFormat=INPUT_FORMAT --outputFormat=OUTPUT_FORMAT
```

where

| param          | value                                                | default |
| ---            | ---                                                  | ---     |
| INPUT_FILE     | path or address to input file, may be ftp or http    | -       |
| OUTPUT_FILE    | path to output                                       | -       |
| INPUT_FORMAT   | input format                                         | xml     |
| OUTPUT_FORMAT  | output format                                        | csv     |

## Code description

This application bases on Strategy pattern.

If you would like to extend input and outputs, all you need to do is create new Processor class, that should be located
in `src/Processors`. Console, and service read type from input, so in case of adding new class, you should name it
XXXProcessor, where XXX stands for your input type. Length of file name is not limited to 3 signs.

Currently, you can use csv, and xml both for input and output.

Class processor, contains data, and may be assigned to each other by `applyInput` method, that also fetch data from the
input, inside output processor.

## Quality measures

### PHP Insights

All measures from phpinsights are under 90% of rate.

    95.0%      91.4%          100 %        98.8%
     Code    Complexity    Architecture    Style

### Code coverage

Code is covered by tests in 100%. Kernel file is excluded. You can generate coverage report using:

```bash
make coverage
```

Report will be printed in `/coverage_report`.

### PHP Code Sniffer

For this project I use squizlabs/php_codesniffer.