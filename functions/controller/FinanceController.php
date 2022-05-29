<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banks;
use App\Models\DebtFinanceList;
use Auth;
use Carbon\Carbon;

class FinanceController extends Controller
{

    public function addBank(Request $request)
    {
       
        if (Auth::user()->user_role == 'Client') {
            $bank_count = Banks::where('client_id', Auth::user()->client_id)->where('name', trim($request->bank_name))->count();
            if ($bank_count > 0) {
                $response = [
                    'success' => false,
                    'message' => 'Bank already exists'
                ];
            } else {
                $bank = new Banks;
                $bank->client_id = Auth::user()->client_id;
                $bank->name= trim($request->bank_name);
                $bank->save();

                $response = [
                    'success' => true,
                    'message' => 'Bank Added Successfully'
                ];
            }
        }else{
            $response = [
                'success' => false,
                'message' => 'Internal server error'
            ];
        }
        
        return response()->json($response, 200);
    }

    public function getBanks(Request $request)
    {
        $banks = Banks::where('client_id', Auth::user()->client_id)->get()->toArray();

        return response()->json([
            'success' => true,
            'banks' => $banks
        ], 200);
    }

    public function saveDebtFinanceData(Request $request)
    {
        
        // print_r($request->all());die;

        $debt_data = new DebtFinanceList;
        $debt_data->client_id = Auth::user()->client_id;
        $debt_data->bank = $request->selectedBank['value'];
        $debt_data->loan_type = $request->selectedLoanType['label'];
        $debt_data->principal_amount = $request->principleAmmount;
        $debt_data->finance_year = $request->paymentPeriod['year'] != '' ? $request->paymentPeriod['year']['value'] : 0;
        $debt_data->finance_month = $request->paymentPeriod['month'] != '' ? $request->paymentPeriod['month']['value'] : 0;
        $debt_data->bullet_loan_payment = $request->bulletLoanPayment;
        $debt_data->interest_rate = $request->interestRate;
        $debt_data->payment_frequency = $request->paymentFrequency['value'];        
        $debt_data->first_deb_repay_date = $request->firstDebtRepaymentDate ? Carbon::parse(strtotime($request->firstDebtRepaymentDate))->format('Y-m-d'): '';
        if (isset($request->interestPayDate)) {
            $debt_data->interest_pay_date =  $request->interestPayDate ? Carbon::parse(strtotime($request->interestPayDate))->format('Y-m-d') : '';
        }
        if (isset($request->dateOfFirstInterestPayment)) {
            $debt_data->date_of_first_interest_payment =  $request->dateOfFirstInterestPayment ? Carbon::parse(strtotime($request->dateOfFirstInterestPayment))->format('Y-m-d') : '';
        }
        $debt_data->shareholder_loan_check = $request->shareholderLoanCheck;
        $debt_data->pik_options_data = json_encode($request->pikOptionsData);
        $debt_data->payment_data = json_encode($request->all());
        $debt_data->save();

        if($debt_data){
            return response()->json([
                'success' => true,
                'debt_finance_id' => $debt_data->id
            ], 200);
        }
    }

    public function getDebtFinanceData($id)
    {
            if (Auth::user()->role == 'Client') {
                if (DebtFinanceList::where('id', $id)->where('client_id', Auth::user()->client_id)->count() > 0) {
                    $debt_finance_data = DebtFinanceList::with('bank:id,name')->where('id', $id)->where('client_id', Auth::user()->client_id)->first()->toArray();

                    if ($debt_finance_data) {
                        return response()->json([
                        'success' => true,
                        'finance_data' => $debt_finance_data
                    ], 200);
                    }
                }else {
                    return response()->json([
                        'error' => true,
                        'messsage' => 'Debt Finance Data Not Found'
                    ], 201);
                }
            } else {
                $debt_finance_data = DebtFinanceList::with('bank:id,name')->where('id', $id)->first()->toArray();
    
                if ($debt_finance_data) {
                    return response()->json([
                        'success' => true,
                        'finance_data' => $debt_finance_data
                    ], 200);
                }
            }
        
    }

    public function getDebtFinanceList(Request $request)
    {
        
        if (isset($request->id)) {
            if (DebtFinanceList::where('client_id', $request->id)->count() > 0) {
                $debt_finance_data = DebtFinanceList::with(['bank:id,name'])->where('client_id', $request->id)->orderBy('id', 'desc')->paginate(10);

                if ($debt_finance_data) {
                    return response()->json([
                        'success' => true,
                        'list' => $debt_finance_data
                    ], 200);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'messsage' => 'Debt Finance Data Not Found'
                ], 201);
            }
        }else{
            $debt_finance_data = DebtFinanceList::with(['bank:id,name'])->where('client_id', Auth::user()->client_id)->orderBy('id', 'desc')->paginate(10);

            if ($debt_finance_data) {
                return response()->json([
                    'success' => true,
                    'list' => $debt_finance_data
                ], 200);
            }
        }
    }

    public function deleteDebtFinanceData($id)
    {
        DebtFinanceList::where('id', $id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Debt Data Removed Successfully'
        ], 200);
        
    }
}
