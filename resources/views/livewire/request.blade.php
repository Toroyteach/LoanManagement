<div>
                    @if(!empty($successMsg))
                    <div class="alert alert-success">
                        {{ $successMsg }}
                    </div>
                    @endif

                    @if(session('success'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'success',
                                  title: "{{ session('success') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif

                    @if(session('error'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'error',
                                  title: "{{ session('error') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif

                    @if(session('message'))
                        <script type="text/javascript">
                              Swal.fire({
                                  position: 'top-end',
                                  icon: 'info',
                                  title: "{{ session('message') }}",
                                  showConfirmButton: false,
                                  timer: 2000
                              })
                      </script>
                    @endif


                <div class="container" id="medianews">
                    <div class="no-gutters">
                        <div class="media media-news">
                            <div class="text-center media-body">
                                <span class="media-date">Eligible</span>
                                <p class="mt-0 sep" id="elligibleamount">ksh{{$elligibleamount}}.</p>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <span class="media-date">Interest</span>
                                        <p class="mt-0 sep" wire:model="interest" id="interest"> {{$interest ?? '0'}}%.</p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <span class="media-date">Repayment Date</span>
                                        <p class="mt-0 sep" id="repaymentdate">{{$repaymentdate ?? '-'}}.</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <span class="media-date">Total Interest</span>
                                        <p class="mt-0 sep" id="totalplusinterest">ksh{{$interestamount ?? '0'}}.</p>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <span class="media-date">Total plus Interest</span>
                                        <p class="mt-0 sep" id="totalplusinterest"> ksh{{$totalplusinterest ?? '0'}}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

    <div class="conatiner_fluid" style="padding-bottom:5em">
        <div class="row">

        <div wire:loading wire:target="secondStepConfirmSave">

            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>

        </div>

        <div wire:loading wire:target="submitFinalForm">

            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>

        </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 card-body applycard" style="position:relative; background-color: #d7ded7; @if($currentStep == 3) height: 50em; @elseif($currentStep == 2) height: 38em !important; @endif">
                
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="multi-wizard-step">
                                <a href="#step-1" type="button" class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">1</a>
                                <p>Loan Details</p>
                            </div>
                            <div class="multi-wizard-step">
                                <a href="#step-2" type="button" class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}">2</a>
                                <p>Choose Gurantors</p>
                            </div>
                            <div class="multi-wizard-step">
                                <a href="#step-3" type="button" class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}" disabled="disabled">3</a>
                                <p>Submit Application</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row setup-content {{ $currentStep != 1 ? 'display-none' : '' }}" id="step-1">
                        <div class="col-md-12">
                            <h3> Fill in Loan Details</h3>

                            <div wire:loading wire:target="firstStepSubmit">

                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>

                            </div>

                            <div wire:loading wire:target="submitForm">>

                                <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>

                            </div>

                            <div class="row ic1">
                                <div class=" col-md-6 col-sm-6 col-xs-12 input-container inputAmount" id="amount">
                                    <input type="number" wire:model="amount" wire:change="updateDuration" name="amount" class="input" placeholder=" " id="amount" required>
                                    <div class="cut"></div>
                                    <label for="amount" class="placeholder">Amount</label>
                                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class=" col-md-6 col-sm-6 col-xs-12 input-container inputDuration" id="duration">
                                    <input type="number" wire:model="duration" name="duration" class="input" id="duration" placeholder=" " disabled/>
                                    @error('duration') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="cut"></div>
                                    <label for="duration" class="placeholder">Duration</label>
                                </div>
                            </div>

                            <div class="row ic2">
                                <div class="col-md-6 col-sm-6 col-xs-12 inputType" id="type">

                                    <h4>Loan Type</h4>
                                    @if($loan_type)<p class="text-info text-uppercase">{{ $loan_type }}</p>@else<p>None Selected</p>@endif
                                    
                                    <select class="form-select" wire:model="loan_type" id='loan_type' name="loan_type" wire:change="updateDuration" aria-label="Default select example" required>
                                        <option>Choose Loan Type</option>
                                        <option value="Emergency">Emergency</option>
                                        <option value="InstantLoan">Instant Loan</option>
                                        <option value="SchoolFees">School Fees</option>
                                        <option value="Development">Development</option>
                                    </select>
                                    @error('loan_type') <span class="text-danger">{{ $message }}</span> @enderror
                                    
                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 input-container inputDescription" id="loanDesc">
                                    <textarea type="text" wire:model="description" class="input" id="description" placeholder=" " required></textarea>
                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                    <div class="cut"></div>
                                        <label for="detail" class="placeholder">Loan Description</label>
                                </div>
                            </div>

                            <div class="container_fluid step1Buttons">
                                <button class="btn btn-primary nextBtn btn-md" id="nextBtn" wire:click="firstStepSubmit" type="button" style="">Save</button>
                                <button class="btn btn-danger nextBtn btn-md"  id="nextBtn"wire:click="cofirmDeleteRequest" type="button" style=""{{ (($delReqBtn)) ? '' : 'disabled' }}>Delete Application</button>
                                <button class="btn btn-success btn-md pull-right nextBtn" id="nextBtn" wire:click="nextRequestStep" type="button" style="" {{ (($step1)) ? '' : 'disabled' }}>Next</button>
                            </div>
                        </div>
                        
                    </div>


                    <div class="row setup-content {{ $currentStep != 2 ? 'display-none' : '' }}" id="step-2">
                        <div class="col-md-12">
                            <h3> Choose your Gurantors</h3>

                            <div class="row">
                                <div class="col-md-6 form-group">

                                    <div class="">
                                            <input type="text"
                                                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                placeholder="Search Member..." wire:model="query" wire:click="reset" wire:keydown.escape="hideDropdown" wire:keydown.tab="hideDropdown" wire:keydown.Arrow-Up="decrementHighlight" wire:keydown.Arrow-Down="incrementHighlight"
                                                wire:keydown.enter.prevent="selectAccount"
                                                {{ (($typeAheadInput)) ? '' : 'disabled' }}/>

                                            <input type="hidden" name="account" id="account" wire:model="selectedAccount">

                                            @if ($selectedAccount)
                                                <a class="absolute cursor-pointer top-2 right-2 text-gray-500" wire:click="reset">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                            @endif

                                        @if(!empty($query) && $selectedAccount == 0 && $showDropdown)
                                            <div class="absolute bg-white border border-gray-300 rounded-md shadow-lg">
                                                @if (!empty($accounts))
                                                    @foreach($accounts as $i => $account)
                                                        <a wire:click="selectAccount({{ $i }})" class=" py-2 px-1 text-sm cursor-pointer hover:bg-blue-50 {{ $highlightIndex === $i ? 'bg-blue-50' : '' }}">{{ $account['name'] }}</a><br>
                                                    @endforeach
                                                @else
                                                    <span class=" py-1 text-sm">No results!</span>
                                                @endif
                                            </div>
                                        @endif


                                    </div>
                                    <br><br>

                                    @foreach($gurantorsChoice as $key => $value)

                                        <div class="dd-input">

                                            <div class="row">

                                                <div class="col-md-6">

                                                    <div class="row">
                                                        

                                                        <div class="col-md-10 col-lg-10 col-sm-10 col-xs-10">

                                                            <input type="text" class="form-control" placeholder="Enter Name" wire:model="gurantorsChoice.{{ $key }}.name" required disabled>

                                                        </div>


                                                        @error('gurantorChoice.'.$key) <span class="text-danger error">{{ $message }}</span>@enderror

                                                    </div>

                                                </div>

                                                <div class="col-md-2 col-lg-2 col-sm-2 col-xs-2">

                                                    @if($gurantorsChoice[$key]['status'] == 'added')
                                                        
                                                    @else
                                                        <button class="btn btn-danger btn-sm" wire:click.prevent="removeGurantor({{ $key }})">Remove</button>
                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                    @endforeach

                                    @error('gurantorsChoice') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-4">

                                    <div class="container">
                                        <div class="">
                                            <label for="detail">Upload request document</label><br>
                                            <label for="detail">Files allowed include png, jpg, jpeg, docx, txt, pdf ONLY!</label><br>
                                            <input type="file" wire:model="fileTest" class="form-input" id="fileTest" placeholder=" " multiple><br>
                                            @error('fileTest')<span class="text-danger">Files allowed include png, jpg, jpeg, docx, txt, pdf ONLY!</span> @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <button class="btn btn-primary nextBtn btn-md pull-right" type="button" wire:click="nextRequestStep"{{ (($step2)) ? '' : 'disabled' }}>Next</button>
                            <button class="btn btn-success nextBtn btn-md pull-right" type="button" wire:click="secondStepSave" {{ (($step2save)) ? '' : 'disabled' }}>Save</button>
                            <button class="btn btn-warning nextBtn btn-md pull-left" type="button" wire:click="previousRequestStep">Back</button>
                        </div>
                    </div>


                    <div class="row setup-content {{ $currentStep != 3 ? 'display-none' : '' }}" id="step-3">
                        <div class="col-md-12">
                            <h3> Confirm Your Details</h3>

                            <div class="row">
                            
                                <div class="col-md-4">
                                    <div class="card border-success mb-3" style="max-width: 18rem;">
                                        <div class="card-header bg-transparent border-success">Loan Details</div>
                                        <div class="card-body">
                                            <p class="card-text">Amount : ksh{{ $amount }}</p>
                                            <p class="card-text">Duration : {{ $duration }} months</p>
                                            <p class="card-text">Loan Type : {{ $loan_type }}</p>
                                            <p class="card-text">Description : {{ $description }}</p>
                                            <p class="card-text">File </p>
                                            @if($file)
                                            <button class="btn-sm btn-danger" style="position:relative; top:-1em !important;" type="button" wire:click="deleteUploadedFile">Delete {{$file}} files</button>
                                            @else
                                                no file uploaded
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="card border-success mb-3" style="max-width: 20rem;">
                                        <div class="card-header bg-transparent border-success">Gurantors List</div>
                                            <ul class="list-group list-group-flush">

                                                 @forelse($finalGurantorsChoice as $key => $value)
                                                 
                                                    <div class="container">
                                                        <div class="row d-flex justify-content-between">

                                                            <div class=" ml-3">
                                                                <p style="">{{ $key+1 }}</p>
                                                            </div>

                                                            <div class="">
                                                                <p style="">{{ $value->user->name }}</p>
                                                            </div>

                                                            @if($value->request_status == 'Accepted')

                                                            <div class="mr-3" style="position:relative; top: 5px;">
                                                                    <i class="fas fa-check"></i>
                                                            </div>
                                                            @else

                                                            <div class="mr-3" style="position:relative; top: 4px;">
                                                                <div class="spinner-border pull-right" role="status">
                                                                    <span class="sr-only" style="font: 10px;">Loading...</span>
                                                                </div>
                                                            </div>
                                                            
                                                            @endif
                                                            
                                                        </div>
                                                    </div>

                                                @empty

                                                @endforelse

                                            </ul>
                                    </div>
                                </div>

                            </div>

                            <!-- <button class="btn btn-success btn-md pull-right" wire:click="" type="button" {{ (($step3)) ? '' : 'disabled' }}>Finish!</button> -->
                            <button class="btn btn-warning btn-md pull-left" type="button" wire:click="previousRequestStep">Back</button>
                        </div>
                    </div>
                
            </div>

        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">

// event to show users success message

window.addEventListener('swal:modal', event => { 

    swal.fire({

        title: event.detail.message,

        text: event.detail.text,

        icon: event.detail.type,

    });

});

//event to ask user for confirmation

    window.addEventListener('swal:confirmStep2', event => { 

        swal.fire({

            title: event.detail.title,

            text: event.detail.message,

            icon: event.detail.type,

            buttons: true,

            dangerMode: true,

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#aaa',

            confirmButtonText: 'Confirm!'

            })

            .then((result) => {
            //if user clicks on delete
                    if (result.value) {
                // calling destroy method to delete
                        @this.call('secondStepConfirmSave')
                // success response

                    } else {


                    }
                });

    });

    //event to ask user for confirmation before deleting application

    window.addEventListener('swal:confirmDelete', event => { 

        swal.fire({

            title: event.detail.title,

            text: event.detail.message,

            icon: event.detail.type,

            buttons: true,

            dangerMode: true,

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#aaa',

            confirmButtonText: 'Confirm!'

            })

            .then((result) => {
            //if user clicks on delete
                    if (result.value) {
                // calling destroy method to delete
                        @this.call('deleteRequest')
                // success response

                    } else {


                    }
                });

        });

    window.addEventListener('swal:confirmStepFinal', event => { 

        swal.fire({

            title: event.detail.title,

            text: event.detail.message,

            icon: event.detail.type,

            buttons: true,

            dangerMode: true,

            showCancelButton: true,

            confirmButtonColor: '#3085d6',

            cancelButtonColor: '#aaa',

            confirmButtonText: 'Confirm!'

            })

            .then((result) => {
            //if user clicks on delete
                    if (result.value) {
                // calling destroy method to delete
                        @this.call('submitFinalForm')
                // success response

                    } else {


                    }
                });

    });

</script>

</div>

