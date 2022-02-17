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
<div style="position:absolute; left:50%; margin-left:-297px; top:0px; width:595px; height:100%; border-style:outset; overflow:hidden;">

    <div style="position:absolute;left:65px;top:5px">
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
    <div style="position:absolute;left:361.44px;top:72.41px" class="cls_004"></div>
    <div style="position:absolute;left:363.94px;top:92.42px" class="cls_004"></div>
    <div style="position:absolute;left:59.83px;top:104.80px" class="cls_002"><span class="cls_002">Phone No. :</span></div>
    <div style="position:absolute;left:127.66px;top:104.80px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberPhone'] }}</span></div>
    <div style="position:absolute;left:361.44px;top:102.43px" class="cls_005"></div>
    <div style="position:absolute;left:59.83px;top:121.29px" class="cls_002"><span class="cls_002">ID No. :</span></div>
    <div style="position:absolute;left:127.66px;top:121.29px" class="cls_002"><span class="cls_002">{{ $pdfDetails['memberIdno'] }}</span></div>


    <div style="">
    @foreach($userLogs as $loanItem)

        <div style="position:absolute;left:56.74px;top:143.39px" class="cls_002"><span class="cls_002">Loan Number</span></div>
        <div style="position:absolute;left:149.40px;top:143.39px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_number'] }}</span></div>
        <div style="position:absolute;left:280.22px;top:143.39px" class="cls_002"><span class="cls_002">Loan Start Date</span></div>
        <div style="position:absolute;left:371.23px;top:143.39px" class="cls_002"><span class="cls_002">Loan Period</span></div>
        <div style="position:absolute;left:485.86px;top:143.39px" class="cls_002"><span class="cls_002">Loan End Date</span></div>
        <div style="position:absolute;left:56.74px;top:159.88px" class="cls_002"><span class="cls_002">Reqested Amount</span></div>

        <div style="position:absolute;left:149.40px;top:159.88px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_amount'] }}</span></div>
        <div style="position:absolute;left:289.73px;top:159.88px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_start_date'] }}</span></div>
        <div style="position:absolute;left:376.78px;top:159.88px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_duration'] }} Months</span></div>
        <div style="position:absolute;left:493.85px;top:159.88px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_end_date'] }}</span></div>

        <div style="position:absolute;left:56.74px;top:174.86px" class="cls_002"><span class="cls_002">Loan Type</span></div>
        <div style="position:absolute;left:149.40px;top:174.86px" class="cls_003"><span class="cls_003">{{ $loanItem['loan_type'] }}</span></div>


        <div style="position:absolute;left:56.74px;top:188.39px" class="cls_002"><span class="cls_002">Posting Date</span></div>
        <div style="position:absolute;left:170.54px;top:188.39px" class="cls_002"><span class="cls_002">Description</span></div>
        <!-- <div style="position:absolute;left:369.58px;top:188.39px" class="cls_002"><span class="cls_002">Debit Amount</span></div> -->
        <div style="position:absolute;left:447.26px;top:188.39px" class="cls_002"><span class="cls_002">Credit</span></div>
        <div style="position:absolute;left:520.48px;top:188.39px" class="cls_002"><span class="cls_002">Balance</span></div>
        <div style="position:absolute;left:440.14px;top:197.39px" class="cls_002"><span class="cls_002">Amount</span></div>

        <div style="position:absolute;left:56.74px;top:210.35px" class="cls_002"><span class="cls_002">Balance B/F</span></div>

        @foreach($loanItem['changes'] as $accountItem)
            <div style="position:relative;left:56.74px;top:229.97px" class="cls_003"><span class="cls_003">{{ $accountItem['postingDate'] }}</span></div>
            <div style="position:relative;left:170.78px;top:221px" class="cls_003"><span class="cls_003">{{ $accountItem['description'] }}</span></div>
            <!-- <div style="position:relative;left:379.94px;top:212px" class="cls_003"><span class="cls_003">{{ $accountItem['debitAmount'] }}</span></div> -->
            <div style="position:relative;left:446.31px;top:210px" class="cls_003"><span class="cls_003">{{ $accountItem['creditAmount'] }}</span></div>
            <div style="position:relative;left:528.31px;top:200px" class="cls_003"><span class="cls_003">{{ $accountItem['balance'] }}</span></div>
        @endforeach



        <div style="position:relative;left:56.74px;top:239.40px" class="cls_002"><span class="cls_002">Loan Balance</span></div>
        <!-- <div style="position:relative;left:386.14px;top:233.40px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_debit_total'] }}</span></div>
        <div style="position:relative;left:437.04px;top:223.40px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_credit_total'] }}</span></div> -->
        <div style="position:relative;left:535.61px;top:213.40px" class="cls_002"><span class="cls_002">{{ $loanItem['loan_balance'] }}</span></div>
    @endforeach

    <div style="position:absolute;left:13.68px;top:1000.74px" class="cls_002"><span class="cls_002">Printed By:</span></div>
    <div style="position:absolute;left:64.44px;top:1000.74px" class="cls_003"><span class="cls_003">{{ $pdfDetails['saccoName'] }}</span></div>
    <div style="position:absolute;left:225.58px;top:1000.74px" class="cls_002"><span class="cls_002">Date & Time:</span></div>
    <div style="position:absolute;left:283.82px;top:1000.74px" class="cls_003"><span class="cls_003">{{ $pdfDetails['printedOn'] }}</span></div>
    <div style="position:absolute;left:478.08px;top:1000.74px" class="cls_002"><span class="cls_002">Page No.</span></div>
    <div style="position:absolute;left:526.90px;top:1000.74px" class="cls_003"><span class="cls_003">1</span></div>
    </div>

</div>

</body>
</html>
