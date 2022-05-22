<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banks;
use App\Models\FinanceList;
use Auth;

class FinanceController extends Controller
{
    public function addBank(Request $request)
    {
        $bank_count = Banks::where('user_id', Auth::id())->where('name', trim($request->bank_name))->count();
        if($bank_count > 0){
            return response()->json([
                'success' => false,
                'message' => 'Bank already exists'
            ], 201);
        }else{
            $bank = new Banks;
            $bank->user_id = Auth::id();
            $bank->name= trim($request->bank_name);
            $bank->save();

            return response()->json([
                'success' => true,
                'message' => 'Bank Added Successfully'
            ], 200);            
        }
    }

    public function getBanks(Request $request)
    {
        $banks = Banks::where('user_id', Auth::id())->get()->toArray();

        return response()->json([
            'success' => true,
            'banks' => $banks
        ], 200);
    }

    public function saveFinanceData(Request $request)
    {
      

        $finanace_data = new FinanceList;
        $finanace_data->user_id = Auth::id();
        $finanace_data->bank = $request->selectedBank['value'];
        $finanace_data->loan_type = $request->selectedLoanType['label'];
        $finanace_data->principal_amount = $request->principleAmmount;
        $finanace_data->finance_year = $request->paymentPeriod['year']['value'];
        $finanace_data->finance_month = $request->paymentPeriod['month']['value'];
        $finanace_data->bullet_loan_payment = $request->bulletLoanPayment;
        $finanace_data->interest_rate = $request->interestRate;
        $finanace_data->payment_frequency = $request->paymentFrequency['value'];
        $finanace_data->first_deb_repay_date = $request->firstFinanceRepaymentDate;
        $finanace_data->interest_pay_date = $request->interestPayDate;
        $finanace_data->date_of_first_interest_payment = $request->dateOfFirstInterestPayment;
        $finanace_data->shareholder_loan_check = $request->shareholderLoanCheck;
        $finanace_data->pik_options_data = json_encode($request->pikOptionsData);
        $finanace_data->payment_data = json_encode($request->all());
        $finanace_data->save();

        if($finanace_data){
            return response()->json([
                'success' => true,
                'finance_id' => $finanace_data->id
            ], 200);
        }
    }

    public function getFinanceData($id)
    {
            if (Auth::user()->role == 'Client') {
                if (FinanceList::where('id', $id)->where('user_id', Auth::id())->count() > 0) {
                    $finance_data = FinanceList::with('bank:id,name')->where('id', $id)->where('user_id', Auth::id())->first()->toArray();

                    if ($finance_data) {
                        return response()->json([
                        'success' => true,
                        'finance_data' => $finance_data
                    ], 200);
                    }
                }else {
                    return response()->json([
                        'success' => false,
                        'messsage' => 'Finance Finance Data Not Found'
                    ], 201);
                }
            } else {
                $finance_data = FinanceList::with('bank:id,name')->where('id', $id)->first()->toArray();
    
                if ($finance_data) {
                    return response()->json([
                        'success' => true,
                        'finance_data' => $finance_data
                    ], 200);
                }
            }
        
    }

    public function getFinanceList(Request $request)
    {
        if (isset($request->id)) {
            if (FinanceList::where('user_id', $request->id)->count() > 0) {
                $finance_data = FinanceList::with(['bank:id,name'])->where('user_id', $request->id)->orderBy('id', 'desc')->paginate(10);

                if ($finance_data) {
                    return response()->json([
                        'success' => true,
                        'list' => $finance_data
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'messsage' => 'Finance Finance Data Not Found'
                ], 201);
            }
        }else{
            $finance_data = FinanceList::with(['bank:id,name'])->where('user_id', Auth::id())->orderBy('id', 'desc')->paginate(10);

            if ($finance_data) {
                return response()->json([
                    'success' => true,
                    'list' => $finance_data
                ], 200);
            }
        }
    }

    public function deleteFinanceData($id)
    {
        FinanceList::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Finance Data Removed Successfully'
        ], 200);
        
    }
}
