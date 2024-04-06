<x-mail::message>
    Welcome to Our University Platform!
    Dear {{ $data['firstName'] }} {{ $data['lastName'] }},
    We are excited to have you join our university community! As a new {{ $data['role'] }}, we have created an account
    for
    you on our platform. Here are the details:
    <h3>Account Information:</h3>
    <p>Email: {{ $data['email'] }}</p>
    <p>Password: {{ $data['password'] }}</p> Please note that you can change your password by logging into your account
    and visiting the "Account Settings" page.
    {{-- <x-mail::button :url="www.google.com">
        Log In Now
    </x-mail::button> --}}
    If you have any questions or issues, please don't hesitate to contact us at support@university.com.
    Thanks,
    {{ config('app.name') }}
</x-mail::message>
