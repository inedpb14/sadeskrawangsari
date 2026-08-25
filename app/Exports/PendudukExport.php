<?php

namespace App\Exports;

use App\Models\Warga;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class PendudukExport extends DefaultValueBinder implements FromQuery, WithCustomValueBinder, WithHeadings, WithMapping
{
    use Exportable;

    protected $columns;

    protected $filters;

    public function __construct($columns, $filters = [])
    {
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Warga::query();

        if (! empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%$search%")
                    ->orWhere('nik', 'like', "%$search%");
            });
        }
        if (! empty($this->filters['agama'])) {
            $query->where('agama', $this->filters['agama']);
        }
        if (! empty($this->filters['status_perkawinan'])) {
            $query->where('status_perkawinan', $this->filters['status_perkawinan']);
        }
        if (! empty($this->filters['jenis_kelamin'])) {
            $query->where('jenis_kelamin', $this->filters['jenis_kelamin']);
        }

        return $query;
    }

    public function headings(): array
    {
        return array_map(function ($col) {
            return strtoupper(str_replace('_', ' ', $col));
        }, $this->columns);
    }

    public function map($warga): array
    {
        $data = [];
        foreach ($this->columns as $col) {
            $value = $warga->{$col} ?? '-';
            $data[] = $value;
        }

        return $data;
    }

    // Fungsi vital: Memaksa NIK dan No_KK menjadi tipe data STRING agar tidak berubah di Excel
    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value) && strlen($value) > 10) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
