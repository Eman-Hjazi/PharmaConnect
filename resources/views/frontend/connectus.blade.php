<x-front.main>


    <div class="connect">
        <div class="container-connect">
            <div class="contact-box">
                <div class="contact-info">
                    <h2>تواصل معنا</h2>
                    <p>هذا النص مثال لنص يمكن أن يستبدل بنفس المساحة المخصصة له هنا</p>
                    <img src="{{asset('front/images/doctor.png')}}" alt="تواصل معنا">
                </div>
                <div class="contact-form">
                    <form class="form">
                        <label for="name">الاسم</label>
                        <input type="text" id="name" placeholder="الاسم">

                        <label for="email">البريد الإلكتروني</label>
                        <input type="email" id="email" placeholder="البريد الإلكتروني">

                        <label for="phone">رقم الجوال</label>
                        <input type="tel" id="phone" placeholder="رقم الجوال">

                        <label for="message">المشكلة</label>
                        <textarea id="message" placeholder="اكتب هنا ..."></textarea>

                        <button  class="btn-connect" type="submit">إرسال</button>
                    </form>
                </div>
            </div>
        </div>

    </div>




</x-front.main>
