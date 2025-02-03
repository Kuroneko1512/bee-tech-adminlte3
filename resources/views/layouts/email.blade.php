<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            font-family: 'Source Sans Pro', sans-serif;
        }
        .email-header {
            background: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .email-content {
            background: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .btn {
            display: inline-block;
            padding: 8px 16px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            padding: 12px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>
<body style="background: #f4f6f9;">
    <div class="email-container">
        @yield('content')
    </div>
</body>
</html>
