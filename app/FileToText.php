<?php 
namespace App;
use Smalot\PdfParser\Parser;
use COM;

class FileToText
{
    private $pastpaper_extension,$pastpaper_name,$path;
 
    public function __construct($name,$extension)
    {
        $this->pastpaper_extension = '.'.$extension;
        $this->pastpaper_name = $name;
        $this->path = storage_path('app/storage/pastpapers/');
    }
 
    public function convertToText()
    {
        if ($this->pastpaper_extension=='pdf') {
            return $this->PdfToText($this->path.$this->pastpaper_name);
        } else {
            $convert_to_pdf =  $this->DocxToPdf();
            return $this->PdfToText($this->path.$convert_to_pdf);            
        }
    }
 
    private function PdfToText($pdf_file_name)
    {
        $parser = new Parser();
        $pdf_converter = $parser->parseFile($pdf_file_name);

        // Retrieve all pages from the pdf file.
        $pages  = $pdf_converter->getPages();

        $pastpaper_in_text = '';
        
        // Loop over each page to extract text.
        foreach ($pages as $page) {
            $pastpaper_in_text = $pastpaper_in_text.$page->getText();
        }
        return $pastpaper_in_text;
    }
 
    private function DocxToPdf()
    {
        $word = new COM("Word.Application") or die ("Could not initialise Object.");
        // set it to 1 to see the MS Word window (the actual opening of the document)
        $word->Visible = 0;
        // recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
        $word->DisplayAlerts = 0;
        // open the word 2007-2013 document 
        $word->Documents->Open($this->path.$this->pastpaper_name.$this->pastpaper_extension);
        // save it as word 2003
        $word->ActiveDocument->SaveAs($this->path.'new-'.$this->pastpaper_name.$this->pastpaper_extension);
        // convert word 2007-2013 to PDF
        $pdf_file_name = $this->pastpaper_name.'.pdf';
        $word->ActiveDocument->ExportAsFixedFormat($this->path.$pdf_file_name, 17, false, 0, 0, 0, 0, 7, true, true, 2, true, true, false);
        // quit the Word process
        $word->Quit(false);
        // clean up
        unset($word);
        
        return $pdf_file_name;
        
    }
}
