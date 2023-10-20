Pohoda Client config
====================

Check mServer availbility


![Connection OK](connection-success.png?raw=true)

Return code: 0

![Connection Problem](connection-problem.png?raw=true)

Return code: 1

Installation
------------


```shell
sudo apt install lsb-release wget apt-transport-https bzip2


wget -qO- https://repo.vitexsoftware.com/keyring.gpg | sudo tee /etc/apt/trusted.gpg.d/vitexsoftware.gpg
echo "deb [signed-by=/etc/apt/trusted.gpg.d/vitexsoftware.gpg]  https://repo.vitexsoftware.com  $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list
sudo apt update

sudo apt install pohoda-client-config
```

Configuration
-------------

First command parameter is path to .env file. 
If no file is provided use invironment variables instead.

```
EASE_LOGGER=console
POHODA_URL=http://mserver.intranet:10010
POHODA_USERNAME=somelogin
POHODA_PASSWORD=somepass
POHODA_TIMEOUT=60
POHODA_COMPRESS=false
POHODA_DEBUG=true
```

See also:

* [PHP Pohoda Connector](https://github.com/VitexSoftware/PHP-Pohoda-Connector) library
* [PohodaCTL](https://github.com/Spoje-NET/pohodactl)


