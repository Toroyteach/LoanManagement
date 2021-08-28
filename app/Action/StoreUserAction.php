<?php

namespace App\Action;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse; 

class StoreUserAction
{

    public function execute(Request $request, FirebaseService $service) : RedirectResponse
    {
        if($service->getUser($request->number)){

            return redirect()->back()->with('error','Failed to create user Firebase details conflict');

        }

        //get next of kin information


        $user = User::create($request->validated());
        UsersAccount::create([
            'total_amount' => 0.00,
            'user_id' => $user->id,
        ]);

        //add/deposit on the sacco account
        SaccoAccount::create([
            'opening_bal' =>  0.00,
            'deposit_bal' =>  $request->amount,
            'created_by' =>   \Auth::user()->id,
            'user_id' =>  $user->id,
        ]);

        MonthlySavings::create([
            'total_contributed' =>  0.00,
            'monthly_amount' =>  $request->monthly_amount,
            'created_by' =>   \Auth::user()->id,
            'user_id' =>  $user->id,
            'next_payment_date' => Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->firstOfMonth()->addDays(4)->addMonths(1)->format('Y-m-d'),
            'overpayment_amount' => 0.00,
        ]);

        NextKin::create([
            'name' => $request->kinname,
            'phone' => $request->kinphone,
            'relationship' => $request->kinrelationship,
            'user_id' => $user->id,
        ]);

        $uid = Str::random(20);

        $user->name = $request->firstname.' '.$request->lastname;
        $user->firebaseid = $uid;
        $user->save();
        $user->roles()->sync($request->input('roles', []));

            	// Handle the user upload of avatar
    	//if($request->hasFile('avatar')){
            
    		// $avatar = $request->file('avatar');
    		// $filename = time() . '.' . $avatar->getClientOriginalExtension();
    		// //Image::make($avatar)->resize(300, 300)->save('./uploads/avatars/' . $filename);
        
            // $avatar->move(public_path('/uploads/avatars/'), $filename);
            // //Storage::disk('public')->put($filename, $avatar);

    		// $user->avatar = $filename;
    		// $user->save();

            // $this->validate($request, [
            //     'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            // ]);
            // // Get image file
            // $image = $request->file('avatar');
            // // Make a image name based on user name and current timestamp
            // $name = Str::slug($request->input('lastname')).'_'.time();
            // // Define folder path
            // $folder = '/uploads/users/images/';
            // // Make a file path where image will be stored [ folder path + file name + file extension]
            // $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // // Upload image
            // //$this->uploadOne($image, $folder, 'public', $name);
            // $request->avatar->storeAs($filePath, $name . "." . $image->getClientOriginalExtension(), 'public');
            // // Set user profile image path in database to filePath
            // $user->avatar = $filePath;
            // $user->save();
            // //$request->avatar = $filePath;
            // //dd($filePath);
            // //$input['profile_image'] = $filePath;
            // //dd($input);

    	//}

        if ($request->has('avatar')) {
            $filename = time() . '_' . $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('profileavatar', $filename, 'uploads');
            $user->avatar = $filename;
    		$user->save();
        }

        //dd('saved');
        
        //dd('user created');
        //create base64 username/email and password 

        //create fiorebase calls to insert to firebase
        $userProperties = [
            'email' => $user->email,
            'emailVerified' => false,
            'phoneNumber' => '+'.$request->number,
            'password' => $request->password,
            'displayName' => $user->firstname.' '.$user->lastname,
            'photoUrl' => '',
            'disabled' => false,
            'uid' => $uid,
        ];
        //check if you can add extra field idno. you cant

        //dd($userProperties);

        $newUser = $service->createUser($userProperties);

        if(!$newUser){
            //dd('error creating new user');
            return redirect()->route('admin.users.index')->with('error','User created successfully!, Error creating firebase');

        } else {

            return redirect()->route('admin.users.index')->with('message','User created successfully!');

        }
    }
}