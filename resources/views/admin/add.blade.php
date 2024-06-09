<x-app-layout>
    <header>
        <h2>Admin Registration</h2> 
    </header>
    <br>

    <section>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style='list-style-type: none;'>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('registerAdmin') }}" method="post" class="registration-form" id="form">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}" value="{{ old('phone') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="password_confirmation" required>
                </div>
                <label class="form-check-label" for="type">User Type</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="doctor" name="type" value="doctor">
                    <label class="form-check-label" for="doctor">Doctor</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" id="admin" name="type" value="admin">
                    <label class="form-check-label" for="admin">Admin</label>
                </div>
                <br>
                <button type="submit" class="btn btn-primary btn-big">Register</button>
            </form>
        </div>
    </section>
</x-app-layout>
