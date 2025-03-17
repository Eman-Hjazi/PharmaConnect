<x-front.main>
<div class="sal">


    <!-- المحتوى الرئيسي -->
    <section class="hero-sal">

        <main class="container-sal">

            <div class="image-container">
                <img src="{{asset('front/images/Frame.png')}}" alt="شخص يحمل لافتة Click Here">
            </div>

            <h2>عليك التسجيل بالموقع أولاً!</h2>
            <p>
                هذا النص مثال لنص يمكن أن يستبدل بنفس المساحة المخصصة له هنا
            </p>

            <div class="buttons-container">
                <a href="{{route('login')}}"class="btn-sal login-btn">دخول</a>
                <a href="{{route('register')}}" class="btn-sal register-btn">تسجيل</a>
            </div>
        </main>



    </section>









</div>

</x-front.main>
