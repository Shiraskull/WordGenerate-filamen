<?php

namespace App\Filament\Resources\WordGenerateResource\Pages;

use App\Filament\Resources\WordGenerateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;

class CreateWordGenerate extends CreateRecord
{
    protected static string $resource = WordGenerateResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $title = $data['judul'];
        $latar = $data['latar_belakang'];
        $tujuan = $data['tujuan'];
        $strategis = $data['strategis'];
        $demografi = $data['demografi'];
        // dd($latar);
        // $hasTr = preg_match('/<p\b[^>]*>/i', $latar);
        // $paragraphs = explode("<p>", $latar);

        // dd($latar,$paragraphs,$hasTr);
        // Create a new PHPWord object
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Function to process text and add content to the document
        function processText($item, $section) {
            $paragraphs = explode("\n", $item);
            // dd($paragraphs);
            $table = null;
            $Widhtcoll=[];

            foreach ($paragraphs as $value) {
                // Check for table, row, cell, image, and paragraph
                $hasTable = preg_match('/<table\b[^>]*>/i', $value);
                $hasTr = preg_match('/<tr\b[^>]*>/i', $value);
                $hasTd = preg_match('/<td\b[^>]*>/i', $value);
                $hasImg = preg_match('/<img\s[^>]*>/i', $value);
                $hasP = preg_match('/<p\b[^>]*>/i', $value);


                if ($hasImg) {
                    preg_match('/width="([^"]*)"/i', $value, $widthMatches);
                    $width = $widthMatches[1] ?? null;
                    preg_match('/src="([^"]*)"/i', $value, $srcs);
                    $src = $srcs[1] ?? null;
                    preg_match('/height="([^"]*)"/i', $value, $heightMatches);
                    $height = $heightMatches[1] ?? null;

                    $section->addImage(public_path($src), [
                        'width' => $width,
                        'height' => $height,
                        'align' => 'right',
                        // 'wrappingStyle' => 'infront',
                    ]);
                } elseif ($hasTable) {
                    // dd($value);
                    $Widhtcoll = widthTable($value);
                    // dd($widthTable);
                    // $collWidht=[];

                    $tableStyle = array(
                        'borderColor' => 'black',
                        'borderSize'  => 6,
                        'cellMargin'  => 50,
                        // 'width' => $widthTable,
                    );
                    $table = $section->addTable($tableStyle);
                    // $table->addRow();
                    // $table->addCell(200);
                    // dd($collWidht);

                }
                 elseif ($hasTr && $table) {
                     $table->addRow();

                    }
                    elseif ($hasTd && $table) {
                        // dd($Widhtcoll[0]);
                        $cellContent = preg_replace('/<td\b[^>]*>|<\/td>/i', '', $value);
                        if (isset($Widhtcoll[0])) {
                            $w = $Widhtcoll[0];
                            $table->addCell($w)->addText($cellContent == '&nbsp;' ? '' : $cellContent);
                            unset($Widhtcoll[0]);
                            $Widhtcoll = array_values($Widhtcoll);
                        } else {
                            // Tangani kasus di mana $Widhtcoll[0] tidak ada
                            $table->addCell()->addText($cellContent == '&nbsp;' ? '' : $cellContent);
                        }
                    } elseif ($hasP) {
                        Html::addHtml($section, $value);
                    }
                }
                // dd($Widhtcoll);
            }
            function widthTable($item){
                // dd($item);
                preg_match('/width:\s*([\d.]+%?)/i', $item, $widthMatches);
                preg_match_all('/<col\b[^>]*>/i', $item, $collWidht);
                $coll=[];

                $width =doubleval( str_replace('%','', $widthMatches[1]));
                $tableWidth = 9000 * ($width / 100);
                foreach($collWidht[0] as $value){
                    preg_match('/width:\s*([\d.]+%?)/i', $value, $widthMatches);
                    $col = doubleval( str_replace('%','', $widthMatches[1]));
                    $coll[]= $tableWidth * ($col / 100);

                }
                return $coll;
                // dd($coll,$collWidht);
            }

     // Process the content
        $section->addText('BAB I');
        $section->addText('Latar Belakang');
        processText($latar, $section);
        $section->addText('Tujuan');
        processText($tujuan, $section);
        $section->addText('Isu-Isu Strategis');
        processText($strategis, $section);
        $section->addText('Demografi Kabupaten Tangerang');
        processText($demografi, $section);
        // Save the document
        $Tword =$title . time() . '.docx';
        $phpWord->save($Tword);
        // dd('s');

        return [
            'kabupaten' => $title,
            // 'tanggal' => $data['tanggal'],
            // 'kepala_dinas' => '1',
            // 'foto_dinas' => '1',
            'latar_belakang' => $data['latar_belakang'],
            'tujuan' => $data['tujuan'],
            'path' => $Tword,
            'strategis' => $strategis,
            'demografi' => $demografi,
        ];
    }

}
