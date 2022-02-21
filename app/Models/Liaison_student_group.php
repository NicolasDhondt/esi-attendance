<?php

namespace App\Models;

use App\Traits\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liaison_student_group extends Model
{
    use HasCompositePrimaryKey;
    protected $table = 'liaison_student_group';
    protected $primaryKey = ['id', 'studentId'];
    public $incrementing = false;
    public $timestamps = false;
    use HasFactory;
    //Add into the database a liaison between a groupe and a student if it doesn't already exist.
    public static function addLiaison($matricules,$groupes){
        for ($i = 0; $i < sizeof($matricules); $i++) {
            $group = Group::where('acronym', $groupes[$i])->get()->first();

            $liaisionExist = Liaison_student_group::where([
                ['studentId', $matricules[$i]],
                ['id', $group->id],
            ])->get()->first();

            if ($liaisionExist === null) {
                $liaison = new Liaison_student_group();
                $liaison->id = $group->id;
                $liaison->studentId = $matricules[$i];
                $liaison->save();
            }
        }
    }
}
