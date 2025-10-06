<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>فاتورة ضريبية</title>
    <style>
        body {
            font-family: 'Tajawal';
            direction: rtl;
            text-align: right;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .invoice-container {
            width: 100%;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .header h1 {
            color: #4CAF50;
            margin: 0;
            font-size: 24px;
        }
        
        .company-info {
            margin-bottom: 20px;
        }
        
        .invoice-info {
            display: block;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .invoice-details {
            width: 48%;
            float: right;
        }
        
        .client-details {
            width: 48%;
            float: left;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .total {
            font-weight: bold;
            font-size: 16px;
            margin-top: 15px;
            text-align: left;
            clear: both;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
        
        .stamp {
            float: left;
            width: 120px;
            height: 120px;
            border: 2px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }
        
        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- رأس الفاتورة -->
        <div class="header">
            <h1>فاتورة ضريبية</h1>
            <p>رقم الفاتورة: INV-{{ date('YmdHis') }}</p>
        </div>
        
        <!-- معلومات الشركة -->
        <div class="company-info">
            <h2>شركة الملتقى التقني</h2>
            <p>السعودية - الرياض - حي الملقا</p>
            <p>السجل التجاري: 1010666888</p>
            <p>الرقم الضريبي: 3100666888</p>
            <p>هاتف: 0112345678</p>
        </div>
        
        <!-- معلومات الفاتورة والعميل -->
        <div class="invoice-info">
            <div class="invoice-details">
                <h3>معلومات الفاتورة</h3>
                <p>تاريخ الفاتورة: {{ date('Y-m-d') }}</p>
                <p>تاريخ الاستحقاق: {{ date('Y-m-d', strtotime('+7 days')) }}</p>
            </div>
            
            <div class="client-details">
                <h3>معلومات العميل</h3>
                <p>الاسم: السنوسي محمد بن الفقيه</p>
                <p>الهاتف: 0501234567</p>
                <p>البريد الإلكتروني: customer@example.com</p>
            </div>
            <div class="clearfix"></div>
        </div>
        
        <!-- جدول العناصر -->
        <table>
            <thead>
                <tr>
                    <th width="10%">#</th>
                    <th width="50%">الوصف</th>
                    <th width="15%">الكمية</th>
                    <th width="15%">السعر</th>
                    <th width="20%">المجموع</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>اشتراك سنوي في الملتقى التقني</td>
                    <td>1</td>
                    <td>1,000 ر.س</td>
                    <td>1,000 ر.س</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>حضور ورشة العمل</td>
                    <td>2</td>
                    <td>500 ر.س</td>
                    <td>1,000 ر.س</td>
                </tr>
            </tbody>
        </table>
        
        <!-- المجموع الكلي -->
        <div class="total">
            <p>المجموع قبل الضريبة: 2,000 ر.س</p>
            <p>الضريبة (15%): 300 ر.س</p>
            <p>المجموع النهائي: <strong>2,300 ر.س</strong></p>
        </div>
        
     
        <div class="clearfix"></div>
        
    
    </div>
</body>
</html>