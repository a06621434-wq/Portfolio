@extends('admin.layout')
@section('title', 'Profile & Account')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-2xl font-bold text-white tracking-tight">Profile &amp; Account Settings</h1>
        <p class="mt-1 text-sm text-surface-200/50">Manage your administrator credentials, email address, password, and security preferences.</p>
    </div>

    <div class="space-y-6 max-w-4xl">
        {{-- Profile Information Card --}}
        <div class="glass-card p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Password Update Card --}}
        <div class="glass-card p-6 sm:p-8">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete Account Card --}}
        <div class="glass-card p-6 sm:p-8 border-red-500/20">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
