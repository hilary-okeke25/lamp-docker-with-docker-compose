<?
namespace SiteAgent\tests;


require_once("tests/helpers/cleaner.test.php");

use SiteAgent\helpers\WordpressPostContentToPlainJson;
 
class TestWpContentToJson {
 
    private $wpContentToJson;
    
    public function  __construct(){

        $this->wpContentToJson = new WordpressPostContentToPlainJson();
    }






    public function testThatWpContentIsConvertedToJSON($file_path){

        $testData = $this->getTestData($file_path); 
        $result = $this->wpContentToJson->doConversion($testData);

        //assert that no html tags inside and all is just plain string 

    }

    private function getTestData($file_path): array|false {
        if (!file_exists($file_path) || !is_readable($file_path)) {
            error_log("Error: Test data file not found or not readable at " .  $file_path);
            return false;
        }

        $data = [];
        $handle = fopen($file_path, "r");
        if ($handle) {
            $header = fgetcsv($handle); // Read the header row (optional)
            while (($row = fgetcsv($handle)) !== false) {
                if ($header && count($header) === count($row)) {
                    $data[] = array_combine($header, $row);
                } else {
                    $data[] = $row; // If no header or inconsistent row, just add as array
                }
            }
            fclose($handle);
            return $data;
        } else {
            error_log("Error: Could not open test data file for reading at " . $file_path);
            return false;
        }
    }

    
}
 

?>