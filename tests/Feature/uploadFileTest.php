<?php
namespace Tests\Feature;

    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithoutMiddleware;
    use Illuminate\Http\UploadedFile;
    use Illuminate\Support\Facades\Storage;
    use Tests\TestCase;

    class UploadedFileTest extends TestCase{

    /**
    *@test
    */
     public function test_import_groupes_from_csv_file()
        {
            $file = pathinfo("database/data/EtudiantsGroupesLast.csv");
            $result =  $file['basename'];
            $name = 'EtudiantsGroupTest.csv';
            $file_type=explode('.',$name);
            $file_type1=explode('.',$result);
            $this->assertEquals(end($file_type),end($file_type1));
        }

    /**
    *@test
    */
       public function test_import_groupes_from_another_file_type(){
              $file = pathinfo("database/data/EtudiantsGroupesLast.csv");
              $result =  $file['basename'];
              $name = 'EtudiantsGroupTest.txt';
              $file_type=explode('.',$name);
              $file_type1=explode('.',$result);
              $this->assertNotEquals(end($file_type),end($file_type1));
          }

      
    }
