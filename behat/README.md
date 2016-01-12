#### Install Composer
```bash
curl -sS https://getcomposer.org/installer | php
php composer.phar install
```

#### Create config file
```bash
cp behat.local.yml.example behat.local.yml
```

#### Execute Behat tests
```bash
./bin/behat
```
