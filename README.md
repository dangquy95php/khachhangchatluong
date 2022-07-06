
Hi em!
Anh xin phép gửi 1 số chức năng trong giai đoạn 1 để bàn giao bên em 

Lịch trình bắt đầu tiến hành viết phần mềm(Gia đoạn 1) 3/6/2022 - 9/6/2022
Tài khoản nhân viên:
- Đăng ký sản tài khoản
- Danh sách tài khoản
Thông tin file data
- Xử lý dữ liệu sai sót và trùng lập trước khi import
- Xử lý dữ liệu và đưa số dòng dữ liệu cho nhân viên tuỳ ý
Xử lý dữ liệu khách hàng
- Nhật ký cuộc gọi
- Danh sách cuộc gọi
- Tạo data giả số tiền cho  nhân viên
- Cấp quyền nhân viên theo khu vực
- Lưu dữ liệu khi sau khi thao tác với khách hàng

Thời gian bàn giao sản phẩm giai đoạn 1: 10/6/2022 - 11/6/2022

GRANT CREATE, ALTER, DROP, INSERT, UPDATE, DELETE, SELECT, REFERENCES, RELOAD on khachangchatluong1.* TO 'khachhangchatluong'@'localhost' WITH GRANT OPTION;

### Hiển thị databases;
`show databases`

### Show user trong mysql
`SELECT user FROM mysql.user;`

### Tạo databases
`create database db_test`

### Cấp quyền user cho database
`GRANT ALL ON *.* TO 'user'@'localhost';`

### Chạy lệnh FLUSH 
`FLUSH PRIVILEGES;`

### Restart the mysqld service:
`sudo service mysqld restart`

### Confirm that the server has successfully restarted:
`sudo service mysqld status`
