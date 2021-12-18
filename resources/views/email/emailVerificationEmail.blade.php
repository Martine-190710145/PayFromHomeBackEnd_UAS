@component('mail::message')
Halo **{{ $name }},  
Terima kasih telah menggunakan {{ config('app.name') }}! Silahkan verifikasi e-mail Anda untuk dapat menggunakan layanan kami
@component('mail::button', ['url' => route('verification.verify', ['id' => $id, 'token' => $token])])
    Verifikasi E-mail
@endcomponent  
Hormat kami,
{{ config('app.name') }} Team.
@endcomponent