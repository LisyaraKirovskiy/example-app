@extends('layouts.app')
@section('title', 'Создание нового пользователя')

@section('content')
    <!DOCTYPE html>
    <html lang="ru">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Создать пользователя</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: #f8f9fa;
                padding-top: 40px;
            }

            .card {
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            }

            .card-header {
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                color: white;
                border-radius: 15px 15px 0 0;
            }

            .btn-primary {
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                border: none;
            }

            .form-control:focus {
                border-color: #6a11cb;
                box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center py-3">
                            <h4 class="mb-0">Создать нового пользователя</h4>
                        </div>

                        <div class="card-body p-4">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div>{{ session('success') }}</div>
                                </div>
                            @endif
                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Имя <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                        placeholder="Введите имя" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                        placeholder="email@example.com" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Пароль <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control"
                                        placeholder="Минимум 8 символов" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Подтвердите пароль <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                        placeholder="Повторите пароль" required>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary me-md-2">← Назад</a>
                                    <button type="submit" class="btn btn-primary px-4">Создать</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
@endsection