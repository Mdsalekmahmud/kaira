<h2>Your Account Created</h2>

<p>Email: {{ $user->email }}</p>

@if($password)
    <p>Password: <strong>{{ $password }}</strong></p>
@endif