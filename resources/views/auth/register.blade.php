
<x-guest-layout>
<div id="page-content" class="page-content">
        <div class="banner">
            <div class="jumbotron jumbotron-bg text-center rounded-0" style="background-image: url('assets/img/bg-header.jpg');">
                <div class="container">
                    <h1 class="pt-5">
                        Register Page
                    </h1>
                    <p class="lead">
                        Save time and leave the groceries to us.
                    </p>

                    <div class="card card-login mb-5">
                        <div class="card-body">
                        <x-jet-validation-errors class="mb-4" />
                            <form class="form-horizontal" action="{{ route('register') }}" method="POST">
                                @csrf
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="name"  placeholder="Full Name" :value="old('name')" required autofocus autocomplete="name">
                                    </div>
                                </div>
                                <div class="form-group row mt-3">
                                    <div class="col-md-12">
                                        <input class="form-control" type="email" name="email" placeholder="Email" :value="old('email')" required>
                                    </div>
                                </div>
                               
                                
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" type="password" name="password" placeholder="Password" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input class="form-control" type="password"  placeholder="Confirm Password" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="checkbox">
                                            <input id="checkbox0" type="checkbox" name="terms" required>
                                            <label for="checkbox0" class="mb-0">I Agree with <a href="/terms" class="text-light">Terms & Conditions</a> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row text-center mt-4">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-block text-uppercase">Register</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                     
</x-guest-layout>
