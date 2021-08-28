<?php

namespace App\Services;

use App\Contract\FirebaseContract;
use Kreait\Firebase\Exception\FirebaseException;
use Throwable;

class FirebaseService implements FirebaseContract
{
    protected $auth;
    protected $firestore;

    public function __construct()
    {
        $this->auth = app('firebase.auth');
        $this->firestore = app('firebase.firestore');

    }

    public function createUser($data)
    {
        //creates new firebase user
        //dd($data);

        try {
            // The operation you want to perform
            $create = $this->auth->createUser($data);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($create)){

                return false;

            } else {

                return true;

            }
        }

    }


    public function updateUser($data, string $id)
    {
        //updates user deatils on firebase

        //dd($id);



        $properties = [
            'email' => $data['email'],
            'phoneNumber' => '+254719273647',
            'password' => 'password',
            'displayName' => $data['name'],
        ];



        try {

            $updatedUser = $this->auth->updateUser($id, $properties);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;
            

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($updatedUser)){

                return false;

            } else {

                return true;
                
            }
        }
    }


    public function showUser(string $id)
    {
        //get users records from firebase
        try {

            $userById = $auth->getUser($id);
            $userByEmail = $auth->getUserByEmail('user@domain.tld');
            $userByNUmber = $auth->getUserByPhoneNumber('+49-123-456789');

        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

            echo $e->getMessage();

        } finally {

            if(empty($userById)){

                return $userById;

            } else {

                return false;

            }

        }

    }


    public function deleteUser(string $id)
    {
        //deletes/makes user disabled on firebase
        try {

            $updatedUser = $this->auth->disableUser($id);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($updatedUser)){

                return false;

            } else {

                return true;
                
            }
        }
        
    }

    public function disableUser(string $id)
    {
        //disables user from firebase
        //dd($id);
        try {

            $updatedUser = $this->auth->disableUser($id);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($updatedUser)){

                return false;

            } else {

                return true;
                
            }
        }
    }

    public function enableUser(string $id)
    {
        //disables user from firebase
        // dd($id);
        try {

            $updatedUser = $this->auth->enableUser($id);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($updatedUser)){

                return false;

            } else {

                return true;
                
            }
        }
    }

    public function getUser(string $id)
    {
        //gets user detsila and returns true if presesnt
        try {

            $user = $this->auth->getUserByPhoneNumber('+'.$id);

        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {

            //echo $e->getMessage();
            return false;

        } finally {

            if(empty($user)){

                return false;

            } else {

                return true;

            }

        }

    }


    public function createLoan($data)
    {
        //creates loan record of user on cloud firestore
         //dd($this->auth, $this->firestore);

        try {

            $loanDetails = $this->firestore->database()->collection('LoanRequest')->document($data['docID']);
            $loanDetails->set([
                'loanentrynumber' => $data['loanentrynumber'],
                'description' => $data['loandescription'],
                'amount' => $data['amount'],
                'created_at' => $data['created_at'],
                'user_id' => $data['id'],
                'status' => $data['status'],
                'approved' => false,
            ]);

        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;

        } finally {

            if(empty($loanDetails)){

                return false;

            } else {

                return true;
                
            }
        }

    }


    public function updateLoan($data, string $id)
    {
        //updates loan records on cloud firestore
        //dd($data, $id);
        try {


            $loan = $this->firestore->database()->collection('LoanRequest')->document($id)
            ->update([
                ['path' => 'status', 'value' => $data['status']],
                ['path' => 'approved', 'value' => $data['approved']]
            ]);


        } catch (FirebaseException $e) {

            echo 'An error has occurred while working with the SDK: '.$e->getMessage;
             \Log::info($e->getMessage);

        } catch (Throwable $e) {

            echo 'A not-Firebase specific error has occurred: '.$e->getMessage;
             \Log::info($e->getMessage);

        } finally {

            if(empty($loan)){

                return false;

            } else {

                return true;
                
            }
        }
        
    }


    public function deleteLoan(string $id)
    {
        //deletes loan records from firebase
    }
}
