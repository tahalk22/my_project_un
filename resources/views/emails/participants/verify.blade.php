 

@component('mail::message')

<div style="text-align: center;">
    <img src="https://up6.cc/2025/04/174507865994461.png" style="width: 220px; " alt="Logo">
  </div>

<div style="text-align: center;">
  <h1 style="font-size: 22px; font-weight: bold; margin-bottom: 20px;  text-align: center;  color : rgb(0, 128, 126) ; ">تأكيد بريدك الإلكتروني</h1>

  <p style="font-size: 16px;  text-align: center;  color : rgb(0, 128, 126) ;  ">
    مرحبًا {{ $user->name }}، <br><br>
    شكرًا لتسجيلك في ملتقى ليبيا الدولي للتأمين التكافلي 2025. <br><br>
    يرجى الضغط على الزر التالي لتأكيد بريدك الإلكتروني:
  </p>
</div>

@component('mail::button', ['url' => url('/Email/Verify/' . $user->verification_token)])
تأكيد البريد الإلكتروني
@endcomponent

<div style="text-align: center; font-size: 14px; margin-top: 30px;">
  هذا الرابط صالح حتى {{ \Carbon\Carbon::parse($user->token_expires)->format('Y-m-d H:i') }} <br>
  إذا لم تقم بالتسجيل، يمكنك تجاهل هذه الرسالة.
</div>

@endcomponent