<?php

namespace App\Exports;

use App\Models\File\DistinguishedScholarship;
use App\Models\File\File;
use App\Traits\ExcelStyle;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DSExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    use ExcelStyle;

    protected $index = 1;

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Fetch the data for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return File::where('fileable_type', DistinguishedScholarship::class)
            ->whereIn('type', ['passport', 'rating_book', 'faculty_statement', 'department_recommendation'])
            ->orderByRaw("FIELD(status, 'pending', 'reviewed', 'approved', 'rejected')")
            ->get()
            ->groupBy('user_id');
    }

    /**
     * Define the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            '#',
            'Talaba nomi',
            'Pasport nusxasi',
            'Reyting daftarchasi',
            'Fakultet bayonnomasi',
            'Kafedra mudiri tavsiyanomasi',
            'Ariza holati',
        ];
    }

    /**
     * Map the data to the export file with index.
     *
     * @param $item
     * @return array
     */
    public function map($item): array
    {
        return [
            $this->index++, // Incrementing index
            $item[0]->user->fio(), // Talaba nomi
            $this->makeHyperLink($item[0]), // Pasport nusxasi
            $this->makeHyperLink($item[1]), // Reyting daftarchasi
            $this->makeHyperLink($item[2]), // Fakultet bayonnomasi
            $this->makeHyperLink($item[3]), // Kafedra mudiri tavsiyanomasi
            $item[0]->status()['name'], // Ariza holati
        ];
    }

    public function makeHyperLink($item)
    {
        $url = route('storage.download', ['uuid' => $item->uuid]);
        $label = $item->name;

        return '=HYPERLINK("' . $url . '", "' . $label . '")';
    }
}
