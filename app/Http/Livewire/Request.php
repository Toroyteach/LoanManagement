<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\LoanApplication;
use App\LoanGuarantor;
use App\CreateLoanRequest;
use App\CreateLoanRequestFile;
use App\CreateGuarantorLoanRequest;
use App\LoanFile;
use Illuminate\Support\Str;
use App\Services\FirebaseService;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use App\MonthlySavings;
use App\User;
use Illuminate\Support\Facades\Storage;


class Request extends Component
{
    use WithFileUploads;


    public $currentStep = 1;
    public $amount, $description, $loan_type, $file, $fileTest, $duration = '';
    public $successMsg = '';
    public $gurantorInputs = [];
    public $i = 0;
    public $submitLoan = false;

    //loan information popup
    public $elligibleamount, $interest, $interestamount ,$totalplusinterest, $repaymentdate;

    public $loan_request_id;

    //dynamic gurantors form
    public $gurantorCount = 1;
    public $gurantorsChoice = array();
    public $users = [''];
    public $step1 = false;
    public $step2 = false;
    public $step3 = false;
    public $step2save = true;
    public $finalGurantorsChoice = array();
    public $addGurantorsButton = true;
    public $delReqBtn = false;


    //type ahead
    public $query= '';
    public $accounts = [];
    public $selectedAccount = 0;
    public $highlightIndex = 0;
    public $showDropdown;
    public $typeAheadInput = true;

    //emi
    public $equatedMonthlyInstallments = 0;

    public function reset(...$properties)
    {
        $this->accounts = [];
        $this->highlightIndex = 0;
        $this->query = '';
        $this->selectedAccount = 0;
        $this->showDropdown = true;
    }

