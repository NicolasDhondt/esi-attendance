<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    use HasFactory;
    //Add a group to the database if it doesn't already exist.
    public static function addGroup($idList)
    {
        foreach ($idList as $acro) {
            $groupExist = Group::where('acronym', $acro)->get('group.acronym')->first();
            if ($groupExist === null) {
                $group = new Group();
                $group->acronym = $acro;
                $group->save();
            }
        }
    }

    /**
     * Method returning the groups of a student.
     */
    public static function getStudentGroup($studentId){
        $groups = Group::join('liaison_student_group','liaison_student_group.id','=','group.id')
            ->where('liaison_student_group.studentId',$studentId)->get();
        return $groups;
    }

    /**
     * Many to Many link
     */
    public function student(){
        return $this->belongsToMany(Student::class,'liaison_student_group','id','studentId');
    }
}
