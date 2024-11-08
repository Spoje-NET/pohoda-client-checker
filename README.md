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
```

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
