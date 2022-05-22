<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceList extends Model
{
    use HasFactory;


    protected $table = "finance_list";

    protected $fillable = [
        'user_id',
        'bank',
        'loan_type',
        'principal_amount',
        'finance_year',
        'finance_month',
        'interest_rate',
        'bullet_loan_payment',
        'shareholder_loan_check',
        'pik_options_data',
        'payment_frequency',
        'first_deb_repay_date',
        'interest_pay_date',
        'date_of_first_interest_payment',
        'payment_data'
    ];

    public function client(){
        return $this->hasOne(Client::class,  'id', 'user_id');
    } 

    public function bank(){
        return $this->hasOne(Banks::class,  'id', 'bank');
    } 


}
