@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Informasi Akun</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__dashboard">

                    @if (session('success'))
                        <div class="bg-gray-100 text-gray-800 p-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('account.details.update') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-dark w-100">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection
