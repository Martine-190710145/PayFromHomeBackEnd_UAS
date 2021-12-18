@component('mail::message')
Halo **{{ $name }}**,  


Silakan klik tombol di bawah untuk memverifikasi alamat e-mail Anda.

@component('mail::button', ['url' => route('verification.verify', ['id' => $id, 'token' => $token])])
Konfirmasi Alamat E-mail
@endcomponent

Jika Anda tidak membuat akun, Anda tidak perlu melakukan apapun.

Salam,<br>
{{ config('app.name') }} Team.
@endcomponent
