# Thuctap RESTful API - Laravel

## Mục lục
- [Giới thiệu](#giới-thiệu)
- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Cài đặt](#cài-đặt)
- [Cấu hình môi trường](#cấu-hình-môi-trường)
- [Chạy migration và seed](#chạy-migration-và-seed)
- [Khởi động server](#khởi-động-server)
- [Cấu trúc API](#cấu-trúc-api)
- [Xác thực và phân quyền](#xác-thực-và-phân-quyền)
- [Test API với Postman/cURL](#test-api-với-postmancurl)
- [Ghi chú](#ghi-chú)

---

## Giới thiệu

Dự án này cung cấp hệ thống quản lý sự kiện chuẩn RESTful API sử dụng Laravel, hỗ trợ:
- Đăng ký, đăng nhập, xác thực qua Laravel Sanctum
- CRUD sự kiện (tạo, xem, sửa, xóa)
- Đăng ký/hủy đăng ký tham gia sự kiện
- Tìm kiếm, lọc, phân trang sự kiện
- Phân quyền qua Policy (admin, organizer, user)
- Trả về dữ liệu qua API Resource

---

## Yêu cầu hệ thống

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Laravel 10+
- Laragon (khuyến nghị cho môi trường Windows)

---

## Cài đặt

1. Clone source code về máy:
    ```sh
    git clone <repo-url>
    cd thuctap
    ```

2. Cài đặt các package:
    ```sh
    composer install
    ```

---

## Cấu hình môi trường

1. Copy file `.env.example` thành `.env` (nếu chưa có):
    ```sh
    cp .env.example .env
    ```

2. Cấu hình kết nối database trong file `.env`:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=thuctap
    DB_USERNAME=root
    DB_PASSWORD=
    ```

3. Tạo database `thuctap` trong MySQL.

4. Generate key:
    ```sh
    php artisan key:generate
    ```

---

## Chạy migration và seed

```sh
php artisan migrate
```

Nếu muốn seed dữ liệu mẫu:
```sh
php artisan db:seed
```

---

## Khởi động server

```sh
php artisan serve
```
Truy cập API tại: `http://127.0.0.1:8000/api`

---

## Cấu trúc API

### Xác thực

- **Đăng ký:** `POST /api/register`
    ```json
    {
      "name": "Tên",
      "email": "email@example.com",
      "password": "mật khẩu",
      "password_confirmation": "mật khẩu",
      "role": "admin|organizer|user" // mặc định là user
    }
    ```
- **Đăng nhập:** `POST /api/login`
    ```json
    {
      "email": "email@example.com",
      "password": "mật khẩu"
    }
    ```
    > Trả về: `access_token` dùng cho các API cần xác thực

---

### Sự kiện

- **Lấy danh sách sự kiện:** `GET /api/events`
- **Tạo sự kiện:** `POST /api/events`
- **Xem chi tiết:** `GET /api/events/{id}`
- **Cập nhật:** `PUT /api/events/{id}`
- **Xóa:** `DELETE /api/events/{id}`

#### Tìm kiếm, lọc, phân trang
- Tham số query: `name`, `creator`, `status`, `start_at`, `end_at`, `page`

---

### Đăng ký tham gia sự kiện

- **Xem danh sách người đăng ký:** `GET /api/events/{event}/registrations`
- **Đăng ký:** `POST /api/events/{event}/register`
- **Hủy đăng ký:** `DELETE /api/events/{event}/unregister`

---

## Xác thực và phân quyền

- **Tất cả route CRUD sự kiện và đăng ký đều cần Bearer Token (Sanctum)**
- **Phân quyền qua Policy:**
    - Chỉ `admin` hoặc `organizer` được tạo sự kiện
    - Chỉ `admin` được sửa/xóa sự kiện mình tạo
    - Chỉ `user` được đăng ký tham gia sự kiện

---

## Test API với Postman/cURL

### 1. Đăng ký hoặc đăng nhập để lấy token

**Đăng ký:**
- POST `http://127.0.0.1:8000/api/register`
- Body: JSON như trên

**Đăng nhập:**
- POST `http://127.0.0.1:8000/api/login`
- Body: JSON như trên
- Nhận `access_token` trong response

### 2. Gửi các request khác với header:
```
Authorization: Bearer <access_token>
```

**Ví dụ với cURL:**
```sh
curl -X GET http://127.0.0.1:8000/api/events \
  -H "Authorization: Bearer <access_token>"
```

---

## Ghi chú

- Nếu gặp lỗi 403 khi tạo sự kiện, hãy kiểm tra role user (chỉ `admin` hoặc `organizer` mới được tạo).
- Nếu gặp lỗi 401, kiểm tra lại token hoặc đăng nhập lại.
- Đảm bảo MySQL đang chạy và cấu hình `.env` đúng.
- Có thể dùng Thunder Client (VS Code), Hoppscotch, hoặc các công cụ khác để test API.

---

**Mọi thắc mắc hoặc lỗi, vui lòng liên hệ quản trị viên dự án để
