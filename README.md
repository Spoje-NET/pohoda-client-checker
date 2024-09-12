Pohoda Client Checker
=====================

![ Pohoda Client Config logo]( pohoda-client-checker.svg?raw=true)

Check mServer availbility


![Connection OK](connection-success.png?raw=true)

Return code: 0

![Connection Problem](connection-problem.png?raw=true)

Return code: 1

The json output into stdout is also provided.

Installation
------------


```shell
sudo apt install lsb-release wget apt-transport-https bzip2


wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update

sudo apt install pohoda-client-checker
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
