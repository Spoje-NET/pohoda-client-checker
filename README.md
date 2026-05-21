Pohoda Client Checker
=====================

![Pohoda Client Checker logo](pohoda-client-checker.svg?raw=true)

Tools for checking Stormware Pohoda mServer availability and reporting bank transactions.

## Features

- **pohoda-client-checker** — verifies mServer connectivity and returns status as JSON
- **pohoda-transaction-report** — downloads bank transaction data from Pohoda and produces a JSON report

## Installation

Debian/Ubuntu packages via the VitexSoftware repository:

```shell
sudo apt install lsb-release wget apt-transport-https

wget -qO- https://repo.vitexsoftware.com/KEY.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg] https://repo.vitexsoftware.com $(lsb_release -sc) main" \
    | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update
sudo apt install pohoda-client-checker
```

Or via Composer:

```shell
composer require spojenet/pohoda-client-check
```

## Configuration

Copy `example.env` to `.env` and fill in credentials:

```env
POHODA_URL=http://server:40000
POHODA_ICO=12345678
POHODA_USERNAME=user
POHODA_PASSWORD=secret
RESULT_FILE=/tmp/phcheck.json
```

### Environment variables

| Variable | Description | Required |
|----------|-------------|----------|
| `POHODA_URL` | mServer API endpoint | yes |
| `POHODA_USERNAME` | mServer username | yes |
| `POHODA_PASSWORD` | mServer password | yes |
| `POHODA_ICO` | Organization number (IČO) | yes |
| `POHODA_IBAN` | Account IBAN (transaction report) | for report |
| `POHODA_BANK_IDS` | Bank account IDS (transaction report) | for report |
| `REPORT_SCOPE` | Time scope (see [Scopes](#scopes)) | no |
| `RESULT_FILE` | Output JSON file path (default: `php://stdout`) | no |
| `APP_DEBUG` | Show debug messages (`true`/`false`) | no |
| `EASE_LOGGER` | Logger type e.g. `console\|syslog` | no |

## Usage

Both tools accept `-e`/`--environment` to specify the env file and `-o`/`--output` to specify the output file.

### Check mServer availability

```shell
pohoda-client-checker --environment=.env
```

Successful response:

```json
{
   "message": "Response from POHODA mServer",
   "name": "NOVAK",
   "server": "http://SE-APP01-NEW:40000",
   "status": "idle",
   "processing": "0"
}
```

![Connection OK](connection-success.png?raw=true)

Failed connection:

```json
{
   "status": false,
   "message": "Failed to connect to server port 40000 after 130261 ms: Couldn't connect to server"
}
```

![Connection Problem](connection-problem.png?raw=true)

### Bank transaction report

```shell
pohoda-transaction-report --environment=.env --output=/tmp/report.json
```

Example output:

```json
{
    "source": "Pohoda\\BankProbe",
    "account": "6465656645",
    "in": {"27": 629.2, "28": 629.2},
    "out": {"22": 41805.55},
    "in_total": 2,
    "out_total": 1,
    "in_sum_total": 1258.4,
    "out_sum_total": 41805.55,
    "iban": "CZ0000000000000000000000",
    "from": "2024-09-01",
    "to": "2024-09-30"
}
```

## Scopes

The `REPORT_SCOPE` variable (or passed dynamically) accepts:

- `yesterday`
- `two_days_ago`
- `last_week`
- `current_month`
- `last_month`
- `last_two_months`
- `previous_month`
- `two_months_ago`
- `this_year`
- `January` … `December` (current year)

## MultiFlexi integration

The package ships with MultiFlexi application descriptors in the `multiflexi/` directory for both tools.

**Pohoda Client Checker** is ready to run as a [MultiFlexi](https://multiflexi.eu) application.
See the full list of ready-to-run applications on the [application list page](https://www.multiflexi.eu/apps.php).

[![MultiFlexi App](https://github.com/VitexSoftware/MultiFlexi/blob/main/doc/multiflexi-app.svg)](https://www.multiflexi.eu/apps.php)

## See also

- [PHP Pohoda Connector](https://github.com/VitexSoftware/PHP-Pohoda-Connector) library
- [PohodaCTL](https://github.com/Spoje-NET/pohodactl)

## License

MIT
