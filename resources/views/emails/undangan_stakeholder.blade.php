<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan untuk Mengisi Form Lulusan</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
            text-align: center;
        }

        .button {
            display: inline-block;
            width: 100%;
            /* Make the button take full width */
            padding: 12px 20px;
            margin: 20px 0;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            text-align: center;
            box-sizing: border-box;
            /* Ensure padding doesn't overflow */
        }

        .button:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 30px;
        }

        .text-center img {
            display: block;
            margin: 0 auto;
            max-width: 150px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo Section -->
        <div class="text-center mb-4">
            <img src="https://imgs.search.brave.com/VVAHsI1VEJi5_Sp5Rf660mLtDP-f6LSHiLdIHvlN9oQ/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly91cGxv/YWQud2lraW1lZGlh/Lm9yZy93aWtpcGVk/aWEvY29tbW9ucy82/LzY0L0p0aV9wb2xp/bmVtYS5zdmc"
                alt="Logo" class="img-fluid">
        </div>

        <!-- Title -->
        <h1>Undangan untuk Mengisi Form Tracer Study</h1>

        <!-- Message -->
        <p>Selamat! Anda telah berhasil menyelesaikan studi, dan kami ingin mengundang Anda untuk mengisi form lulusan.
            Silakan klik tombol di bawah ini untuk mengisi form lulusan:</p>

        <!-- Full-Width Button -->
        <a href="{{ $invitationLink }}" class="button text-white">Isi Form</a>
        <!-- Token Information -->

        <!-- Footer -->
        <div class="footer">
            <p>Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami.</p>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>