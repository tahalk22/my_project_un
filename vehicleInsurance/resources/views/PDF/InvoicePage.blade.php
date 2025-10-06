<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاتورة الدفع</title>
    <style>
        body {
            font-family: 'xbriyaz', 'Arial', sans-serif;
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        th {
            background-color: #f5f5f5;
        }
        .bank-info {
            border: 1px solid #eee;
            padding: 10px;
            margin-bottom:5px;
            border-radius: 5px;
        }
        .bank-info h4 ,   .bank-info p {
                margin : 3px ;
        }
        .header_2  ,  .header_2  h2  , .header_2  p {
             margin : 0px  !important; 
        }

    </style>
</head>
<body>

<div style="width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; header">

    <!-- Header -->
    <div style="overflow: hidden; margin-bottom: 20px;  header_1 ">
        <div style="float: left; width: 50%; text-align: left;"> 
            {{-- <img src="{{ asset('images/sponsers/2.png') }}" style="height: 60px; margin-bottom: 4px; " alt="شعار الراعي 1">
            <img src="{{ asset('images/sponsers/3.png') }}" style="height: 70px; margin-right: 20px;" alt="شعار الراعي 2"> --}}
            <img src="{{ public_path('images/sponsers/2.png') }}" style="height: 60px; margin-bottom: 4px; "  alt="شعار الراعي 1">
            <img src="{{ public_path('images/sponsers/3.png') }}" style="height: 70px; margin-right: 20px;"  alt="شعار الراعي 2">
        </div>
        <div style="float: right; width: 50%; text-align: right;  header_2">
            <h2 style="color: #00807e; margin : 0px ;">فاتورة الدفع</h2>
            <p style="margin: 5px 0;"><strong>رقم الفاتورة:</strong> #{{  $data['invoice_id'] }}</p>
            <p style="margin: 5px 0;"><strong>التاريخ:</strong> {{    $data['date'] }}</p>
        </div>
    </div>

    <!-- معلومات العميل -->
    <table>
        <tr>
            <th style="width: 30%;">الشركة </th>
            <td>{{   $data['user']['participant']['organization'] }}</td>
        </tr>
        <tr>
            <th> الاسم</th>
            <td>{{ $data['user']['name']   }}</td>
        </tr>
    </table>

    <!-- تفاصيل الفاتورة -->
    <table>
        <thead>
            <tr>
                <th style="width: 70%;">البند</th>
                <th> المبلغ    {{   $data['user']['participant']['participant_type'] ==  1  ?   '(د.ل)' :  '$'   }}   </th>
            </tr>
        </thead>
        <tbody>
            @if ( $data['user']['participant']['attendance_type']    == 1  || $data['user']['participant']['attendance_type']      ==  3   )
            <tr>
                <td> رسوم التسجيل في الملتقى الليبي للتأمين التكافلي 2025    </td>
                <td>{{ $data['user']['participant']['participant_type']    ==  1      ?  '1000' :  ($data['user']['participant']['participant_type']    ==  2 ?  '500'    : '')      }} </td>
            </tr>
            @endif
            @if ( $data['user']['participant']['attendance_type']    == 2  ||  $data['user']['participant']['attendance_type']     ==  3 ) 
                <tr>
                    <td> رسوم التسجيل في الدورة المصاحبة للملتقى الليبي للتأمين التكافلي 2025     </td>
                    <td>{{   $data['user']['participant']['participant_type']    ==  1      ?  '1000' :  ($data['user']['participant']['participant_type']    ==  2 ?  '500'    : '')      }} </td>
                </tr>
            @endif
       
   
            <tr>
                <td style="font-weight: bold;">الإجمالي</td>
                <td style="font-weight: bold;">
                    {{  
                        ($data['user']['participant']['attendance_type'] == 1 || $data['user']['participant']['attendance_type'] == 2) && $data['user']['participant']['participant_type'] == 1
                            ? '1000 دينار'
                            : ( ($data['user']['participant']['attendance_type'] == 3) && $data['user']['participant']['participant_type'] == 1
                                ? '2000 دينار'
                                : ( ($data['user']['participant']['attendance_type'] == 1 || $data['user']['participant']['attendance_type'] == 2) && $data['user']['participant']['participant_type'] == 2
                                    ? '500 $'
                                    : ( ($data['user']['participant']['attendance_type'] == 3) && $data['user']['participant']['participant_type'] == 2
                                        ? '1000 $'
                                        : ''
                                      )
                                  )
                              )
                    }}
                
            </td>
            </tr>
        </tbody>
    </table>

    <!-- قسم الدفع - تصميم متوازي -->
 
    <div style="overflow: hidden;  "   > 
        <!-- تعليمات الدفع على اليمين -->
        <div style="float: right; width: 40%; padding: 15px; border-top: 1px solid #eee; text-align: right; font-size: 14px ;"  >
            <h3 style="margin: 0px">خيارات الدفع:   </h3>

            <p>1. الدفع نقدًا: عند الوصول إلى مقر الملتقى.</p>
            <p>2. التحويل البنكي: يُرجى إرسال صورة إيصال الحوالة عبر:</p>
            <ul class="list-disc pr-5">
              <li>حسابك على موقع الملتقى.</li>
              <li style="font-weight: bold;" >أو عبر البريد الإلكتروني: support@takafulforum.com</li>
            </ul>
 
        </div>
        @if ( $data['user']['participant']['participant_type']    ==  2    )    
        <!-- معلومات الحسابات على اليسار -->
        <div style="float: left; width: 48%; padding: 0pxpx 5px 1px 5px ; border-top: 1px solid #eee; font-size: 14px;">
            <h3 style="text-align: right;">     تفاصيل الحساب البنكي  :</h3>
            
            <div class="bank-info" style="direction: ltr; text-align: left;">
                <h4>First Account:</h4>
                <p><strong>Bank Name:</strong> Jordan Islamic Bank</p>
                <p><strong>Account Name:</strong> The International Federation of Takaful & Islamic Insurance Companies</p>
                <p><strong>Account Number:</strong> 2260113410400002</p>
                <p><strong>IBAN:</strong> JO50 JIBA 002000226011 3410400002</p>
                <p><strong>Swift Code:</strong> JIBAJOAMXXX</p>
                <p><strong>Bank Address:</strong> Amman, Jordan</p>
            </div>
            
            <div class="bank-info" style="direction: ltr; text-align: left;">
                <h4>Second Account:</h4>
                <p><strong>Bank Name:</strong> Sahara Bank</p>
                <p><strong>Account Name:</strong> Libyan Insurance Federation</p>
                <p><strong>Account Number:</strong> 2003662643</p>
                <p><strong>IBAN:</strong> LY34006001000002003662643</p>
                <p><strong>Swift Code:</strong> SABKYL XXXX</p>
                <p><strong>Bank Address:</strong> Tripoli, Libya</p>
            </div>
        </div>

        @elseif ( $data['user']['participant']['participant_type']    == 1    ) 
        <div style="float: left; width: 48%; padding: 0pxpx 5px 1px 5px ; border-top: 1px solid #eee; font-size: 14px;">
            <h3 style="text-align: right;">     تفاصيل الحساب البنكي  :</h3>
            
            <div class="bank-info" style="direction: ltr; text-align: right;">
         
                <p><strong>اسم البنك  :</strong>  مصرف الصحارى الفرع الرئيسي        </p>
                <p><strong>رقم الحساب    :</strong> 2000201483 </p>
            </div>
        </div>
        @endif

    </div>


 

    <!-- التوقيع -->
    <div style="margin-top: 20px; text-align: right; clear: both;">
        <p>  </p>
        <p style="font-weight: bold;">الإتحاد الليبي للتأمين</p>
        <p style="font-weight: bold;">إدارة الشؤون المالية</p>
    </div>
</div>
</body>
</html>