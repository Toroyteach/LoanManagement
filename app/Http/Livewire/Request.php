<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\LoanApplication;
use App\LoanGuarantor;
use App\CreateLoanRequest;
use App\CreateGuarantorLoanRequest;
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
        $this->accounts = User::select(['name', 'id'])->where('name', 'like', '%' . $this->query. '%')
            ->where('id', '!=', auth()->user()->id)
            ->take(5)
            ->get()
            ->toArray();
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
        $this->elligibleamount =  $this->getUserElligibleAmount();
        $this->checkRequestStatus();
        $this->getGurantors();
        $this->reset();

    }

    public function add($i)
    {

        $i = $i + 1;
        $this->i = $i;
        array_push($this->gurantorInputs ,$i);

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
                'user_id' => auth()->user()->id
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

                
                $request->update([
                    'loan_amount' => $validatedData['amount'],
                    'description' => $validatedData['description'],
                    'loan_type' => $validatedData['loan_type'],
                    'duration' => $validatedData['duration'],
                ]);


                if($request->isDirty('description') or $request->isDirty('loan_type') or $request->isDirty('loan_amount')){

                    $request->save();

                    $this->checkRequestStatus();

                    session()->flash('success','Loan Application Request was updated successfully!');

                }


            }

        }
 
        //show sweet alert flash success
    }

    public function checkRequestStatus()
    {
            $request = CreateLoanRequest::where('user_id', auth()->user()->id)->first();

            if($request){

                    $this->amount = $request->loan_amount;
                    $this->description = $request->description;
                    $this->loan_type = $request->loan_type;
                    $this->duration = $request->duration;
                    $this->loan_request_id = $request->id;
                    $this->step1 = true;
                    $this->file = $request->file;

                    //dd($request->file);

                    // $this->getGurantors();
                    $this->delReqBtn = true;

                    session()->flash('message','You have Pending loan Application Request');

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

                //session()->flash('success','Loan Application Gurantors Added Successfully!');

            }

            //check if memeber has 3 or more gurantors then enable step 3
            if (!empty($this->fileTest)) {

                //dd($this->fileTest);
                //check if file is empty if not warn user can not upload twice

                $this->validate([
                    'fileTest' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf|max:2048'
                ]);
    
                $filename = md5($this->fileTest . microtime()).'.'.$this->fileTest->extension();
    
                $this->fileTest->storeAs('loanfiles', $filename, 'files');

                $requestId->update([
                    'file' => $filename
                ]);
                
                $fileUploaded = true;

                $this->fileTest = null;

                session()->flash('success','Loan Application File Added Successfully!');

    
            }
            
            if(CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->count() >= 3){

                $this->step2 = true;

            }

            if($fileUploaded && $gurantorAdded){

                session()->flash('success','Loan Application File and Gurantor Added Successfully!');

            }

            //return redirect(request()->header('Referer'));
            

    }

    public function downloadUploadedFile()
    {

        return response()->download(storage_path('files/uploads/loanfiles/'.$this->file));

    }

    public function deleteUploadedFile()
    {

        
        $requestId = CreateLoanRequest::find($this->loan_request_id);

        $requestId->file = null;

        $requestId->save();

        Storage::delete(storage_path('files/uploads/loanfiles/'.$this->file));

        $this->file = null;

        session()->flash('success','Loan Application File Deleted Successfully');


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

    public function submitFinalForm(FirebaseService $service)
    {
            // dd('ready to submit form');
            $this->step3 = false;
            //dd($this->file);

            $loanDetails = CreateLoanRequest::select(['loan_amount', 'description', 'loan_type', 'duration', 'file'])->findOrFail($this->loan_request_id);

            $entryNumber = mt_rand(100000, 1000000);
            //dd('ready to submit form', $entryNumber, $this->amount, $this->description, $this->loan_type, $this->duration);
            $loanApplication = LoanApplication::create([
                'loan_entry_number' => $entryNumber,
                'loan_amount' => $loanDetails->loan_amount,
                'description' => $loanDetails->description,
                'loan_type' => $loanDetails->loan_type,
                'duration' => $loanDetails->duration,
                'file' => $loanDetails->file
            ]);

            $gurantors = CreateGuarantorLoanRequest::where('request_id', $this->loan_request_id)->where('request_status', 'Accepted')->get();

            //dd('ready to submit form', $entryNumber, $this->amount, $this->description, $this->loan_type, $this->duration, $this->loan_request_id, $gurantors);


            foreach($gurantors as $key => $guarantor){
                LoanGuarantor::create([
                    'user_id' => $guarantor->id,
                    'loan_application_id' => $loanApplication->id,
                ]);
            }

    
            //create fiorebase calls to insert to firebase
            $random = Str::random(20);
            //dd($random);
    
            $loanDetails = [
                'loanentrynumber' => $entryNumber,
                'loandescription' => $loanApplication->description,
                'amount' => $loanApplication->loan_amount,
                'created_at' => $loanApplication->created_at,
                'id' => $loanApplication->created_by->firebaseid,
                'status' => $loanApplication->status_id,
                'docID' => $random,
            ];
    
            $loanApplication->firebaseid = $random;
            $loanApplication->repayment_date = date('Y-m-d', strtotime($this->duration.' months'));
            $loanApplication->save();
            
            $newLoan = $service->createLoan($loanDetails);
    
            //dd($newLoan);
    
    
            if(!$newLoan){
    
                return false;
    
            } else {

                //deleted record from loan request
                $requestDetails = CreateLoanRequest::where('user_id', auth()->user()->id)->first();
                $requestDetails->delete();
    
                session()->flash('success','Loan Application was created successfully!');
  
                $this->resetInputFields();
          
                $this->currentStep = 1;
    
            }
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
            case "emergency":
                $this->calculateInterest("emergency"); // twelf months duration
              break;
            case "instantloan":
                $this->calculateInterest("instantloan"); // twelf months duration;
              break;
            case "schoolfees":
                $this->calculateInterest("schoolfees"); // twelf months duration
              break;
            case "development":
                $this->calculateInterest("development"); // twelf months duration
              break;
            default:
                $this->duration = " ";
          }

    }

    public function loadApplicationDetails()
    {
        //get users loan request
        $previousRequest = CreateLoanRequest::where('user_id', auth()->user()->id)->get();

        if($previousRequest){
            // fill form

            $this->amount = $previousRequest->loan_amount;

            $this->description = $previousRequest->description;
    
            $this->loan_type = $previousRequest->loan_type;
    
            $this->file = $previousRequest->file;
    

        } else {
            //empty form fields
        }

    }

         //interest calculator
     //$elligibleamount, $interest, $totalplusinterest, $repaymentdate;
     public function calculateInterest($type)
     {

        $this->elligibleamount = 100000;
        $this->interest = config('loantypes.'.$type.'.interest');
        $this->duration = config('loantypes.'.$type.'.max_duration');
        $this->totalplusinterest = $this->totalWithInterest($type);
        $this->repaymentdate = Carbon::now()->addMonths(config('loantypes'.$type.'max_duration'));//today plus config months

        //dd($this->elligibleamount, $this->interest, $this->totalplusinterest,  $this->repaymentdate);
     }

     public function getUserElligibleAmount()
     {
         $monthlyContribution = MonthlySavings::select(['total_contributed'])->where('user_id', auth()->user()->id)->first();
         //dd($monthlyContribution->total_contributed);
         $totalMonthlyContribution = ($monthlyContribution->overpayment_amount + $monthlyContribution->total_contributed) * 3;
         $outStandingLoan = LoanApplication::where('repaid_status', 0)->where('created_by_id', auth()->user()->id)->sum('loan_amount');
         $eligibleAmount = $totalMonthlyContribution - $outStandingLoan;
         
         return $eligibleAmount;

     }

     public function totalWithInterest($type)
     {

        $loan_types_config = config('loantypes.'.$type);
        $amountRequest = $this->amount;

        if($type == 'emergency' || $type == 'schoolfees' || $type == 'development'){

            //$interestAccumulated = $this->onReducingLoanBalance($loan_types_config['max_duration']);
            
            $total = $this->onReducingLoanBalance($loan_types_config['max_duration']);
            //$this->interestamount = $total - $amountRequest;

        } else {

            $totalAdded = $amountRequest * 0.1 * $loan_types_config['max_duration'];
            $this->interestamount = $totalAdded;
            $total = $totalAdded + $amountRequest;

        }

        return $total;

     }

     public function onReducingLoanBalance($time)
     {
        
        
        $principal = $this->amount;
        $rate = 0.01;
        $accumulatedAmount = 0;

        $amounpaid = 800;//from db check the amount paid in last month

        for($x = 0; $x < $time; $x++){

            if($x == 0){

                $startingAmount = $principal;

                $accumulatedAmount =  ($startingAmount * $rate) + $principal;

                 //dd($accumulatedAmount);

            } else {

                $startingAmount = $accumulatedAmount;

                $secondAmount = (($startingAmount * $rate) + $startingAmount) - $amounpaid;

                unset($accumulatedAmount);

                $accumulatedAmount = $secondAmount;

                //dd($accumulatedAmount);
            }


        }

        return $accumulatedAmount;
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

}
