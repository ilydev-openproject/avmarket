<x-app>

    <!-- breadcrumb-area-start -->
    <div class="breadcrumb__area pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-breadcrumb__content">
                        <div class="tp-breadcrumb__list">
                            <span class="tp-breadcrumb__active"><a href="index.html">Home</a></span>
                            <span class="dvdr">/</span>
                            <span>Sign in</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb-area-end -->

    <!-- track-area-start -->
    <section class="track-area pb-40">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-12">
                    <livewire:auth.login-form />
                </div>
                <!-- <div class="col-lg-6 col-sm-12">
                    <div class="tptrack__product mb-40">
                        <div class="tptrack__content grey-bg">
                            <div class="tptrack__item d-flex mb-20">
                                <div class="tptrack__item-icon">
                                    <i class="fal fa-lock"></i>
                                </div>
                                <div class="tptrack__item-content">
                                    <h4 class="tptrack__item-title">Sign Up</h4>
                                    <p>Your personal data will be used to support your experience throughout this
                                        website, to manage access to your account.</p>
                                </div>
                            </div>
                            <div class="tptrack__id mb-10">
                                <form action="#">
                                    <span><i class="fal fa-envelope"></i></span>
                                    <input type="email" placeholder="Email address">
                                </form>
                            </div>
                            <div class="tptrack__email mb-10">
                                <form action="#">
                                    <span><i class="fal fa-key"></i></span>
                                    <input type="text" placeholder="Password">
                                </form>
                            </div>
                            <div class="tpsign__account mb-15">
                                <a href="#">Already Have Account?</a>
                            </div>
                            <div class="tptrack__btn">
                                <button class="tptrack__submition tpsign__reg">Register Now<i
                                        class="fal fa-long-arrow-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </section>
    <!-- track-area-end -->
</x-app>