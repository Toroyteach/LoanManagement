<!DOCTYPE html>
<html>
    <head>
        <title>Loan Statements</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style>
            @import "fonts.css";

            @page {
            size: 8.5in 11in;
            margin: 0.5in;
            margin-top: 1in;
            }

            body {
            font-size: 9pt;
            }

            .letter {
            font-family: "Lucida Grande";
            }

            h1 {
            font-size: 9pt;
            text-align: center;
            font-weight: bold;
            break-after: avoid;
            }

            h2 {
            font-size: 8pt;
            font-weight: bold;
            break-after: avoid;
            }

            p {
            text-align: justify;
            hyphens: auto;
            }

            .footer-link {
            color: #be945b;
            }

            div.letter {
            line-height: 1.6em;
            }

            .letter-logo {
            position: running(letter-logo);
            text-align: center;
            }

            .letter-logo img {
            width: 30mm;
            height: auto;
            }

            .letter-footer {
            position: running(letter-footer);
            font-size: 8pt;
            font-family: "Lucida Grande";
            text-align: center;
            }

            .letter-signature {
            width: 3cm;
            display: block;
            }

            .letter p {
            break-inside: avoid;
            }

            .letter-closing {
            break-inside: avoid;
            }

            @page addendum {
            @bottom-center {
                content: element(letter-footer);
            }

            @top-center {
                content: element(letter-logo);
            }
            }

            .addendum-images img {
                width: 100%;
            }
            @font-face {
                font-family: "Lucida Grande";
                src: url("../fonts/LucidaGrande.ttf") format("truetype");
            }
            @font-face {
                font-family: goudyoldstylet;
                src: url("../fonts/GOUDYOLDSTYLET-REGULAR.TTF") format("truetype");
            }
            
            @font-face {
                font-family: goudyoldstylet;
                font-weight: bold;
                src: url("../fonts/GOUDYOLDSTYLET-BOLD.TTF") format("truetype");
            }
            
            @font-face {
                font-family: goudyoldstylet;
                font-weight: bold;
                font-style: italic;
                src: url("../fonts/GOUDYOLDSTYLE-BOLDITALIC.TTF") format("truetype");
            }
            
            @font-face {
                font-family: gothamrounded;
                src: url("../fonts/GOTHAMROUNDED-MEDIUM.OTF") format("opentype");
            }
            
            @font-face {
                font-family: Arial;
                src: url("../fonts/ArialUnicode.ttf") format("opentype");
            }

        @import "fonts.css";

            body {
                font-size: 8pt;
                font-family: Arial;
            }

            .head1-left {
                position: absolute;
                top: 0;
                /* left indent for image */
                left: -30pt; 
            }

            .head1-left img {
                /* Width of top-left 50% table (investor information) */
                max-width: 245.40pt;
                height: auto;
            }

            /* text in box should vertically aligned bottom with a height of 51.63pt.
            * Using `top` here should have the same effect.
            */
            .head1-right {
                position: absolute;
                text-align: right;
                top: 14pt;
                right: 0;
                vertical-align: bottom;
            }

            .head-title {
                font-family: "Lucida Grande";
                font-size: 16pt;
                font-weight: bold;
                font-style: italic;
                margin-bottom: 0.5em;
            }

            .head-date {
                font-family: "Lucida Grande";
                font-size: 10pt;
            }

            .head2-left {
                position: absolute;
                top: 4cm;
                left: 0;
                width: 40%;
                font-family: Arial;
                font-size: 9pt;
            }

            .head2-right {
                position: absolute;
                text-align: right;
                top: 93.40pt;
                right: 0;
                font-family: "Lucida Grande"
            }
            /* vertical spacer on first page where the tables start.
            * Address, advisor etc. have an absolute positioning.
            */
            .spacer {
                height: 180pt;
            }

            /* Vertical spacer on CGLS page */
            .spacer2 {
                height: 30mm;
            }

            /* turn .footer into a running element */
            .footer {
                position: running(footer);
                font-size: 9pt;
                font-family: Arial;
                width: 100%;
            }

            .advisor {
                border-right: 1pt solid grey;
                text-transform: uppercase;
                margin-right: -5px;
                padding-right: 3px;
                font-size: 9pt;
                line-height: 1.4em;
            }

            .advisor-title {
                font-weight: bold;
                font-style: italic;
                font-size: 11pt;
                margin-bottom: 0.25em;
            }

            .sequence-number {
                font-family: Arial;
                color: grey;
                font-size: 6pt; 
                text-align: right;
            }

            table.accounting {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 25.81pt;
                font-family: Arial;
                font-size: 8pt;
                margin-bottom: 25.81pt;
                break-inside: avoid;
            }

            table.layout-fixed {
                table-layout: fixed;
            }

            table.accounting tr {
                padding: 0;
                margin: 0;
            }

            table.accounting th,
            table.accounting td {
                max-width: 20%;
            }

            table.accounting caption {
                text-align: left;
                border-top: 0.6pt solid #5972b2;
                margin-bottom: 1em;
            }

            table.accounting caption span {
                font-family: goudyoldstylet;
                background: #5972b2;
                font-weight: bold;
                font-size: 10pt;
                color: white;
                display: inline-block;
                padding-right: 0.25em;
                padding-left: 0.25em;
                padding-top: 0.25em;
                padding-bottom: 0.25em;
            }

            table.accounting .headers th {
                font-family: "Lucida Grande";
                font-weight: bold;
                font-style: italic;
            }

            table.accounting td {
                padding-top: 1px;
                padding-bottom: 2px;
            }

            table.accounting tfoot td {
                padding-top: 1em;
            }

            /* Investor/Account information 50|50 tables implemented
            * as left/right float within their #two-tables container
            */

            .two-tables .table-left {
                float: left;
                width: 245.40pt;
            }

            .two-tables .table-right {
                float: right;
                width: 245.40pt;
            }

            /* general table cell decoration with borders */

            .border-top td {
                border-top: 1px solid black;
            }

            .border-bottom td {
                border-bottom: 1px solid black;
            }

            /* text alignment within a cell */

            table.accounting .text-left {
                text-align: left
            }

            table.accounting .text-right {
                text-align: right;
            }

            table.accounting .text-center {
                text-align: center;
            }

            table.accounting .extra-top-padding {
                padding-top: 1em;
            }


            table.accounting .extra-bottom-padding {
                padding-bottom: 1em;
            }

            table.width-50 {
                width: 245.40pt;
            }

            /* defines font classes by pt size for general usage */

            .text-7 {
                font-size: 7pt;
            }

            .text-8 {
                font-size: 8pt;
            }

            .text-9 {
                font-size: 10pt;
            }


            .text-10 {
                font-size: 10pt;
            }

            /* text/font decorations */

            .bold {
                font-weight: bold;
            }

            .italic {
                font-style: italic;
            }

            /* needed for Weasyprint (#1062)*/
            table::before {
                content: target-counter(url(#end), page);
                display: none;
            }

            .chart {
                border-bottom: 1px solid black;
                margin-bottom: 2em;
            }

            .chart img {
                max-width: 100%
            }

            .footnote-marker {
                display: inline-block;
                width: 0.5em;
            }

            .cgls-head {
                margin-bottom: 4em;
            }

            @page statement {

                margin-bottom: 30mm;

                @bottom-left {
                    content: element(footer);
                    vertical-align: bottom;
                    display: table-cell;
                    border-bottom: 1pt solid grey;
                    font-family: Arial;
                    margin-bottom: 1cm;
                    height: 1.5cm;
                }
                @bottom-right {
                    font-family: Arial;
                    font-size: 8pt;
                    border-bottom: 1pt solid grey;
                    vertical-align: bottom;
                    width: 3cm;
                    height: 1.5cm;
                    display: table-cell;
                    content: "Page " counter(page) " of " counter(pages);
                    margin-bottom: 1cm;
                }
            }

            @page statement-cgls {

                margin-bottom: 30mm;

                @bottom-left {
                    content: element(footer);
                    vertical-align: bottom;
                    display: table-cell;
                    border-bottom: 1pt solid grey;
                    font-family: Arial;
                    margin-bottom: 1cm;
                    height: 1.5cm;
                }
            }

            @import "fonts.css";

            .statement,
            .addendum {
                page-break-after: auto;
            }

            .statement {
                page: statement;
            }

            .statement-cgls {
                page: statement-cgls;
            }


            .addendum {
                page: addendum;
            }

            /* general page size and margins */

            @page {
                size: 8.5in 11in;
                margin-bottom: 20.26pt;
                margin-top: 105.38pt;
            }

            /* First statement page has a custom margin-top */
            @page :first {
                margin-top: 20.26pt;
            }

            /* same for CGLS page */
            @page statement-cgls {
                margin-top: 20.26pt;
            }

            /* ATT: page 1 is usually a right page. But for the statements
            * page 1 should be left page that's why we swap :right and :left
            * in order to get left/right margins on left/right pages right
            */

            /* @page :right{
                margin-left: 73.22pt;
                margin-right: 36.14pt;
            }

            @page :left {
                margin-left: 36.14pt;
                margin-right: 73.22pt;
            } */
        </style>
    </head>

    <body lang="en">
         
        <article>
            <section class="statement">
                <div>

                    <div class="head1-left">
                        <!--
                            <img src="logo.png" />
                        -->
                        <img src="{{ storage_path('app/logo/mtangazaji.png') }}" width="100" height="auto" style="position: relative; left: 50px;"/>
                    </div>

                    <div class="head1-right">
                        <div class="head-title">{{ $pdfDetails['saccoName'] }} <br> <span style="font-size: 18px;">Loan Statements</span></div>
                        <div class="head-date">{{ $pdfDetails['printedOn'] }}</div>
                    </div>

                    <div class="head2-left">
                        <div class="advisor-outer">
                            <div class="">
                                <div>Name : {{ $pdfDetails['memberName'] }}</div>
                                <div>Member No : {{ $pdfDetails['memberNo'] }}</div>
                                <div>Member Email : {{ $pdfDetails['memberEmail'] }}</div>
                                <div>Mobile Number : {{ $pdfDetails['memberPhone'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="spacer">&nbsp;</div>

                    @foreach($userLogs as $loanItem)

                        <div class="two-tables">
                            <table class="accounting table-left">
                                <caption>
                                    <span>Loan Application Entry</span>
                                </caption>
                                <thead>
                                    <tr class="headers">
                                        <th class="text-left">Loan Type</th>
                                        <th class="text-left">Loan Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="headers border-bottom" >
                                        <td class="text-left text-10 bold">{{ $loanItem['loan_type'] }}</td>
                                        <td class="text-left text-10 bold">{{ $loanItem['loan_number'] }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    
                                        <tr class="border-bottom">
                                            <td colspan="4">
                                                <div class="text-left">Loan Duration</div>
                                                <div class="text-left text-10 bold">{{ $loanItem['loan_duration'] }} months</div>
                                            </td>
                                        </tr>
                                        <tr class="border-bottom">
                                            <td colspan="2">
                                                <div class="text-left">Loan Start Date</div>
                                                <div class="text-left text-10 bold">{{ $loanItem['loan_start_date'] }}</div>
                                            </td>
                                            <td colspan="2">
                                                <div class="text-left">Loan End Date</div>
                                                <div class="text-left text-10 bold">{{ $loanItem['loan_end_date'] }}</div>
                                            </td>
                                        </tr>
                                    
                                </tfoot>
                            </table>

                            <table class="accounting table-right">
                                <caption>
                                    <span>Amount Value</span>
                                </caption>
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="text-left text-10">
                                        Requested Amount
                                        </td>
                                        <td class="text-right bold text-10">
                                        ksh {{ $loanItem['loan_amount'] }}
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-left text-10">
                                        Requested Amount Plus Intrest
                                        </td>
                                        <td class="text-right bold text-10">
                                        ksh {{ $loanItem['loan_amount_plus_interest'] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div style="clear: both"></div>
                        </div>

                        <table class="accounting account-summary">
                            <caption>
                                <span>Account Summary</span>
                            </caption>
                            <thead>
                                <tr class="headers border-bottom">
                                    <th class="text-left">Posting Date</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-right">Expected Monthly <br> Pay (ksh) </th>
                                    <th class="text-right">Debit<br />Amount (ksh)</th>
                                    <th class="text-right">Credit<br />Amount (ksh)</th>
                                    <th class="text-right">Balance<br />Amount (ksh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td colspan="7" class="text-7 text-left">Balance B/F</td>
                                </tr>

                                @foreach($loanItem['changes'] as $accountItem)

                                
                                    <tr class="border-bottom">
                                        <td class="text-left">{{ $accountItem['postingDate'] }}</td>
                                        <td class="text-center">{{ $accountItem['description'] }}</td>
                                        <td class="text-right">{{ $accountItem['expectedMonthly'] }}</td>
                                        <td class="text-right">{{ $accountItem['debitAmount'] }}</td>
                                        <td class="text-right">{{ $accountItem['creditAmount'] }}</td>
                                        <td class="text-right">{{ $accountItem['balance'] }}</td>
                                    </tr>
                                    
                                    <tr class="border-bottom">
                                        <td class="text-left" colspan="2"></td>
                                        <td class="text-right" colspan="1"></td>
                                        <td class="text-right" colspan="4"></td>
                                    </tr>

                                @endforeach

                                    <tr class="border-bottom">
                                        <td class="text-left">Total</td>
                                        <td class="text-center"></td>
                                        <td class="text-right"></td>
                                        <td class="text-right">{{ $loanItem['loan_debit_total'] }}</td>
                                        <td class="text-right">{{ $loanItem['loan_credit_total'] }}</td>
                                        <td class="text-right">{{ $loanItem['loan_balance'] }}</td>
                                    </tr>

                                    <tr class="">
                                        <td class="text-left" colspan="6"></td>
                                    </tr>

                            </tbody>
                            <tfoot>
                                <tr>

                                </tr>
                            </tfoot>
                        </table>

                    @endforeach


                    <div>Please review your statement of account carefully.  If there is any information that does not match your records, contact your Financial Advisor or our Client Services department within 20 days.</div>

                </div>

                <div id="end"></div>
            </section>

        </article> 
        
    </body>
</html>