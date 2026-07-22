# cse485-ms-03

# Phiếu bài tập 03

# MiniShop – Lập trình Hướng đối tượng (OOP) & Quản lý trạng thái (Session)

## 📌 Giới thiệu

Đây là dự án thực hành **Phiếu 03** của học phần **Lập trình Web**, xây dựng hệ thống **MiniShop** bằng **PHP thuần** theo mô hình **Lập trình Hướng đối tượng (OOP)**.

Mục tiêu của bài tập là chuyển đổi từ cách lập trình hướng cấu trúc (sử dụng mảng và hàm) sang lập trình hướng đối tượng thông qua hai lớp `Category` và `Product`. Đồng thời, dự án sử dụng **Session** để xây dựng chức năng đăng nhập, quản lý trạng thái người dùng và lưu danh sách đơn hàng tạm thời.

---

## 🎯 Mục tiêu

* Xây dựng hai lớp `Category` và `Product`.
* Quản lý dữ liệu bằng Object thay cho mảng thuần.
* Hiển thị danh sách sản phẩm thông qua các phương thức của Object.
* Áp dụng HTTP Session để quản lý đăng nhập.
* Xây dựng Dashboard có cơ chế bảo vệ (Authentication Guard).
* Thực hiện lưu đơn hàng tạm thời bằng Session.

---

## 📂 Cấu trúc thư mục

```text
cse485-ms-03/
├── src/
│   ├── Category.php
│   └── Product.php
├── data.php
├── login.php
├── dashboard.php
├── logout.php
└── README.md
```

### Chức năng từng file

| File               | Chức năng                                                                             |
| ------------------ | ------------------------------------------------------------------------------------- |
| `src/Category.php` | Định nghĩa lớp Category và phương thức `label()`                                      |
| `src/Product.php`  | Định nghĩa lớp Product với các phương thức `lineTotal()`, `stockLevel()`, `toArray()` |
| `data.php`         | Khởi tạo 3 Category và 8 Product bằng Object                                          |
| `login.php`        | Xử lý đăng nhập bằng phương thức POST và Session                                      |
| `dashboard.php`    | Hiển thị danh sách sản phẩm, tổng giá trị kho và quản lý đơn hàng                     |
| `logout.php`       | Hủy Session và đăng xuất                                                              |

---

## 🚀 Chức năng đã thực hiện

### 1. Lập trình Hướng đối tượng (OOP)

* Xây dựng lớp `Category`.
* Xây dựng lớp `Product`.
* Khởi tạo dữ liệu bằng Object.
* Hiển thị dữ liệu thông qua Object.
* Tính thành tiền bằng:

```php
$p->lineTotal();
```

* Kiểm tra mức tồn kho bằng:

```php
$p->stockLevel();
```

* Chuyển Object thành mảng bằng:

```php
$p->toArray();
```

---

### 2. Đăng nhập bằng Session

* Đăng nhập bằng phương thức POST.
* Lưu trạng thái đăng nhập:

```php
$_SESSION['auth'] = true;
$_SESSION['username'] = 'admin';
```

* Nếu chưa đăng nhập sẽ tự động chuyển về trang Login.

---

### 3. Authentication Guard

Ngăn người dùng truy cập trực tiếp vào `dashboard.php` khi chưa đăng nhập.

```php
if (empty($_SESSION['auth'])) {
    header('Location: login.php');
    exit;
}
```

---

### 4. Quản lý đơn hàng bằng Session

Dashboard cho phép người dùng:

* Chọn SKU.
* Nhập số lượng.
* Lưu vào:

```php
$_SESSION['orders']
```

Sau khi nhấn **F5**, dữ liệu vẫn được giữ nguyên trong Session.

---

### 5. Post/Redirect/Get (PRG)

Sau khi gửi form đặt hàng:

```php
header('Location: dashboard.php');
exit;
```

Giúp tránh gửi lại dữ liệu khi người dùng nhấn **F5**.

---

### 6. Bảo mật

* Escape dữ liệu bằng:

```php
htmlspecialchars()
```

* Không hiển thị mật khẩu.
* Không truyền mật khẩu qua URL.
* Chỉ sử dụng phương thức **POST** để đăng nhập.

---

## 📊 Dataset sử dụng

Theo **CANONICAL-DATA** của học phần.

### Categories

* Ban phim
* Chuot
* Man hinh

### Products

* KB-01 — Keychron K2
* KB-02 — Akko 3087
* KB-03 — Leopold FC660M
* MS-01 — Logitech M331
* MS-02 — Razer Viper
* MS-03 — Xiaomi Silent
* MN-01 — Dell 24 inch
* MN-02 — LG UltraFine

**Tổng số sản phẩm:** 8

**Tổng giá trị kho:** **41380000**

---

## ⚙️ Hướng dẫn chạy chương trình

1. Khởi động Apache trên XAMPP.
2. Chép project vào:

```text
C:\xampp\htdocs\
```

3. Mở trình duyệt:

```text
http://localhost/cse485-ms-03/login.php
```

4. Đăng nhập bằng tài khoản:

| Username | Password    |
| -------- | ----------- |
| admin    | MiniShop@03 |

5. Sau khi đăng nhập:

* Dashboard hiển thị 8 sản phẩm.
* Tổng giá trị kho là **41380000**.
* Có thể đặt hàng thử nghiệm.
* Đơn hàng được lưu bằng Session.
* Đăng xuất sẽ hủy Session.

---

## ✅ Kết quả đạt được

* Xây dựng thành công lớp `Category`.
* Xây dựng thành công lớp `Product`.
* Áp dụng OOP để quản lý dữ liệu.
* Hiển thị danh sách sản phẩm bằng Object.
* Tính toán bằng phương thức thay vì xử lý trực tiếp trong View.
* Xây dựng chức năng đăng nhập bằng Session.
* Bảo vệ Dashboard bằng Authentication Guard.
* Lưu danh sách đặt hàng bằng Session.
* Áp dụng Post/Redirect/Get (PRG).
* Tổng giá trị kho đúng theo dữ liệu chuẩn: **41380000**.

---

## 👨‍🎓 Thông tin sinh viên

* **Họ và tên:** Trần Đức Việt
* **Chuyên ngành:** Hệ thống Thông tin
