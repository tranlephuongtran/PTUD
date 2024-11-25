document.querySelector("form").addEventListener("submit", function (e) {
  // Lấy giá trị từ các input
  const hoTen = document.getElementById("hoTen").value.trim();
  const tenDangNhap = document.getElementById("tenDangNhap").value.trim();
  const email = document.getElementById("email").value.trim();
  const sdt = document.getElementById("sdt").value.trim();
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("confirmPassword").value;

  // Biểu thức chính quy
  const hoTenRegex = /^[a-zA-ZÀ-ỹ\s]{3,50}$/; // Họ tên: cho phép chữ, dấu tiếng Việt, tối thiểu 3 ký tự
  const tenDangNhapRegex = /^[a-zA-Z0-9_]{5,20}$/; // Tên đăng nhập: 5-20 ký tự, không dấu, cho phép số và "_"
  const emailRegex = /^[a-zA-Z0-9]+@gmail\.com$/; // Email chuẩn
  const sdtRegex = /^(0[3|5|7|8|9])+([0-9]{8})$/; // Số điện thoại: 10 số, bắt đầu bằng 03, 05, 07, 08, 09
  const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Mật khẩu: tối thiểu 8 ký tự, ít nhất 1 chữ cái và 1 số

  // Kiểm tra từng trường
  if (!hoTenRegex.test(hoTen)) {
    alert(
      "Họ và tên không hợp lệ. Vui lòng nhập ít nhất 3 ký tự, không chứa số."
    );
    e.preventDefault();
    return;
  }

  if (!tenDangNhapRegex.test(tenDangNhap)) {
    alert(
      "Tên đăng nhập không hợp lệ. Vui lòng nhập từ 5-20 ký tự, không dấu."
    );
    e.preventDefault();
    return;
  }

  if (!emailRegex.test(email)) {
    alert(
      "Email không hợp lệ. Vui lòng nhập email đúng định dạng. (vd: abc123@gmail.com)"
    );
    e.preventDefault();
    return;
  }

  if (!sdtRegex.test(sdt)) {
    alert(
      "Số điện thoại không hợp lệ. Vui lòng nhập đúng định dạng 10 số bắt đầu bằng 03, 05, 07, 08, hoặc 09."
    );
    e.preventDefault();
    return;
  }

  if (!passwordRegex.test(password)) {
    alert(
      "Mật khẩu không hợp lệ. Mật khẩu phải chứa ít nhất 8 ký tự, gồm chữ cái và số."
    );
    e.preventDefault();
    return;
  }

  //   if (password !== confirmPassword) {
  //     alert("Mật khẩu xác nhận không khớp.");
  //     e.preventDefault();
  //     return;
  //   }

  // Nếu tất cả đều hợp lệ
  //   alert("Đăng ký thành công!");
});
