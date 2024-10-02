<?php

namespace App\Imports;

use App\Models\Section;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
use Symfony\Component\HttpFoundation\Response;
class ImportUser implements ToCollection, WithHeadingRow
{


    /**
     * Handles importing the rows with image handling.
     *
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        $section = new Section();
        foreach ($rows as $row) {

            $section->category_name =  $row['category_name'];
            $section->image =  $row['image'];
            $section->status = '1';
            $section->show_on_menu = '1';
            $section->show_on_homepage = 1;

            $section->save();
            die;
        }
    }

}


