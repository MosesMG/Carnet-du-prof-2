<style>
    .image-container {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }
    .image-container img {
        border-radius: 50%;
    }
    .message {
        color: #111;
    }
    .app-name {
        font-style: italic;
    }
</style>

<x-mail::message>

<div class="image-container">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" width="100px">
</div>

<p class="message">
    {{ $message }}
</p>

<p class="app-name">
    {{ config('app.name') }}
</p>
</x-mail::message>
