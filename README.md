# Drupal Meetup Tokyo

## デモ環境

* Landoベース
	* [System Requirements · Lando Documentation](https://docs.devwithlando.io/installation/system-requirements.html)
	* [Installing · Lando Documentation](https://docs.devwithlando.io/installation/installing.html)

`config/sync/` 以下へ設定のエクスポート

```
lando drush config:export
lando drush config:import
```

DBエクスポート

```
lando db-export ./db_25.sql.gz
lando db-import ./db_25.sql.gz
```

## 環境の再現手順

※Landoの利用にはDocker Engineの起動が必要です。

```
lando start
lando composer install
lando drush site:install --sites-subdir=default demo_umami --db-url=mysql://drupal8:drupal8@database/drupal8
lando drush user:login
```

## Behatテスト
※ Drupalがすでにインストールされている必要があります。
### テストの起動
```
lando behat
```
### 定義(Definition)一覧の確認方法
```
lando behat -dl
```
