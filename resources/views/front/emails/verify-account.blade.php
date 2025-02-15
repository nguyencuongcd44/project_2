<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Minh Tài Khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
            border-radius: 8px;
        }
        .btn-verify {
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .btn-verify:hover {
            background-color: #218838;
        }
        .footer {
            margin-top: 20px;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Xin chào, {{ $account->name }}</h2>
        <p>Cảm ơn bạn đã đăng ký tài khoản tại website của chúng tôi. Vui lòng nhấn vào nút dưới đây để xác minh email và hoàn tất quá trình đăng ký:</p>

        <p style="text-align: center;">
            <a href="{{ route('account.verify', $account->email) }}" class="btn-verify">Xác Minh Tài Khoản</a>
        </p>

        <p>Nếu bạn không thực hiện hành động này, vui lòng bỏ qua email này.</p>

        <div class="footer">
            <p>Trân trọng,<br>
            Đội ngũ hỗ trợ website</p>
        </div>
    </div>
</body>
</html>
