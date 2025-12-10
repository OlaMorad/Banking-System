<?php

namespace App\Modules\Transactions\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'amount',
        'status',
        'approved_by',
        'type',
    ];

    // افتراضيًا، كل المعاملات جديدة Pending
    protected $attributes = [
        'status' => 'pending',
    ];

    /**
     * تعيين الموافقة على المعاملة
     */
    public function approveBy(string $role): self
    {
        $this->status = 'approved';
        $this->approved_by = $role;
        $this->save();
        return $this;
    }

    /**
     * رفض المعاملة
     */
    public function reject(string $reason): self
    {
        $this->status = 'rejected';
        $this->approved_by = $reason;
        $this->save();
        return $this;
    }
}
