<x-app-layout title="Login">
    <div class="row justify-content-center align-items-center g-4">
        <div class="col-md-6">
            <div class="hero-panel p-4 p-lg-5" style="--hero-image: url('https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=1200&q=85')">
                <div class="content">
                    <div class="hero-kicker mb-2">Smart Drive</div>
                    <h1 class="h2 fw-bold">Professional dealership task tracking.</h1>
                    <p class="mb-0">Keep every customer, car, and deadline visible from enquiry to handover.</p>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card surface-card">
                <div class="card-body p-4">
                    <h1 class="h4 mb-3">Login to Smart Drive</h1>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" id="remember" name="remember" type="checkbox">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="mt-3 mb-0">Need an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
