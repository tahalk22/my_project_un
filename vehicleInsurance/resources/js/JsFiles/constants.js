 
export const user_level = {
    '1': 'سوبر أدمن',
    '2': ' أدمن شركة',
    '3': ' أدمن مكتب',
    '4': 'مستخدم',
  };
 
 

  export const clause_type = {
  1: 'PV - شرط أساسي',
  2: 'CV - شرط إضافي',
};


export const insurance_years = [1, 2, 3];

export const made_years = Array.from({ length: new Date().getFullYear() - 1999 }, (_, i) => 2000 + i);


export const  additional_fee_per_year = 30 ;

export const  id_types  =  {
  1: 'بطاقة شخصية',
  2: 'جواز سفر',
};
// الرمز	المعنى المحتمل	الاستخدام العملي
// PV	Policy Value أو Primary Value	تشير إلى الشروط الأساسية التي تُعد جزءًا لا يتجزأ من الوثيقة وتؤثر في القيمة التأمينية مباشرة
// CV	Contractual Value أو Conditional Value	تشير إلى الشروط التعاقدية الإضافية، والتي تُطبق حسب الظروف أو بناءً على اتفاق إضافي
 
 export const  claim_type   =  {
  1: 'حادث  تصادم',
  2: ' ضرر غير ناتج عن حادث ',
};
 export const  claim_status   =  {
  1: 'مطالبة جديدة',
  2: 'قيد  المعالجة',
  3: 'تم القبول',
  4: 'تم الرفض',
};
  