# Hunting Module (Guides & Bookings)

Мини-модуль для бронирования охотничьих туров с выбором гида. PSR-12, строгая типизация, без магии.

## API
- `GET /api/guides?min_experience=3` — список активных гидов с опциональным фильтром по стажу
- `POST /api/bookings` — создание бронирования
  ```json
  {
    "tour_name": "Рыбалка",
    "hunter_name": "Сергей",
    "guide_id": 1,
    "date": "2025-11-01",
    "participants_count": 4
  }
  ```

### Ответы
- `201 Created` — JSON ресурса бронирования
- `409 Conflict` — гид занят на дату
- `400 Bad Request` — гид неактивен / не найден (доменная ошибка)
- `422 Unprocessable Entity` — ошибки валидации (Laravel)

## Установка
1. Запустите миграции:
   ```bash
   php artisan migrate
   ```
2. Заполните демо-данными:
   ```bash
   php artisan db:seed --class=Database\\Seeders\\GuideSeeder
   ```
3. Тесты:
   ```bash
   php artisan test --filter=Hunting\\BookingTest
   ```

## Интеграция в BookingCore
- Вынесите файлы в `Modules/Hunting/*` и зарегистрируйте `ServiceProvider`.
- Доменный юзкейс — `CreateBookingAction`.
- События интеграции: диспатч `BookingCreated` после успешного бронирования (при необходимости).

