<div class="tptrack__product mb-40">
    <div class="tptrack__content grey-bg">
        <div class="tptrack__item d-flex mb-20">
            <div class="tptrack__item-icon">
                <i class="fal fa-user-unlock"></i>
            </div>
            <div class="tptrack__item-content">
                <h4 class="tptrack__item-title">Login Here</h4>
                <p>Your personal data will be used to support your experience throughout this
                    website, to manage access to your account.</p>
            </div>
        </div>
        <div class="tptrack__btn mt-3 mb-10">
            <a href="{{ route('login.google') }}" class="tptrack__submition"
                style="display: inline-block; text-align: center;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/768px-Google_%22G%22_logo.svg.png"
                    height="25" class="me-2" alt="">
                Login dengan Google
            </a>
        </div>
        <div class="mb-20 d-flex justify-content-between align-items-center">
            <div class="border my-2 w-50"></div>
            <span>Atau</span>
            <div class="border my-2 w-50"></div>
        </div>
        <form wire:submit.prevent="login">

            @error('email')
                <div class="alert alert-danger mb-2">{{ $message }}</div>
            @enderror

            <div class="tptrack__id mb-10">
                <div class="form">
                    <span><i class="fal fa-user"></i></span>
                    <input type="email" wire:model.defer="email" placeholder="Email address">
                </div>
            </div>

            <div class="tptrack__email mb-10">
                <div class="form">
                    <span><i class="fal fa-key"></i></span>
                    <input type="password" wire:model.defer="password" placeholder="Password">
                </div>
            </div>

            <div class="tpsign__remember d-flex align-items-center justify-content-between mb-15">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" wire:model="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <div class="tpsign__pass">
                    <a href="#">Forget Password</a>
                </div>
            </div>

            <div class="tptrack__btn">
                <button type="submit" class="tptrack__submition active">
                    Login Now<i class="fal fa-long-arrow-right"></i>
                </button>
            </div>
        </form>
    </div>
</div>