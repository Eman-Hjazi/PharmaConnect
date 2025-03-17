
// send page start 
   // الحصول على العناصر
   const codeInputs = document.querySelectorAll('.code');
   const sendButton = document.getElementById('sendButton');
   const countdownContainer = document.getElementById('countdownContainer');
   const resendLinkContainer = document.getElementById('resendLinkContainer');
   const countdownElement = document.getElementById('countdown');
   const resendLink = document.getElementById('resendLink');
   let countdownTimer;

   // وظيفة للتحقق من ملء جميع الحقول
   function checkInputs() {
       const allFilled = Array.from(codeInputs).every(input => input.value.trim() !== '');
       sendButton.disabled = !allFilled; // تعطيل/تمكين الزر بناءً على الحالة
   }

   // إضافة مستمع للأحداث على الحقول
   codeInputs.forEach((input, index) => {
       input.addEventListener('input', (e) => {
           checkInputs();
           if (e.target.value && index < codeInputs.length - 1) {
               // الانتقال إلى الحقل التالي تلقائيًا
               codeInputs[index + 1].focus();
           }
       });
   });

   // وظيفة للإرسال
   sendButton.addEventListener('click', () => {
       const code = Array.from(codeInputs).map(input => input.value).join('');
       
       // إرسال الرمز (مثال على الإرسال باستخدام fetch)
       console.log('إرسال الرمز:', code);

       // مسح الحقول بعد الإرسال
       codeInputs.forEach(input => input.value = '');
       sendButton.disabled = true; // تعطيل الزر مرة أخرى
   });

   // وظيفة لبدء العد التنازلي
   function startCountdown() {
       let seconds = 60;
       countdownElement.textContent = `الرجاء الانتظار ${seconds} ثانية قبل إعادة الإرسال.`;
       countdownContainer.style.display = 'block';
       resendLinkContainer.style.display = 'none'; // إخفاء رابط إعادة الإرسال
       countdownTimer = setInterval(() => {
           seconds--;
           countdownElement.textContent = `الرجاء الانتظار ${seconds} ثانية قبل إعادة الإرسال.`;
           if (seconds <= 0) {
               clearInterval(countdownTimer);
               countdownContainer.style.display = 'none';
               resendLinkContainer.style.display = 'block'; // عرض رابط إعادة الإرسال
           }
       }, 1000);
   }

   // عند النقر على رابط إعادة الإرسال
   resendLink.addEventListener('click', () => {
       // يمكنك إضافة وظيفة لإعادة إرسال رمز التحقق هنا
       console.log('إعادة إرسال الرمز');
       startCountdown(); // بدء العد التنازلي بعد إعادة الإرسال
   });

   // بدء العد التنازلي عند تحميل الصفحة
   startCountdown();

//  end send pag