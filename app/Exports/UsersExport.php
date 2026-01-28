<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    public function __construct(public array $ids, public array $columns)
    {
    }

    public function headings(): array
    {
        return Arr::map($this->columns, function (string $value, string $key) {
            return ucfirst($value);
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::query()->whereIn('id', $this->ids)->select($this->columns)->get();
    }
}
