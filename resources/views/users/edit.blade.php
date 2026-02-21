@extends('layouts.app')
@section('title', 'Редактировать пользователя')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Редактировать пользователя
                            </h4>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-light">
                                ← Назад
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h5>Ошибки:</h5>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-row gap-5">
                                <div class="rounded-circle bg-gradient d-flex align-items-center justify-content-center text-white fw-bold shadow-sm overflow-hidden"
                                    style="width: 80px; height: 80px; background: #6366f1">
                                    <img id="avatar-preview" src="{{ asset($user->avatarPath()) }}" alt="Avatar"
                                        class="rounded-circle w-100 h-100 object-fit-cover" style="margin-left:18px">
                                    <span id="avatar-placeholder" class="fs-1">?</span>
                                </div>
                                <div class="d-flex flex-column gap-1 mt-3">
                                    <input type="file" name="avatar" id="avatar" class="form-control">
                                    <p for="avatar" class="small">JPG,JPEG,PNG,GIF</p>
                                    @error('avatar')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>

                            <div class="mb-3">
                                <label class="form-label">Имя <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                    placeholder="Введите имя" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $user->email) }}" placeholder="email@example.com" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Телефон</label>
                                <div class="d-flex flex-column">


                                    @if($user->phones->isNotEmpty())
                                        @foreach ($user->phones as $index => $phone)
                                            <div class="d-flex flex-row">
                                                <select name="phones[{{ $index }}][brand_id]" id="phoneBrand" class="form-control">
                                                    @foreach ($phoneBrands as $phoneBrand)
                                                        <option value="{{ $phone->phone_brand_id }}" {{ $phone->phone_brand_id == $phoneBrand->id ? 'selected' : '' }}>
                                                            {{ $phoneBrand->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input name="phones[{{ $index }}][number]" type="phone" value="{{ $phone->number }}"
                                                    class="form-control">
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                            <div class="d-flex flex-row">
                                <select name="phones[{{ count($user->phones) }}][brand_id]" class="form-control">
                                    @foreach ($phoneBrands as $phoneBrand)
                                        <option value="{{ $phoneBrand->id }}">
                                            {{ $phoneBrand->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <input name="phones[{{ count($user->phones) }}][number]" type="phone" class="form-control"
                                    placeholder="Номер телефона">
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Новый пароль</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Оставьте пустым, если не меняете">
                                <small class="text-muted">Минимум 8 символов</small>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Подтверждение пароля</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Повторите новый пароль">
                            </div>
                            @can('change-role')
                                <div class="mb-3">
                                    <label class="form-label">Роль</label>
                                    <select class="form-control" name="role">
                                        <option value="{{ 1 }}" {{ $user->role_id == 1 ? 'selected' : '' }}>Guest</option>
                                        <option value="{{ 2 }}" {{ $user->role_id == 2 ? 'selected' : '' }}>Moderator</option>
                                        <option value="{{ 3 }}" {{ $user->role_id == 3 ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                            @endcan
                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                    Отмена
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Сохранить
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('avatar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
            }

        });
    </script>
@endsection