    public function hideDropdown()
    {
        $this->showDropdown = false;
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->accounts) - 1) {
            $this->highlightIndex = 0;
            return;
        }

        $this->highlightIndex++;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->accounts) - 1;
            return;
        }

        $this->highlightIndex--;
    }

    public function selectAccount($id = null)
    {
        $id = $id ?: $this->highlightIndex;

        $account = $this->accounts[$id] ?? null;

        if ($account) {
            $this->showDropdown = true;
            $this->query = $account['name'];
            $this->selectedAccount = $account['id'];

            if(sizeof($this->gurantorsChoice) < 5){

                $this->gurantorsChoice[] = ['status' => '', 'id' => $account['id'], 'name' => $account['name']];
    
            } else {
    
                //session()->flash('error','You can only have 5 gurantors');
                $this->dispactchSwalEvent('error', 'Oops!', 'You can only have 5 gurantors maximum');
    
            }
        }

        //dd($this->gurantorsChoice);

    }

    public function updatedQuery()
    {

        //dd('show this to the user instead');
        
        if(strlen($this->query) >= 3){
            
            unset($noUsers);

            $noUsers = array();

            foreach($this->gurantorsChoice as $key => $user){
    
                array_push( $noUsers, $user['id']);
    
            }
    

            $this->accounts = User::select(['name', 'id'])->where('name', 'like', '%' . $this->query. '%')
                ->where('id', '!=', auth()->user()->id)
                ->WhereNotIn('id', $noUsers)
                ->take(5)
                ->get()
                ->toArray();
        }
        
    }
  
    /**
     * Write code on Method
     */
    public function render()
    {
        return view('livewire.request');
    }

    public function mount()
    {
        $this->elligibleamount = $this->getUserElligibleAmount();
        //dd($this->elligibleamount);
        $this->checkRequestStatus();

        if(!$this->checkRequestStatus()){
            session()->flash('message','You have Pending loan Application Request');
        }

        $this->getGurantors();
        $this->reset();

    }

    public function add($i)
    {

        $i = $i + 1;
        $this->i = $i;
        array_push($this->gurantorInputs , $i);

    }

        /**

     * Write code on Method

     *

     * @return response()

     */

    private function resetInputFields()
    {

        $this->amount = '';

        $this->description = '';

        $this->loan_type = '';

        $this->file = '';

        $this->duration = '';

        
        if(count($this->gurantorsChoice) > 0){

            $this->gurantorsChoice = [];

        }

        $this->step1 = false;

        $this->delReqBtn = false;
    }

    
    /**

     * Write code on Method

     *

     * @return response()

     */

    public function remove($i)
    {
        unset($this->gurantorInputs[$i]);
    }
  
    /**
     * Write code on Method
     */
    public function firstStepSubmit()
    {

        $validatedData = $this->validate([
            'amount' => 'required|numeric|min:1000|max:'.$this->elligibleamount,
            'description' => 'required',
            'loan_type' => 'required',
            'duration' => 'required|numeric',
        ]);

            //check if user had already created an application
        if($this->checkRequestStatus()){

            $user = CreateLoanRequest::create([
                'loan_amount' => $this->amount,
                'description' => $this->description,
                'loan_type' => $this->loan_type,
                'duration' => $this->duration,
                'user_id' => auth()->user()->id,
                'emi' => $this->equatedMonthlyInstallments,
                'total_plus_interest' => $this->totalplusinterest
            ]);

            //activate buttons and fill in form with new details

            $this->amount = $user->loan_amount;
            $this->description = $user->description;
            $this->loan_type = $user->loan_type;
            $this->duration = $user->duration;
            $this->loan_request_id = $user->id;
            $this->step1 = true;
            $this->delReqBtn = true;

            session()->flash('success','Loan Application Request was created successfully!');
            
        } else {

            //update possible new values
            if ($this->loan_request_id) {

                $request = CreateLoanRequest::find($this->loan_request_id);

                $request->loan_amount = $validatedData['amount'];
                $request->description = $validatedData['description'];
                $request->duration    = $validatedData['duration'];
                $request->loan_type   = $validatedData['loan_type'];
                $request->emi = $this->equatedMonthlyInstallments;
                $request->total_plus_interest = $this->totalplusinterest;


                if($request->isDirty('description') || $request->isDirty('loan_type') || $request->isDirty('loan_amount') || $request->isDirty('emi')){

                    $request->save();

                    $this->checkRequestStatus();

                    session()->flash('success','Loan Application Request was updated successfully!');

                    
                }
                

            }

        }
 
    }

    public function checkRequestStatus()
    {
            
            unset($request);

            $request = CreateLoanRequest::where('user_id', auth()->user()->id)->first();

            if($request){

                    $this->amount = $request->loan_amount;
                    $this->description = $request->description;
                    $this->loan_type = $request->loan_type;
                    $this->duration = $request->duration;
                    $this->loan_request_id = $request->id;
                    $this->step1 = true;

                    if($request->files->count() > 1){

                        $this->file = $request->files->count();

                    } else {

                        $this->file = false;
                    }

                    // $this->getGurantors();
                    $this->delReqBtn = true;

                    //show lona details
                    $this->showLoanDetails($request->loan_type);

                    //session()->flash('message','You have Pending loan Application Request');

                    return false;

            } 

            return true;
            
    }

    public function getGurantors()
    {
        //fill from datbase of the  previous gurantors

        $gurantorsList = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->whereIn('request_status', (['Pending','Accepted']))->with('user')->get();

        $this->gurantorsChoice = [];
    

        foreach($gurantorsList as $key => $user){


            array_push($this->gurantorsChoice, ["id" => $user->user_id ,"name" => $user->user->name, 'status' => 'added']); 


        }

        //check if more than 3 then enable next button
        //dd($gurantorsList);

        if($gurantorsList->count() == 3){

            $this->step2 = true;

            $this->finalGurantorsChoice = $gurantorsList;

            //dd($gurantorsList->count());

        } else if($gurantorsList->count() == 4){

            //dd($gurantorsList->count());
            $this->step2 = true;

            $this->finalGurantorsChoice = $gurantorsList;

        } else if($gurantorsList->count() == 5){

            //dd($gurantorsList->count());
            $this->step2 = true;

            $this->finalGurantorsChoice = $gurantorsList;

            $this->addGurantorsButton = false;

            $this->step2save = false;

            $this->typeAheadInput = false;

        }


        $acceptedGurantors = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->where('request_status', 'Accepted')->count();

        if($acceptedGurantors >= 3){

            $this->step3 = true;

        }


    }

    public function nextRequestStep()
    {
        //check if user has saved or check if user record exists before enabling the button
        $this->currentStep++;

    }

    public function previousRequestStep()
    {
        //check if user has saved or check if user record exists before enabling the button
        $this->currentStep--;

    }

    //not needed
    public function addGurantor()
    {

        if(sizeof($this->gurantorsChoice) < 5){

            $this->gurantorsChoice[] = ['status' => ''];

        } else {

            session()->flash('error','You can only have 5 gurantors');

        }
        
    }

    public function removeGurantor($key)
    {
        unset($this->gurantorsChoice[$key]);
        $this->gurantorsChoice = array_values($this->gurantorsChoice);
    }
  
    /**
     * Write code on Method
     */
    public function secondStepSave()
    {
        //check if request is for file or gurantors and also check if furantors was added initially
        
        $validatedData = $this->validate([
            'gurantorsChoice' => 'required|array|min:3|max:5',
        ]);

            $this->dispatchBrowserEvent('swal:confirmStep2', [

                'type' => 'warning',  

                'message' => 'Are you sure about your selection. This action is irreversible', 

                'title' => 'Gurantors Selection'

            ]);


    }

    public function secondStepConfirmSave()
    {
    
            $requestId = CreateLoanRequest::find($this->loan_request_id);
            

            $gurantorsList = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->get();
            $savedGurantors = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->get()->pluck('user_id');

            //dd($savedGurantors->toArray());
            $fileUploaded = false;
            $gurantorAdded = false;

            //upload file as well


            if($gurantorsList->count() > 5 ){
                //disable save button
                $this->step2save = false;
                

            } else {


                foreach($this->gurantorsChoice as $key => $user){

                    //check is status added id present then ignore

                    if($user['status'] == 'added'){

                        continue;

                    } else if(in_array($user['id'], $savedGurantors->toArray())){

                        $this->dispactchSwalEvent('error', 'Oops!', 'You can not add same gurantor twice');

                        //dd('found similar user');

                    } else {

                        //dd('no duplicate user found');

                        CreateGuarantorLoanRequest::create([
                            'request_id' => $requestId->id,
                            'user_id' => $user['id'],
                        ]);

                        $gurantorAdded = true;

                        session()->flash('success','Loan Application Gurantors Added Successfully!');

                    }

                }

                $this->getGurantors();

            }

            //check if memeber has 3 or more gurantors then enable step 3
            if (!empty($this->fileTest)) {

                //dd($this->fileTest);
                //check if file is empty if not warn user can not upload twice

                $this->validate([
                    'fileTest.*' => 'required|mimes:png,jpg,jpeg,docx,txt,pdf|max:2048'
                ]);

                
                foreach ($this->fileTest as $file) {

                    $file->store('photos');

                    $filename = md5($file . microtime()).'.'.$file->extension();
    
                    $file->storeAs('loanfiles', $filename, 'files');

                    CreateLoanRequestFile::create([
                        'title' => $filename,
                        'loan_requestor_id' => $requestId->id
                    ]);
        
                }

                $fileUploaded = true;

                $this->fileTest = null;

                $this->file = true;

                session()->flash('success','Loan Application File Added Successfully!');


            }
            
            if(CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->count() >= 3){

                $this->step2 = true;

            }

            if($fileUploaded && $gurantorAdded){

                session()->flash('success','Loan Application File and Gurantor Added Successfully!');

            }
         

    }

    public function downloadUploadedFile()
    {

        return response()->download(storage_path('files/uploads/loanfiles/'.$this->file));

    }

    public function deleteUploadedFile()
    {

        
        $requestId = CreateLoanRequestFile::where('loan_requestor_id', $this->loan_request_id)->get();

        
        foreach($requestId as $file){
            
            $file->delete();
            
            Storage::delete(storage_path('files/uploads/loanfiles/'.$file->title));
        }


        $this->file = null;

        session()->flash('success','Loan Application Files were Deleted Successfully');


    }

    public function thirdStepSubmit()
    {
        if($submitLoan){
            //view previous set data
            //and finalize to call submit form
        }

    }
  
    /**
     * Write code on Method
     */
    public function submitForm()
    {
            //ensure validation

            $this->dispatchBrowserEvent('swal:confirmStepFinal', [

                'type' => 'warning',  

                'message' => 'Have you Confirmed your loan Details. This action is irreversible', 
    
                'title' => 'Loan Details confirmation'
    
            ]);

    }

    public function submitFinalForm()
    {
            // dd('ready to submit form');
            $this->step3 = false;

            $loanDetails = CreateLoanRequest::findOrFail($this->loan_request_id);

            $entryNumber = mt_rand(100000, 1000000);
            //$defaluted = Carbon::
            $nextMonthsPay = $this->getFirstMonthsPayInterest($loanDetails->loan_amount, config('loantypes.'.$loanDetails->loan_type.'.interest'));
            //dd('ready to submit form', $entryNumber, $this->amount, $this->description, $this->loan_type, $this->duration);
            $loanApplication = LoanApplication::create([
                'loan_entry_number' => $entryNumber,
                'loan_amount' => $loanDetails->loan_amount,
                'description' => $loanDetails->description,
                'loan_type' => $loanDetails->loan_type,
                'duration' => $loanDetails->duration,
                'defaulted_date' => Carbon::now()->addMonths($loanDetails->duration + 3),
                'repayment_date' => date('Y-m-d', strtotime($this->duration.' months')),
                'equated_monthly_instal' => $loanDetails->emi,
                'next_months_pay' => $loanDetails->emi + $nextMonthsPay,
                'next_months_pay_date' => Carbon::now()->addMonths(1),
                'balance_amount' => $this->totalplusinterest,
                'loan_amount_plus_interest' => $this->totalplusinterest
            ]);

            $gurantors = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->get();

            foreach($gurantors as $key => $guarantor){
                LoanGuarantor::create([
                    'user_id' => $guarantor->user_id,
                    'loan_application_id' => $loanApplication->id,
                    'value' => $guarantor->request_status,
                ]);
            }

            //get files from request files to the new loan files
            foreach($loanDetails->files as $file){
                LoanFile::create([
                    'title' => $file->title,
                    'loan_application_id' => $loanApplication->id
                ]);
            }


                //deleted record from loan request
            $requestDetails = CreateLoanRequest::where('user_id', auth()->user()->id)->first();
            $requestDetails->delete();
    
            session()->flash('success','Loan Application was created successfully!');
  
            $this->resetInputFields();
          
            $this->currentStep = 1;
    
    }
  
    /**
     * Write code on Method
     */
    public function back($step)
    {
        $this->currentStep = $step;    
    }
  
    /**
     * Write code on Method
     */
    public function clearForm()
    {
        $this->gurantorInputs = '';
    }

    public function updateDuration()
    {   
        //dd($this->loan_type);
        //get the changed loan type and calculate interest etc and update duration

        switch ($this->loan_type) {
            case "Emergency":
                $this->calculateInterest("Emergency"); // twelf months duration
              break;
            case "InstantLoan":
                $this->calculateInterest("InstantLoan"); // twelf months duration;
              break;
            case "SchoolFees":
                $this->calculateInterest("SchoolFees"); // twelf months duration
              break;
            case "Development":
                $this->calculateInterest("Development"); // twelf months duration
              break;
            default:
                $this->duration = " ";
          }

          //dd($this->loan_type);

    }

         //interest calculator
     //$elligibleamount, $interest, $totalplusinterest, $repaymentdate;
     public function calculateInterest($type)
     {

        $this->elligibleamount = $this->getUserElligibleAmount();
        $this->interest = config('loantypes.'.$type.'.interest');
        $this->duration = config('loantypes.'.$type.'.max_duration');
        $this->totalplusinterest = $this->totalWithInterest($type);
        $this->repaymentdate = Carbon::now()->addMonths(config('loantypes'.$type.'max_duration'));//today plus config months

        //dd($this->elligibleamount, $this->interest, $this->totalplusinterest,  $this->repaymentdate);
     }

     public function showLoanDetails($type)
     {
        $this->totalplusinterest = $this->totalWithInterest($type);
        $this->repaymentdate = Carbon::now()->addMonths(config('loantypes'.$type.'max_duration'));
     }

     public function getUserElligibleAmount()
     {
         $monthlyContribution = MonthlySavings::select(['total_contributed', 'overpayment_amount'])->where('user_id', auth()->user()->id)->first();
         //dd($monthlyContribution);
         $a = $monthlyContribution->overpayment_amount;
         $b = $monthlyContribution->total_contributed;
         $totalMonthlyContribution = ($a + $b) * 3;
         //dd($totalMonthlyContribution);
         $outStandingLoan = LoanApplication::where('repaid_status', 0)->where('created_by_id', auth()->user()->id)->sum('balance_amount');
         $eligibleAmount = $totalMonthlyContribution - $outStandingLoan;
         
         return $eligibleAmount;

     }

     public function totalWithInterest($type)
     {

         
         $loan_types_config = config('loantypes.'.$type);
         //dd(config('loantypes.'.$type));
         $amountRequest = $this->amount;
         
         if($amountRequest <= 1000){
             
             return 0.00;
         }

        if($type == 'Emergency' || $type == 'SchoolFees' || $type == 'Development'){
            
            $total = $this->onReducingLoanBalance($loan_types_config['max_duration'], $loan_types_config['interest']);

        } else {

            $totalAdded = $amountRequest * 0.1 * 1;
            $this->interestamount = $totalAdded;
            $total = $totalAdded + $amountRequest;

        }

        return $total;

     }

     public function onReducingLoanBalance($time, $rate)
     {
        
        $principal = $this->amount;
        $totalInterestPaid = 0;
        $emi = $this->getMonthlyEmi($principal, $rate, $time);
        $this->equatedMonthlyInstallments = $emi;
        $interestCalculator =  number_format((float)($rate / 100), 2, '.', '');
        $principalValue = 0;

        for($x = 0; $x <= $time; $x++){

            if($x == 0){

                $principalValue = $this->amount;

                continue;

            } else {

                $nextMonthsPay = number_format((float)($emi + (($rate / 100) * $principalValue)), 2, '.', '');
                $totalInterestPaid +=  number_format((float)$nextMonthsPay, 2, '.', '');
                $principalValue = $principalValue - $emi;

            }


        }

        
        $rounded = number_format((float)$totalInterestPaid, 2, '.', '');

        $this->interestamount = $rounded - $principal;

        return $rounded;

     }

     public function alertSuccess()
     {
 
         $this->dispatchBrowserEvent('swal:modal', [
 
                 'type' => 'success',  
 
                 'message' => 'User Created Successfully!', 
 
                 'text' => 'It will list on users table soon.'
 
             ]);
 
     }
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function alertConfirm($type, $title, $text, $eventType)
     {
 
         $this->dispatchBrowserEvent($eventType, [
 
                'type' => $type,  

                'title' => $title, 

                'message' => $text
 
             ]);
 
     }

     public function dispactchSwalEvent($type, $title, $text)
     {
        $this->dispatchBrowserEvent('swal:modal', [
 
            'type' => $type,  

            'title' => $title, 

            'message' => $text

        ]);
     }

     public function cofirmDeleteRequest()
     {

        $this->dispatchBrowserEvent('swal:confirmDelete', [

            'type' => 'warning',  

            'message' => 'Are you sure you want to delete your application request. You will loose your accepted gurantors', 

            'title' => 'Delete Loan Application'

        ]);

     }

     public function deleteRequest()
     {
         //sweet request confirmation then delete
        $requestDetails = CreateLoanRequest::where('user_id', auth()->user()->id)->first();
        $requestDetails->delete();
        session()->flash('success','Loan Application was deleted successfully!');
        $this->resetInputFields();
     }

     public function getMonthlyEmi($principal, $Rate, $time)
     {
        return number_format((float)($principal / $time), 2, '.', '');
     }

     public function getFirstMonthsPayInterest($principal, $rate)
     {
        return $principal * ($rate / 100);
     }

}
