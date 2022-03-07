<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
span.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_002{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_004{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_004{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_005{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
div.cls_005{font-family:Arial,serif;font-size:9.0px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
span.cls_003{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_003{font-family:Arial,serif;font-size:8.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
span.cls_006{font-family:Arial,serif;font-size:10.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
div.cls_006{font-family:Arial,serif;font-size:10.0px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}

</style>
</head>
<body>
<div style="position:absolute; left:50%; margin-left:-297px; top:0px; width:595px; height:100%; border-style:outset; overflow:hidden;page-break-after: initial;">

    <div style="position:absolute;left:65px;top:5px;">
        <img src="{{ storage_path('app/logo/mtangazaji.png') }}" width="40" height="40">
    </div>

    <div style="position:absolute;left:127.66px;top:14.08px" class="cls_002"><span class="cls_002">{{ $pdfDetails['saccoName'] }}</span></div>
    <div style="position:absolute;left:359.50px;top:13.57px" class="cls_002"><span class="cls_002">Printed on :{{ $pdfDetails['printedOn'] }} </span></div>
    <div style="position:absolute;left:127.66px;top:25.60px" class="cls_002"><span class="cls_002">{{ $pdfDetails['saccoAddress'] }}</span></div>
    <div style="position:absolute;left:361.51px;top:29.34px" class="cls_002"><span class="cls_002">Page No :1</span></div>
    <div style="position:absolute;left:127.66px;top:38.13px" class="cls_002"><span class="cls_002">Loan Statement</span></div>
    <div style="position:absolute;left:127.66px;top:57.28px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberNo'] }}</span></div>
    <div style="position:absolute;left:59.83px;top:57.28px" class="cls_002"><span class="cls_002">MemberNo. :</span></div>
    <div style="position:absolute;left:361.44px;top:62.40px" class="cls_004"></div>
    <div style="position:absolute;left:59.83px;top:75.78px" class="cls_002"><span class="cls_002">Name :</span></div>
    <div style="position:absolute;left:127.66px;top:76.79px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberName'] }}</span></div>
    <div style="position:absolute;left:59.83px;top:96.80px" class="cls_002"><span class="cls_002">Phone No. :</span></div>
    <div style="position:absolute;left:127.66px;top:96.80px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberPhone'] }}</span></div>
    <div style="position:absolute;left:361.44px;top:102.43px" class="cls_005"></div>
    <div style="position:absolute;left:59.83px;top:121.29px" class="cls_002"><span class="cls_002">ID No. :</span></div>
    <div style="position:absolute;left:127.66px;top:121.29px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberIdno'] }}</span></div>

    <div style="position:relative; top:20px;" class="">
        @foreach($userLogs as $loanItem)

            <div style="position:relative;left:56px;top:143px" class="cls_002"><span class="cls_002">Loan Number</span></div>
            <div style="position:relative;left:149px;top:134px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_number'] }}</span></div>

            <div style="position:relative;left:280px;top:124px" class="cls_002"><span class="cls_002">Loan Start Date</span></div>
            <div style="position:relative;left:371px;top:115px" class="cls_002"><span class="cls_002">Loan Period</span></div>
            <div style="position:relative;left:485px;top:106px" class="cls_002"><span class="cls_002">Loan End Date</span></div>
            <div style="position:relative;left:56px;top:130px" class="cls_002"><span class="cls_002">Reqested Amount</span></div>

            <div style="position:relative;left:149px;top:121px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_amount'] }}</span></div>
            <div style="position:relative;left:285px;top:112px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_start_date'] }}</span></div>
            <div style="position:relative;left:376px;top:104px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_duration'] }} Months</span></div>
            <div style="position:relative;left:493px;top:95px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_end_date'] }}</span></div>
            
            <div style="position:relative;left:56px;top:114px" class="cls_002"><span class="cls_002">Loan Amount Plus Interest</span></div>
            <div style="position:relative;left:155px;top:106px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_amount_plus_interest'] }}</span></div>
            
            <div style="position:relative;left:56px;top:124px" class="cls_002"><span class="cls_002">Loan Type</span></div>
            <div style="position:relative;left:149px;top:116px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_type'] }}</span></div>


            <div style="position:relative;left:56px;top:140px" class="cls_002"><span class="cls_002">Posting Date</span></div>
            <div style="position:relative;left:170px;top:130px" class="cls_002"><span class="cls_002">Description</span></div>
            <div style="position:relative;left:250px;top:130px" class="cls_002"><span class="cls_002">Expected M-P</span></div>
            <div style="position:relative;left:339px;top:120px" class="cls_002"><span class="cls_002">Debit Amount</span></div>
            <div style="position:relative;left:417px;top:110px" class="cls_002"><span class="cls_002">Credit Amount</span></div>
            <div style="position:relative;left:520px;top:100px" class="cls_002"><span class="cls_002">Balance</span></div>

            <div style="position:relative;left:56px;top:120px" class="cls_002"><span class="cls_002">Balance B/F</span></div>

            @foreach($loanItem['changes'] as $accountItem)
                <div style="position:relative;left:56px;top:140px" class="cls_003"><span class="cls_003">{{ $accountItem['postingDate'] }}</span></div>
                <div style="position:relative;left:170px;top:130px" class="cls_003"><span class="cls_003">{{ $accountItem['description'] }}</span></div>
                <div style="position:relative;left:250px;top:120px" class="cls_003"><span class="cls_003">{{ $accountItem['expectedMonthly'] }}</span></div>
                <div style="position:relative;left:349px;top:120px" class="cls_003"><span class="cls_003">{{ $accountItem['debitAmount'] }}</span></div>
                <div style="position:relative;left:436px;top:110px" class="cls_003"><span class="cls_003">{{ $accountItem['creditAmount'] }}</span></div>
                <div style="position:relative;left:518px;top:100px" class="cls_003"><span class="cls_003">{{ $accountItem['balance'] }}</span></div>
            @endforeach


            <div style="position:relative;left:56px;top:129px" class="cls_002"><span class="cls_002">Loan Balance</span></div>
            <div style="position:relative;left:347px;top:119px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_debit_total'] }}</span></div>
            <div style="position:relative;left:428px;top:109px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_credit_total'] }}</span></div>
            <div style="position:relative;left:518px;top:99px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_balance'] }}</span></div>

            <!-- <div><hr style="position:relative;border-top: 1px dashed red;"></div> -->
        @endforeach
    </div>

    <!-- <div style="position:absolute;left:13px;top:1000px" class="cls_002"><span class="cls_002">Printed By:</span></div>
    <div style="position:absolute;left:64px;top:1000px" class="cls_003"><span class="cls_003">{{ $pdfDetails['saccoName'] }}</span></div>
    <div style="position:absolute;left:225px;top:1000px" class="cls_002"><span class="cls_002">Date:</span></div>
    <div style="position:absolute;left:283px;top:1000px" class="cls_003"><span class="cls_003">{{ $pdfDetails['printedOn'] }}</span></div>
    <div style="position:absolute;left:478px;top:1000px" class="cls_002"><span class="cls_002">Page No.</span></div>
    <div style="position:absolute;left:526px;top:1000px" class="cls_003"><span class="cls_003">1</span></div> -->

</div>

</body>
</html>
