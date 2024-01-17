<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --}}
    {{-- <meta http-equiv="X-UA-Compatible" content="ie=edge"> --}}
    <title>Document</title>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="your-integrity-here" crossorigin="anonymous"> --}}
    <style>
        /* body { */

        /* padding: 0px; */
        /* margin: -10px -20px; */
        /* } */
        body {
            font-family: 'DroidArabicNaskhRegular', sans-serif; /* Replace with your Arabic font */
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            color: #b99052;
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            font-size: 14px;
        }

        .page-break {
            background: white;
            page-break-inside: avoid;
            page-break-before: always;
        }

        .tdCompanyName {
            padding: 3px;
            width: 33.33%;
        }

        .w-33 {
            width: 33.33%;
        }

        .border {
            border: 1px solid #b99052;
        }

        .border-r {
            border-right: 1px solid #b99052 !important;
        }

        .border-l {
            border-left: 1px solid #b99052;
        }

        .border-t {
            border-top: 1px solid #b99052;
        }

        .border-b {
            border-bottom: 1px solid #b99052;
        }

        .alignc {
            text-align: center;
        }

        .alignl {
            text-align: left;
        }

        .alignr {
            text-align: right;
        }

        .w-50 {
            width: 50%;
        }

        .vtop {
            vertical-align: top;
        }

        .padd {
            padding: 3px;
        }

        .w-5 {
            width: 5%;
        }

        .w-20 {
            width: 20%;
        }

        .w-30 {
            width: 25%;
            border-bottom: 1px dashed #b99052;
        }

        .w-40 {
            width: 40%;
            border-bottom: 1px dashed #b99052;
        }

        .vbottom {
            vertical-align: bottom;
        }

        .fontb {
            font-weight: bolder;

        }

        .height {
            line-height: 15px;
        }

        .height1 {
            line-height: 18px;
        }

        .height2 {
            line-height: 15px;
        }

        #w-40 {
            width: 40%;
        }

        #w-60 {
            width: 60%;
        }

        /* Basic Rules */
        .switch input {
            display: none;
        }

        .switch {
            display: inline-block;
            width: 50px;
            height: 18px;
            margin: 8px;
            transform: translateY(25%);
        }

        /* Style Wired */
        .slider {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            border-radius: 30px;
            box-shadow: 0 0 0 2px #777, 0 0 4px #777;
            cursor: pointer;
            border: 4px solid transparent;
            overflow: hidden;
            transition: 0.4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            background: #777;
            border-radius: 30px;
            transform: translateX(-30px);
            transition: 0.4s;
        }

        input:checked+.slider:before {
            transform: translateX(30px);
            background: limeGreen;
        }

        input:checked+.slider {
            box-shadow: 0 0 0 2px limeGreen, 0 0 2px limeGreen;
        }
    </style>
</head>

