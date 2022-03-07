<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
    
span.cls_004{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_004{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_003{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}

</style>

</head>
<body>
<div style="position:absolute; left:50%; margin-left:-306px; top:0px; width:612px; height:100%; border-style:outset; overflow:hidden">

    <div style="position:absolute;left:400px;top:5px">
        <img src="{{ storage_path('app/logo/mtangazaji.png') }}" width="80" height="80">
    </div>

    <div style="position:absolute;left:185.83px;top:5.04px" class="cls_004"><span class="cls_004">{{ $pdfDetails['saccoName'] }}</span></div>
    <div style="position:absolute;left:125.35px;top:21.82px" class="cls_004"><span class="cls_004">{{ $pdfDetails['saccoAddress'] }} Harry Thuku Nairobi</span></div>
    <div style="position:absolute;left:212.83px;top:31.83px" class="cls_004"><span class="cls_004">Region: Nairobi</span></div>
    <div style="position:absolute;left:171.07px;top:45.79px" class="cls_004"><span class="cls_004">Tel: {{ $pdfDetails['memberPhone'] }} Office Tel:</span></div>
    <div style="position:absolute;left:123.98px;top:61.85px" class="cls_004"><span class="cls_004">E-mail: {{ $pdfDetails['saccoUrl'] }}- Website:</span></div>
    <div style="position:absolute;left:170.21px;top:71.86px" class="cls_004"><span class="cls_004"> </span><a href="">{{ $pdfDetails['saccoEmail'] }}</A> </div>
    <!-- <div style="position:absolute;left:17.78px;top:102.46px" class="cls_002"><span class="cls_002">Account No.</span></div>
    <div style="position:absolute;left:87.48px;top:102.46px" class="cls_003"><span class="cls_003">A0201526700</span></div> -->
    <div style="position:absolute;left:17.78px;top:115.92px" class="cls_002"><span class="cls_002">Member No.:</span></div>
    <div style="position:absolute;left:87.48px;top:115.92px" class="cls_003"><span class="cls_003">{{ $pdfDetails['memberPhone'] }}</span></div>
    <div style="position:absolute;left:17.78px;top:128.95px" class="cls_002"><span class="cls_002">Member Name:</span><span class=""> {{ $pdfDetails['memberName'] }}</span></div>
    <div style="position:absolute;left:17.78px;top:142.42px" class="cls_002"><span class="cls_002">ID Number:</span></div>
    <div style="position:absolute;left:87.48px;top:142.42px" class="cls_003"><span class="cls_003">{{ $pdfDetails['memberIdno'] }}</span></div>
    <div style="position:absolute;left:359.28px;top:142.42px" class="cls_002"><span class="cls_002">E-Mail:</span></div>
    <div style="position:absolute;left:389.52px;top:142.42px" class="cls_003"><span class="cls_003">{{ $pdfDetails['memberEmail'] }}</span></div>
    <div style="position:absolute;left:342.36px;top:156.67px" class="cls_002"><span class="cls_002">Mobile No.:</span></div>
    <div style="position:absolute;left:389.52px;top:156.67px" class="cls_003"><span class="cls_003">{{ $pdfDetails['memberPhone'] }}</span></div>


    <div style="position:absolute;left:17.78px;top:187.57px" class="cls_004"><span class="cls_004">Deposit Contribution</span></div>
    <div style="position:absolute;left:17.78px;top:202.54px" class="cls_004"><span class="cls_004">Posting Date</span></div>
    <div style="position:absolute;left:170.78px;top:202.54px" class="cls_004"><span class="cls_004">Description</span></div>
    <!-- <div style="position:absolute;left:326.81px;top:202.54px" class="cls_004"><span class="cls_004">Debit Amount</span></div> -->
    <div style="position:absolute;left:395.35px;top:202.54px" class="cls_004"><span class="cls_004">Credit Amount</span></div>
    <div style="position:absolute;left:495.00px;top:202.54px" class="cls_004"><span class="cls_004">Balance</span></div>


    @foreach($userLogs as $key => $loanItem)
        <div style="position:relative;left:17.78px;top:229.97px" class="cls_003"><span class="cls_003">{{ $loanItem['postingDate'] }}</span></div>
        <div style="position:relative;left:170.78px;top:221px" class="cls_003"><span class="cls_003">{{ $loanItem['description'] }}</span></div>
        <!-- <div style="position:relative;left:369.94px;top:221px" class="cls_003"><span class="cls_003">{{ $loanItem['debitAmount'] }}</span></div> -->
        <div style="position:relative;left:426.31px;top:214px" class="cls_003"><span class="cls_003">{{ $loanItem['creditAmount'] }}</span></div>
        <div style="position:relative;left:498.31px;top:204px" class="cls_003"><span class="cls_003">{{ $loanItem['balance'] }}</span></div>
    @endforeach

    <div style="position:absolute;left:13.68px;top:1000.74px" class="cls_002"><span class="cls_002">Printed By:</span></div>
    <div style="position:absolute;left:64.44px;top:1000.74px" class="cls_003"><span class="cls_003">{{ $pdfDetails['saccoName'] }}</span></div>
    <div style="position:absolute;left:225.58px;top:1000.74px" class="cls_002"><span class="cls_002">Date & Time:</span></div>
    <div style="position:absolute;left:283.82px;top:1000.74px" class="cls_003"><span class="cls_003">{{ $pdfDetails['printedOn'] }}</span></div>
    <div style="position:absolute;left:478.08px;top:1000.74px" class="cls_002"><span class="cls_002">Page No.</span></div>
    <div style="position:absolute;left:526.90px;top:1000.74px" class="cls_003"><span class="cls_003">1</span></div>

</div>

</body>
</html>
