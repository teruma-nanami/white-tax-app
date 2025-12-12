<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxFilingData extends Model
{
    use HasFactory;

    protected $table = 'tax_filing_data';

    protected $fillable = [
        'user_id',
        'ledger_id',

        // 給与関連
        'salary_income',
        'salary_withholding_tax',
        'salary_social_insurance_paid',
        'salary_life_insurance_ded',
        'salary_earthquake_insurance_ded',
        'salary_dependents_count',
        'salary_spouse_ded_applied',
        'salary_commute_allowance_non_taxable',
        'salary_other_deductions',

        // 所得控除
        'life_insurance_general',
        'life_insurance_medical',
        'life_insurance_pension',
        'social_insurance_ded',
        'medical_expense_ded',
        'donation_ded',
        'spouse_deduction_applied',
        'dependent_count',
        'small_enterprise_mutual_aid',
        'ideco_contributions',

        // 住宅ローン控除 + その他
        'home_loan_year_end_balance',
        'home_loan_deduction_amount',
        'home_loan_type',
        'home_loan_year_number',
        'misc_deductions',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
}
