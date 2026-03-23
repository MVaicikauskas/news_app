<x-mail::message>
# Užsiregistravo naujas autorius

Naujas autorius užsiregistravo ir patvirtino savo el. pašto adresą.

**Vardas:** {{ $user->{App\Models\User::COL_NAME} }}
**El. paštas:** {{ $user->{App\Models\User::COL_EMAIL} }}

Šiuo metu autorius laukia administratoriaus patvirtinimo, kad galėtų skelbti turinį.

<x-mail::button :url="config('app.url') . '/admin/verify-authors'">
Peržiūrėti visus autorius
</x-mail::button>

Ačiū,<br>
{{ config('app.name') }}
</x-mail::message>