<body>
    <div class="" style="border: 1px solid #000;padding: 18px;">
        <table class="tblCompanyDetail">
            <tbody>
                <tr>
                    <td class="tdCompanyName w-33"style="text-align: left; line-height: 16px;">
                        <div class="lblCompanyAdd">
                            <i
                                id="">{{ $data['branch']['address_line_1'] }},{{ $data['branch']['address_line_2'] }}</i>
                            <br><i id="">{{ $data['branch']['name'] }},{{ $data['company']['text'] }}</i>
                            <br><i id="">{{ $data['branch']['area'] }}-{{ $data['branch']['pincode'] }}</i>
                            <br>
                            <img src="https://erp.whitelion.in/axone_work/whatsapp.svg" style="width: 11px;"
                                alt="">&nbsp;&nbsp;<i id="">{{ $data['branch']['phone_number'] }}</i>
                            <br><img src="https://erp.whitelion.in/axone_work/email.svg" style="width: 11px;"
                                alt="">&nbsp;<i id="">{{ $data['branch']['email'] }}</i>
                            <br><img src="https://erp.whitelion.in/axone_work/mouse.svg" style="width: 11px;"
                                alt="">&nbsp;
                            www.diamondsdubai.ae
                        </div>
                    </td>
                    <td class="tdCompanyName w-33 vbottom alignc">
                        @if ($data['company']['company_id'] == 2)
                            <img src="https://erp.whitelion.in/axone_work/mamiyajwellers1.png" style="width: 90%"
                                id="" alt="">
                        @else
                            <img src="https://erp.whitelion.in/axone_work/evagems.png" style="width: 90%" id=""
                                alt="">
                        @endif
                    </td>
                    <td class="tdInvoiceType w-33" style="text-align: right;line-height: 16px;">
                        <div class="lblCompanyAdd">
                            <i
                                id="">{{ $data['branch']['arabic_address_line_1'] }},{{ $data['branch']['arabic_address_line_2'] }}</i>
                            <br><i id="">{{ $data['branch']['name'] }},{{ $data['company']['text'] }}</i>
                            <br><i
                                id="">{{ $data['branch']['arabic_area'] }}-{{ $data['branch']['pincode'] }}</i>
                            <br><i id="">{{ $data['branch']['phone_number'] }}</i>&nbsp;<img
                                src="https://erp.whitelion.in/axone_work/whatsapp.svg" style="width: 11px;"
                                alt="">
                            <br><i id="branch_email_arbic">{{ $data['branch']['email'] }}</i>&nbsp;<img
                                src="https://erp.whitelion.in/axone_work/email.svg" style="width: 11px;" alt="">
                            <br> www.diamondsdubai.ae &nbsp;<img src="https://erp.whitelion.in/axone_work/mouse.svg"
                                style="width: 11px;" alt="">
                        </div>
                    </td>
                </tr>
                @if ($data['company']['company_id'] == 2)
                    <tr style="line-height: 10mm;">
                        <td class="w-33 fontb" style="font-size: 18px;">Planet Tax Free</td>
                        <td class="w-33 fontb" style="text-align: center;vertical-align: middle;font-size: 16px;">TRN: &nbsp; <span>100282361300007</span>
                            </td>
                        <td class="w-33 fontb" style="font-size: 18px; text-align: end">INVOICE
                            NO-{{ $data['Order']['id'] }}</td>
                    </tr>
                    <tr>

                        <td class="" style="vertical-align: middle;font-size: 15px;"> No :&nbsp;&nbsp;&nbsp;<i
                                id="" style="border-bottom: 1px dashed #b99052">AE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></td>
                        <td></td>
                        <td class="w-33" style="text-align: end;vertical-align: middle;font-size: 15px;"> date
                            :&nbsp;
                            <i
                                id=""style="border-bottom: 1px dashed #b99052;">{{ date('d/M/Y', strtotime($data['branch']['created_at'])) }}</i>
                        </td>
                    </tr>
                @else
                    <tr style="line-height: 10mm;">
                        <td class="w-33 fontb" style="font-size: 18px;">INVOICE NO-{{ $data['Order']['id'] }}</td>
                        <td class="w-33 fontb" style="text-align: center;vertical-align: middle;font-size: 16px;">TRN: &nbsp;<SPAN>100282361300007</SPAN>
                            </td>
                        <td class="w-33" style="text-align: center;vertical-align: middle;font-size: 15px;"> date
                            :&nbsp;
                            <i id=""
                                style="border-bottom: 1px dashed #b99052;">{{ date('d/M/Y', strtotime($data['branch']['created_at'])) }}</i>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
        <table>
            <tr style="line-height: 20px;">
                <td class="w-5 vbottom fontb">MR./MS.</td>
                <td class="w-40">&nbsp;{{ $data['Order']['customer_name'] }}</td>
                <td class="w-5 vbottom fontb">Cust.TRN.</td>
                <td class="w-30">&nbsp;</td>
            </tr>
        </table>
        <table style="margin-top: 10px;">
            <tr style="line-height: 20px;">
                <td class="w-5 vbottom fontb">Tel.</td>
                <td class="w-30">&nbsp;{{ $data['Order']['customer_phone_number'] }}</td>
                <td class="w-5 vbottom">E-mail :</td>
                <td class="w-30">&nbsp;{{ $data['Order']['customer_email'] }}</td>
            </tr>
        </table>
        <div style="height: 10px;"></div>
        <table class="border ">
            <tr>
                <td rowspan="2" style="width: 2%;" class="border-b border-l border-t alignc fontb">رقم <br>Sr No.
                </td>
                <td rowspan="2" style="width: 6%;" class="border-b border-l border-t alignc fontb">رقم التصميم
                    <br>Design No
                </td>
                <td rowspan="2" style="width: 20%;" class="border-b border-l border-t alignc fontb">Item بند </td>
                <td rowspan="2" style="width: 4%;" class="border-b border-l border-t border-r alignc fontb">غيار
                    الذهب Gold Ct</td>
                <td colspan="2" style="width: 4%;" class="border-b border-l border-t alignc fontb">Weight الوزن
                </td>
                <td rowspan="2" style="width: 4%;" class="border-b border-l border-t alignc fontb">غيار الماس
                    Diamond Ct</td>
                <td rowspan="2" style="width: 4%;" class="border-b border-l border-t alignc fontb">الضريبية <br>
                    Vat</td>
                <td rowspan="2" style="width: 4%;" class="border-b border-l border-t alignc fontb"> كمية<br>
                    Qty</td>
                <td rowspan="2" style="width: 10%;" class="border-b border-l border-t border-r alignc fontb"
                    colspan="2">المبلغ
                    الإجمالي درهم <br>Gross Amount AED</td>
            </tr>
            <tr class="border-b">
                <td class="border-b border-l border-t border-r alignc">غرام <br>Gram</td>
                <td class="border-b border-l border-t border-r alignc">م.جرام <br>M.Gram</td>
            </tr>

            @php
                $serialNumber = 1;
                $total_vat = 0; // Initialize the serial number
            @endphp
            @foreach ($data['items'] as $item)
                <tr class="border-b" style="text-align: right">
                    <td class="border-l height padd alignc">&nbsp;{{ $serialNumber++ }}</td>
                    <td class="border-l height padd alignl">&nbsp;{{ $item['item_design_no'] }}</td>
                    <td class="border-l height padd alignl">&nbsp;{{ $item['item_name'] }}</td>
                    <td class="border-l height padd ">&nbsp;{{ number_format($item['item_gold_ctc'], 2) }}</td>
                    <td class="border-l height border-t padd ">&nbsp;{{ explode('.',$item['item_weight'])[0] }}</td>
                    <td class="border-l border-t height padd ">&nbsp;{{ explode('.',$item['item_weight'])[1] }}</td>
                    <td class="border-l height padd">&nbsp;{{ number_format($item['item_diamond_ctc'], 2) }}</td>
                    <td class="border-l border-t height padd">&nbsp;{{ number_format($item['item_vat'], 2) }}</td>
                    <td class="border-l border-t height padd">&nbsp;{{ $item['item_qty'] }}</td>
                    <td class="border-l height padd">&nbsp;{{ number_format($item['item_vat_gross_amt'], 2) }}</td>
                    <td class="border-l border-r height padd">&nbsp;</td>
                </tr>
            @endforeach
            @for ($i = count($data['items']); $i < 15; $i++)
                <tr class="border-b" style="text-align: right">
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height border-t padd">&nbsp;</td>
                    <td class="border-l border-t height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l height padd">&nbsp;</td>
                    <td class="border-l border-r height padd">&nbsp;</td>
                </tr>
            @endfor
            <tr class="border-b">
                <td colspan="3" class="border-l fontb height padd"><span style="text-align: left;"><i>Less Old
                            Gold Value Exchange</i></span></td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l border-r height padd" style="text-align: right">&nbsp;</td>
            </tr>
            <tr class="border-b">
                <td class="border-l height1 padd vtop fontb" colspan="2">Lot No.</td>
                <td class="border-l vtop height padd fontb" rowspan="2">Factory Order No</td>
                <td class="border-l height padd fontb" colspan="5">Gross Amount </td>
                <td class="alignr height padd fontb">المبلغ الإجمالي</td>
                <td class="border-l height padd" style="text-align: right">
                    {{ number_format($data['Order']['taxable_amount'], 2) }}&nbsp;</td>
                <td class="border-l border-r height padd">&nbsp;</td>
            </tr>
            <tr class="border-b">
                <td class="border-l height2 padd vtop fontb" colspan="2">Reff. By:/</td>
                <td class="border-l height padd fontb " colspan="5">VAT </td>
                <td class=" height padd alignr fontb">الضريبية </td>
                <td class="border-l height padd" style="text-align: right">
                    &nbsp;{{ number_format($data['Order']['total_item_vat'], 2) }}
                </td>
                <td class="border-l border-r height padd" style="text-align: right">&nbsp;</td>
            </tr>
            <tr class="border-b">
                <td class="border-l height padd fontb" colspan="3">VISA/MASTER/AMEX</td>
                <td class="border-l height padd fontb" colspan="6">Net Total (inc.VAT)الصافي الإجمالي (الشريبي)
                </td>
                <td class="border-l height padd" style="text-align: right">
                    &nbsp;{{ number_format($data['Order']['total_amount'], 2) }}
                </td>
                <td class="border-l border-r height padd" style="text-align: right">&nbsp;</td>
            </tr>
            <tr class="border-b">
                <td class="border-l height padd fontb" colspan="3">BANK TRANSFER</td>
                <td class="border-l height padd fontb" colspan="5">Advance (is any)</td>
                <td class="alignr height padd fontb">الواصل</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l border-r height padd" style="text-align: right">&nbsp;</td>
            </tr>
            <tr class="border-b">
                <td class="border-l height padd fontb" colspan="3">CASH</td>
                <td class="border-l height padd fontb" colspan="5">Balance (is any)</td>
                <td class="alignr height padd fontb">الباقي</td>
                <td class="border-l height padd" style="text-align: right">&nbsp;</td>
                <td class="border-l border-r height padd" style="text-align: right">&nbsp;</td>
            </tr>
        </table>
        <table style="font-size: 12px;">
            <tr style="line-height: 20px;">
                <td class="alignl">I undersigned, agree to the terms & conditions overleaf</td>
                <td class="alignr"> For &nbsp;{{ $data['user']['first_name'] }}</td>
            </tr>
            <tr style="line-height: 20px;">
                <td class="alignc" colspan="2">Happy to Visit Again, Or Refer your Friend to Avail a Free Pick Up
                    or Drop to Our Other Branches.</td>
            </tr>
            <tr style="line-height: 20px;">
                <td class="alignr" id="w-60"> • Souk Madinat Jumeirah &nbsp;&nbsp;&nbsp; • Gold & Diamond Park
                </td>
                <td class="alignl w-20" style="text-align: right"> <img src="{{ $data['user']['sign_image'] }}"
                        style="width: 40px;" alt=""></td>
            </tr>





            <tr style="line-height: 23px;">
                <td class="alignl" colspan="2">Customer Sign.</td>
            </tr>
            <tr style="line-height: 23px;">
                <td class="alignl fontb" colspan="2"> THANKING YOU! VISIT AGAIN</td>
            </tr>
        </table>
    </div>

    <div class="page-break" style="border: 1px solid #000;float: left;padding: 18px;">
        <table>
            <thead style="text-align: right;">
                <tr>
                    <td class="fontb">البنود و الظروف </td>
                </tr>
            </thead>
            <tbody style="text-align: right;">
                <tr style="padding: 20px;padding-top: 0px;">
                <tr>
                    <td>ا يمكن استبدال سوى صناديق المجوهرات الذهبية عيار 18 قيراط مرة واحدة فقط خلال 7 أيام من وقت
                        الشراء بشرط أن تكون السلعة في حالة جيدة
                        ومع الفاتورة.</td>
                </tr>
                <tr>
                    <td>إن السلف المقدمة مقابل استيراد الماس المعتمد غير قابلة للاسترداد</td>
                </tr>
                <tr>
                    <td>لا يمكن استبدال الماس المعتمد أو الماس السائب بالمجوهرات الذهبية.</td>
                </tr>
                <tr>
                    <td>لا يوجد استرداد لضريبة القيمة المضافة للفواتير التي تم شراؤها في التاريخ الماضي، واسترداد المبلغ
                        متاح فقط للفواتير الحالية
                        فواتير مؤرخة. لا يمكن إنشاء ضريبة القيمة المضافة والمطالبة بها للفواتير القديمة أو القديمة.</td>
                </tr>
                <tr>
                    <td>نحن لسنا مسؤولين عن أي اتصالات أو اتفاقيات عبر الواتساب عبر الرسائل
                        مع الأشخاص غير المصرح لهم الذين يعملون أو لا يعملون مع شركتنا.</td>
                </tr>
                <tr>
                    <td>يمكن استبدال المجوهرات بعد خصم رسوم الدفع،
                        وزن الحجر وسعره بسعر الذهب الحالي</td>
                </tr>
                <tr>
                    <td>بمجرد بيع البضائع، نحن لسنا مسؤولين عن أي كسر أو تلف أو سوء وضع المجوهرات، بما في ذلك (الألماس
                        والأحجار الكريمة وشبه الكريمة)
                </tr>
                <tr>
                    <td>لا يوجد استرداد نقدي تحت أي ظرف من الظروف.</td>
                </tr>
                <tr>
                    <td>يتطلب الطلب الخاص دفع 50% مقدمًا والرصيد عند الانتهاء، والسلف غير قابلة للاسترداد في حالة إلغاء
                        الطلب.</td>
                </tr>
                <tr>
                    <td>المجوهرات المباعة بشهادة المتجر "ذات قيم وخصائص تقريبية، ولا تقع على عاتقنا مسؤولية التقارير
                        الأخرى/الطرف الثالث.</td>
                </tr>
                <tr>
                    <td>لتظلمات التسوق، يرجى إرسال بريد إلكتروني إلى info@diamondsdubal.se/evajewellers@outlook.com.
                    </td>
                </tr>
                <tr>
                    <td>مطلوب نسخة صالحة من العميل وإثبات للسائح لاستعادة ضريبة القيمة المضافة، والشركة ليست مسؤولة عن
                        استرداد ضريبة القيمة المضافة القديمة التي لم تتم المطالبة بها أو عدم تحصيلها من المطار تحت أي
                        ظرف من الظروف.</td>
                </tr>
                <tr>
                    <td>إذا تم شراء المجوهرات باستخدام بطاقة الائتمان، وإذا كان ذلك بسبب خطأ أو خطأ من الشركة، فلن يتم
                        استرداد المبلغ المسترد مقابل المجوهرات المشتراة ببطاقة الائتمان إلا في بطاقة الائتمان،
                        لن يتم استرداد العناصر التي تم شراؤ ها بالبطاقة نقدًا أبدًا تحت أي ظرف من الظروف.</td>
                </tr>
                <tr>
                    <td>بالنسبة لأي طلب/استيراد ألماس من خارج البلاد، يجب استلام المبلغ مقدمًا بالكامل قبل تقديم الطلب.
                    </td>
                </tr>

            </tbody>
        </table>
        <table>
            <thead>
                <td class="fontb">TERMS & CONDITIONS</td>
            </thead>
            <tbody>
                <td>
                    <ol style="padding: 20px;padding-top: 0px;">
                        <li> Only 18 carats gold jewellery Bens can only be exchanged once within 7 days from the time
                            of purchase and provided the item is in exact condition
                            and with invoice.</li>
                        <li>Advances against import of certified diamonds are non refundable</li>
                        <li>Certified diamonds or loose diamonds cannot be exchanged for gold jewellery.</li>
                        <li> No vat refund for invoices purchased in the past date, wat refund only available for
                            current
                            dated invoices. It is not possible to generate and claim vat for old or backdated invoices.
                        </li>
                        <li>We are not responsible for any WhatsApp communications or agreement via messages
                            with unauthorised persons working or not working with our company.</li>
                        <li>Jewellery can be Exchanged after deduction of making charge,
                            stone weight & price valued at current gold price</li>
                        <li>Goods once sold, we are not liable for any breakage, damage or misplace of the jewellery,
                            including (Diamonds, precious or semi - precious stones)</li>
                        <li>No Cash refund under any circumstances.</li>
                        <li>Special order require 50% advance payable & balance upon completion, & advances are
                            non-refundable if e H order cancelied.</li>
                        <li>Jewellery sold with shop certificate " are with approximate values & characteristics,
                            other/Srd party reports are not our responsibility.</li>
                        <li> For shopping grievances kindly email to info@diamondsdubal.se/evajewellers@outlook.com.
                        </li>
                        <li>Valid customer photocopy and proof of tourist required for vat retund, company not
                            responsible for old unclaimed or non collection of vat refund from airport at any
                            circumstances.</li>
                        <li>If jewelery purchased with credit card, and if due to company mistake or fault, the refund
                            for jewelery purchased with credit card will only be refunded in credit card,
                            Items purchased with card will never be refunded with cash in any circumstances.</li>
                        <li>For any diamond order/import from out of country, full advance amount need to receive before
                            order is placed.</li>
                    </ol>
                </td>
            </tbody>
        </table>
    </div>
</body>

</html>
