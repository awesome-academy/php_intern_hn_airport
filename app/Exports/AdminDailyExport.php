<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AdminDailyExport implements FromArray, WithHeadings
{
    protected $data;
    
    public function __construct($data = [[]])
    {
        $this->data = $data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function array($data = [[]]): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            '#',
            trans('contents.common.form.pickup'),
            trans('contents.common.form.drop_off'),
            trans('contents.common.form.datetime'),
            trans('contents.common.table.car_type'),
            trans('contents.common.form.price'),
        ];
    }
}
