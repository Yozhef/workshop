## 🛠️ Makefile команди


### ⛔ `make down`

Явне зупинення та видалення всіх контейнерів, включно з "осиротілими":

```bash
docker-compose down --remove-orphans
````

---

### 🧪 `make behat`

Запуск тестів Behat всередині контейнера `php-fpm`:

```bash
docker-compose exec php-fpm vendor/bin/behat
```

---

### 🐚 `make sh`

Інтерактивна bash-сесія всередині контейнера `php-fpm`:

```bash
docker-compose exec php-fpm bash
```