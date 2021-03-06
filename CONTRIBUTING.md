# Общие соображения 

Для установки всего необходимого и запуска всех проверок достаточно сделать:

```bash
make -j
```

Весь код будет отформатирован как требуется, будут запущены тесты и всевозможные проверки. Точно такие делаются при CI для PR.

Для любых исправлений и дополнений необходимо покрытие тестами.

# Интеграционные тесты

Для запуска интеграционных тестов нужно задать тестовые ключи, с которыми производится доступ:

```bash
export CDEK_ACCOUNT=.....
export CDEK_PASSWORD=.....
```

Также можно поменять путь до API, например, на вариант без https:

```bash
export CDEK_BASE_URL=http://integration.cdek.ru 
```

Затем можно запускать тесты в режиме отладки:

```bash
vendor/bin/phpunit --group=integration --debug
```

Тесты будут показывать посылаемые запросы и получаемые ответы от API СДЭК.

# Бэйджи и прочее

[![Code Coverage](https://scrutinizer-ci.com/g/sanmai/cdek-sdk/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/sanmai/cdek-sdk/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/sanmai/cdek-sdk/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/sanmai/cdek-sdk/?branch=master)


(Выше процент для покрытия тестами с учетом устаревшего или неиспользуемого кода.)

