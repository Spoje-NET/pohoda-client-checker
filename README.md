Pohoda Client Checker
=====================

![ Pohoda Client Config logo]( pohoda-client-checker.svg?raw=true)

Check mServer availbility


![Connection OK](connection-success.png?raw=true)

```json
{
   "message":"Response from POHODA mServer",
   "name":"novak",
   "server":"http:\/\/SE-APP01-NEW:10010",
   "status":"idle",
   "processing":"0"
}
```

Example of unsuccessfull test

```
"/usr/bin/php" "/home/vitex/Projects/Spoje/pohoda-client-checker/src/pohoda-checker.php"
01/02/2025 10:43:18 ⚙ ❲mPohoda Check⦒mServer\Client❳ mPohoda Check EaseCore 1.45.0 (PHP 8.3.6) mServer http://api@10.11.25.23:10010 PHPmServer vdev-main
{
    "message": "Failed to connect to 10.11.25.23 port 10010 after 133252 ms: Couldn't connect to server",
    "diag": {
        "url": "http:\/\/10.11.25.23:10010\/status",
        "content_type": null,
        "http_code": 0,
        "header_size": 0,
        "request_size": 0,
        "filetime": -1,
        "ssl_verify_result": 0,
        "redirect_count": 0,
        "total_time": 133.252747,
        "namelookup_time": 3.9e-5,
        "connect_time": 0,
        "pretransfer_time": 0,
        "size_upload": 0,
        "size_download": 0,
        "speed_download": 0,
        "speed_upload": 0,
        "download_content_length": -1,
        "upload_content_length": -1,
        "starttransfer_time": 0,
        "redirect_time": 0,
        "redirect_url": "",
        "primary_ip": "",
        "certinfo": [],
        "primary_port": 0,
        "local_ip": "",
        "local_port": 0,
        "http_version": 0,
        "protocol": 0,
        "ssl_verifyresult": 0,
        "scheme": "",
        "appconnect_time_us": 0,
        "connect_time_us": 0,
        "namelookup_time_us": 39,
        "pretransfer_time_us": 0,
        "redirect_time_us": 0,
        "starttransfer_time_us": 0,
        "total_time_us": 133252747,
        "effective_method": "POST",
        "capath": "\/etc\/ssl\/certs",
        "cainfo": "\/etc\/ssl\/certs\/ca-certificates.crt",
        "when": "0.12675300 1735814732"
    },
    "status": false
}01/02/2025 10:45:32 🌼 ❲mPohoda Check⦒mServer\Client❳ Saving result to php://stdout
Done.
01/02/2025 10:45:32 💀 ❲mPohoda Check⦒mServer\Client❳ 0: Curl Error (HTTP 0): Failed to connect to 10.11.25.23 port 10010 after 133252 ms: Couldn't connect to server
01/02/2025 10:45:32 💀 ❲mPohoda Check⦒mServer\Client❳ Connection problem
01/02/2025 10:45:32 💀 ❲mPohoda Check⦒mServer\Client❳ No XML response

```

![Connection Problem](connection-problem.png?raw=true)

```json
{
   "status":false,
   "message":"Failed to connect to 10.11.25.23 port 10011 after 130261 ms: Couldn't connect to server"
}
```

Pohoda transaction report
-------------------------



```json
{
    "source": "Pohoda\\BankProbe",
    "account": "6465656645",
    "in": {
        "27": 629.2,
        "28": 629.2,
        "29": 968,
        "30": 1452,
        "31": 4840,
        "32": 484,
        "33": 2613.6,
        "34": 1282.6,
        "35": 968
    },
    "out": {
        "22": 41805.55,
        "24": 41805.55,
        "25": 41805.55,
        "26": 41805.55,
        "36": 99,
        "37": 1669.56,
        "38": 15.84
    },
    "in_total": 9,
    "out_total": 7,
    "in_sum_total": 13866.6,
    "out_sum_total": 169006.6,
    "iban": "xxxx",
    "from": "2024-09-01",
    "to": "2024-09-30"
}
```

Configuration
-------------

First command parameter is path to .env file. 
If no file is provided use invironment variables instead.

```env
EASE_LOGGER=console
POHODA_URL=http://mserver.intranet:10010
POHODA_USERNAME=somelogin
POHODA_PASSWORD=somepass
POHODA_ICO=12345678
POHODA_TIMEOUT=60
POHODA_COMPRESS=false
POHODA_DEBUG=true
REPORT_SCOPE=yesterday
```

Scopes
------

 * `yesterday`
 * `two_days_ago`
 * `last_week`
 * `current_month`
 * `last_month`
 * `last_two_months`
 * `previous_month`
 * `two_months_ago`
 * `this_year`
 * `January`  // 1
 * `February` // 2
 * `March`    // 3
 * `April`    // 4
 * `May`      // 5
 * `June`     // 6
 * `July`     // 7
 * `August`   // 8
 * `September`// 9
 * `October`  // 10
 * `November` // 11
 * `December` // 12


See also:

* [PHP Pohoda Connector](https://github.com/VitexSoftware/PHP-Pohoda-Connector) library
* [PohodaCTL](https://github.com/Spoje-NET/pohodactl)

MultiFlexi
----------

**Pohoda Client Checker** is ready for run as [MultiFlexi](https://multiflexi.eu) application.
See the full list of ready-to-run applications within the MultiFlexi platform on the [application list page](https://www.multiflexi.eu/apps.php).

[![MultiFlexi App](https://github.com/VitexSoftware/MultiFlexi/blob/main/doc/multiflexi-app.svg)](https://www.multiflexi.eu/apps.php)

Installation
------------


```shell
sudo apt install lsb-release wget apt-transport-https bzip2


wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update

sudo apt install pohoda-client-checker
```
