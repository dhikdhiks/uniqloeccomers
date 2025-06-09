@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="wg-box">
            <h3>Send Email to {{ $contact->name }}</h3>
            <form action="{{ route('admin.contact.email.send', $contact->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="subject">Subject:</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="message">Message:</label>
                    <textarea name="message" class="form-control" rows="6" required></textarea>
                </div>
                <button type="submit" class="tf-button style-1">
                    <i class="icon-send"></i> Send Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
