@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Edit Alamat Pengiriman</h2>
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

                    <form action="{{ route('address.update') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="name" value="{{ old('name', $order->name ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $order->phone ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Locality</label>
                            <input type="text" name="locality" value="{{ old('locality', $order->locality ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="address" rows="3" class="form-control">{{ old('address', $order->address ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kota</label>
                            <input type="text" name="city" value="{{ old('city', $order->city ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="state" value="{{ old('state', $order->state ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Negara</label>
                            <input type="text" name="country" value="{{ old('country', $order->country ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" name="zip" value="{{ old('zip', $order->zip ?? '') }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Alamat</label>
                            <select name="type" class="form-control">
                                <option value="home" {{ old('type', $order->type ?? '') == 'home' ? 'selected' : '' }}>Rumah</option>
                                <option value="work" {{ old('type', $order->type ?? '') == 'work' ? 'selected' : '' }}>Kantor</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-dark w-100">
                                Simpan Alamat
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</main>
@endsection
